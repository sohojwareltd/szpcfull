# SZPC full — VPS deployment

| Item | Value |
|------|--------|
| **Public URL** | https://szpc.ugv.edu.bd |
| **App path** | `/var/www/szpcfull` **or** `~/szpcfull` (your VPS clone) |
| **SSH** | `ssh -p 22 ugvdev@192.168.2.24` |
| **Admin** | `/admin` |
| **Runtime** | Host **nginx + PHP-FPM** (same as UGVOS) |

You may also have a clone under `~/szpcfull` on the server; production should track **`/var/www/szpcfull`** (or symlink `~/szpcfull` → `/var/www/szpcfull`).

> Docker (`deploy/docker-compose.yml`) is optional and currently unreliable on this VPS (`runc` exit 127). Prefer native PHP-FPM.

## First-time server setup

```bash
sudo mkdir -p /var/www/szpcfull
sudo chown -R ugvdev:www-data /var/www/szpcfull

# PHP extensions (curl, mbstring, xml, zip, gd, intl, mysql, …)
bash deploy/enable-php-extensions.sh

# Composer (if missing)
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer

cd /var/www/szpcfull
# git clone <repo-url> .   # or rsync from local

cp .env.example .env
nano .env
composer install --no-dev --optimize-autoloader --no-interaction
php artisan key:generate
```

### Production `.env` essentials

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://szpc.ugv.edu.bd

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_DATABASE=...
DB_USERNAME=...
DB_PASSWORD=...

# REVE SMS (same as UGVOS)
REVE_SMS_API_KEY=...
REVE_SMS_SECRET_KEY=...
REVE_SMS_CALLER_ID=...
REVE_SMS_BASE_URL=http://sms.sasbulksms.com:3040

# Cloudflare Turnstile (production keys for szpc.ugv.edu.bd)
TURNSTILE_SITE_KEY=...
TURNSTILE_SECRET_KEY=...
```

## nginx + PHP-FPM

Confirm the PHP-FPM socket (must match `nginx-szpcfull.conf`):

```bash
ls /run/php/
# expect something like: php8.5-fpm.sock
```

```bash
sudo cp /var/www/szpcfull/deploy/nginx-szpcfull.conf /etc/nginx/sites-available/szpcfull
sudo ln -sf /etc/nginx/sites-available/szpcfull /etc/nginx/sites-enabled/
sudo nginx -t && sudo systemctl reload nginx
```

TLS (when DNS points to the server):

```bash
sudo certbot --nginx -d szpc.ugv.edu.bd
```

## Deploy updates

From your Mac (example):

```bash
rsync -avz --exclude node_modules --exclude vendor --exclude .env \
  ./ ugvdev@192.168.2.24:/var/www/szpcfull/
```

On the server:

```bash
cd /var/www/szpcfull
bash deploy/post-deploy.sh
```

## Smoke test

```bash
curl -I https://szpc.ugv.edu.bd/
curl -I https://szpc.ugv.edu.bd/register
php artisan sms:send 01XXXXXXXXX "SZPC deploy test"
```

## Local vs VPS

| | Local (Herd) | VPS |
|--|--|--|
| URL | `https://szpcfull.test` | `https://szpc.ugv.edu.bd` |
| Path | `~/Dev/laravel/szpcfull` | `/var/www/szpcfull` |
| PHP | Herd | Host PHP-FPM |

## Optional: Docker debug

If you still want to fix Docker later:

```bash
docker run --rm hello-world
sudo systemctl restart docker
docker compose -f deploy/docker-compose.yml up -d
```

If `hello-world` also fails with `runc` / exit 127, the host Docker install is broken — stay on PHP-FPM.
