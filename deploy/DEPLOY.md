# SZPC full — VPS deployment

| Item | Value |
|------|--------|
| **Public URL** | https://szpc.ugv.edu.bd |
| **App path** | `/var/www/szpcfull` |
| **SSH** | `ssh -p 22 ugvdev@192.168.2.24` |
| **Admin** | `/admin` |
| **Docker app** | `127.0.0.1:8080` → nginx → public |

You may also have a clone under `~/szpcfull` on the server; production should track **`/var/www/szpcfull`** (or symlink `~/szpcfull` → `/var/www/szpcfull`).

## First-time server setup

```bash
sudo mkdir -p /var/www/szpcfull
sudo chown -R ugvdev:www-data /var/www/szpcfull   # adjust group to your php/nginx user

cd /var/www/szpcfull
git clone <repo-url> .   # or rsync from local

cp .env.example .env
nano .env
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

## Docker + nginx

```bash
cd /var/www/szpcfull/deploy
docker compose up -d

sudo cp nginx-szpcfull.conf /etc/nginx/sites-available/szpcfull
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
ssh -p 22 ugvdev@192.168.2.24
cd /var/www/szpcfull
bash deploy/post-deploy.sh
```

Or run steps manually: `composer install --no-dev`, `php artisan migrate --force`, `php artisan config:cache`, restart Docker.

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
