#!/usr/bin/env bash
set -euo pipefail

APP_DIR="${APP_DIR:-/var/www/szpcfull}"

cd "$APP_DIR"

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
if [ -d deploy ] && command -v docker >/dev/null; then
  (cd deploy && docker compose up -d)
fi

echo "Done. Site: ${APP_URL:-https://szpc.ugv.edu.bd}"
