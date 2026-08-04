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

require_cmd() {
  if ! command -v "$1" >/dev/null 2>&1; then
    echo "'$1' not found on PATH." >&2
    echo "Install PHP 8.3 + Composer on the host (same as UGVOS), e.g.:" >&2
    echo "  sudo apt install php8.3-cli php8.3-fpm php8.3-mysql php8.3-xml php8.3-mbstring php8.3-curl php8.3-zip php8.3-gd php8.3-bcmath" >&2
    echo "  curl -sS https://getcomposer.org/installer | php && sudo mv composer.phar /usr/local/bin/composer" >&2
    exit 1
  fi
}

APP_DIR="$(resolve_app_dir)"
export APP_DIR

cd "$APP_DIR"
echo "==> App directory: $APP_DIR"

require_cmd php
require_cmd composer

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

if command -v sudo >/dev/null 2>&1; then
  sudo systemctl reload php8.3-fpm 2>/dev/null \
    || sudo systemctl reload php8.2-fpm 2>/dev/null \
    || sudo systemctl reload php-fpm 2>/dev/null \
    || true
fi

echo "Done. Site: ${APP_URL:-https://szpc.ugv.edu.bd}"
