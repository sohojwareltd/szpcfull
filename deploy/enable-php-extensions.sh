#!/usr/bin/env bash
# Install PHP CLI/FPM packages + extensions needed by Laravel + Filament on Ubuntu/Debian.
# Usage (on the VPS):
#   bash deploy/enable-php-extensions.sh
#   sudo bash deploy/enable-php-extensions.sh

set -euo pipefail

if [ "$(id -u)" -ne 0 ]; then
  echo "Re-running with sudo..."
  exec sudo bash "$0" "$@"
fi

detect_php_version() {
  if command -v php >/dev/null 2>&1; then
    php -r 'echo PHP_MAJOR_VERSION.".".PHP_MINOR_VERSION;'
    return
  fi

  # Prefer newest available series (project requires ^8.3, so 8.5 is fine).
  for candidate in 8.5 8.4 8.3 8.2; do
    if apt-cache show "php${candidate}-cli" >/dev/null 2>&1; then
      echo "$candidate"
      return
    fi
  done

  echo "8.5"
}

PHP_VERSION="${PHP_VERSION:-$(detect_php_version)}"
PREFIX="php${PHP_VERSION}"

echo "==> PHP series: ${PHP_VERSION}"
echo "==> Updating apt indexes"
apt-get update -y

PACKAGES=(
  "${PREFIX}-cli"
  "${PREFIX}-fpm"
  "${PREFIX}-common"
  "${PREFIX}-curl"
  "${PREFIX}-mbstring"
  "${PREFIX}-xml"
  "${PREFIX}-zip"
  "${PREFIX}-bcmath"
  "${PREFIX}-gd"
  "${PREFIX}-intl"
  "${PREFIX}-mysql"
  "${PREFIX}-sqlite3"
  "${PREFIX}-readline"
  "unzip"
)

echo "==> Installing: ${PACKAGES[*]}"
DEBIAN_FRONTEND=noninteractive apt-get install -y "${PACKAGES[@]}"

if command -v phpenmod >/dev/null 2>&1; then
  echo "==> Enabling common modules"
  for mod in curl mbstring xml zip bcmath gd intl mysqli pdo_mysql fileinfo tokenizer openssl; do
    phpenmod -v "$PHP_VERSION" "$mod" 2>/dev/null || true
  done
fi

echo "==> Reloading PHP-FPM (if present)"
systemctl reload "${PREFIX}-fpm" 2>/dev/null \
  || systemctl restart "${PREFIX}-fpm" 2>/dev/null \
  || true

echo
echo "==> PHP binary: $(command -v php || true)"
php -v
echo
echo "==> Loaded extensions (key ones):"
php -m | grep -E '^(curl|mbstring|xml|dom|simplexml|zip|bcmath|gd|intl|pdo_mysql|mysqli|fileinfo|tokenizer|openssl|sqlite3)$' || true

MISSING=()
for ext in curl mbstring xml zip bcmath gd intl pdo_mysql fileinfo tokenizer openssl; do
  if ! php -m | grep -qi "^${ext}$"; then
    # xml often shows as dom/simplexml/xmlreader instead of "xml"
    if [ "$ext" = "xml" ]; then
      php -m | grep -qiE '^(dom|simplexml|xmlreader)$' && continue
    fi
    MISSING+=("$ext")
  fi
done

if [ "${#MISSING[@]}" -gt 0 ]; then
  echo
  echo "WARNING: still missing: ${MISSING[*]}"
  echo "Check: php --ini && ls /etc/php/${PHP_VERSION}/mods-available/"
  exit 1
fi

echo
echo "Done. Re-run: composer install --no-dev --optimize-autoloader --no-interaction"
