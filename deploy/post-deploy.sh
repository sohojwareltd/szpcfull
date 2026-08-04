#!/usr/bin/env bash
set -euo pipefail

SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
DEFAULT_APP_DIR="$(cd "${SCRIPT_DIR}/.." && pwd)"

resolve_app_dir() {
  if [ -n "${APP_DIR:-}" ] && [ -d "$APP_DIR" ] && [ -f "$APP_DIR/artisan" ]; then
    echo "$APP_DIR"
    return
  fi

  for candidate in \
    "$DEFAULT_APP_DIR" \
    "${HOME}/szpcfull" \
    "/var/www/szpcfull"; do
    if [ -d "$candidate" ] && [ -f "$candidate/artisan" ]; then
      echo "$candidate"
      return
    fi
  done

  echo "Could not find Laravel app (artisan). Set APP_DIR or run from repo with deploy/post-deploy.sh." >&2
  exit 1
}

APP_DIR="$(resolve_app_dir)"
export APP_DIR

cd "$APP_DIR"
echo "==> App directory: $APP_DIR"

# Prefer host tools; fall back to the Docker app container (webdevops/php-nginx).
run_in_app() {
  if command -v "$1" >/dev/null 2>&1; then
    "$@"
    return
  fi

  if command -v docker >/dev/null 2>&1 && docker ps --format '{{.Names}}' 2>/dev/null | grep -qx 'szpcfull'; then
    echo "    (using docker exec szpcfull — host '$1' not found)"
    docker exec -w /app szpcfull "$@"
    return
  fi

  echo "Neither host '$1' nor running container 'szpcfull' is available." >&2
  echo "Install Composer/PHP on the host, or start Docker first:" >&2
  echo "  cd ${SCRIPT_DIR} && docker compose up -d" >&2
  exit 1
}

echo "==> Ensure Docker app is up (if compose is present)"
if [ -f "${SCRIPT_DIR}/docker-compose.yml" ] && command -v docker >/dev/null 2>&1; then
  (cd "$SCRIPT_DIR" && docker compose up -d)
fi

echo "==> Composer (production)"
run_in_app composer install --no-dev --optimize-autoloader --no-interaction

echo "==> Laravel optimize"
run_in_app php artisan migrate --force
run_in_app php artisan storage:link --force 2>/dev/null || true
run_in_app php artisan config:cache
run_in_app php artisan route:cache
run_in_app php artisan view:cache
run_in_app php artisan filament:optimize 2>/dev/null || true

echo "==> Permissions (adjust user/group if needed)"
chmod -R ug+rwX storage bootstrap/cache 2>/dev/null || true

echo "Done. Site: ${APP_URL:-https://szpc.ugv.edu.bd}"
