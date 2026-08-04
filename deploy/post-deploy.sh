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

echo "==> Composer (production)"
composer install --no-dev --optimize-autoloader --no-interaction

echo "==> Laravel optimize"
php artisan migrate --force
php artisan storage:link --force 2>/dev/null || true
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan filament:optimize 2>/dev/null || true

echo "==> Permissions (adjust user/group if needed)"
chmod -R ug+rwX storage bootstrap/cache 2>/dev/null || true

echo "==> Restart app container (if using Docker)"
if [ -f "${SCRIPT_DIR}/docker-compose.yml" ] && command -v docker >/dev/null; then
  (cd "$SCRIPT_DIR" && docker compose up -d)
fi

echo "Done. Site: ${APP_URL:-https://szpc.ugv.edu.bd}"
