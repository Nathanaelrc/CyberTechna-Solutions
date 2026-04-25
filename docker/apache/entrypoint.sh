#!/usr/bin/env bash
set -e

cd /var/www/html

if [ ! -f .env ] && [ -f .env.example ]; then
    cp .env.example .env
fi

set -a
. ./.env
set +a

if [ ! -f vendor/autoload.php ]; then
    composer install --no-interaction --prefer-dist
fi

mkdir -p storage/framework/cache storage/framework/sessions storage/framework/testing storage/framework/views bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache

rm -f bootstrap/cache/config.php bootstrap/cache/routes*.php bootstrap/cache/events.php

if grep -q '^APP_KEY=$' .env; then
    php artisan key:generate --force

    set -a
    . ./.env
    set +a
fi

until php artisan migrate --force; do
    echo "Database not ready, retrying..."
    sleep 3
done

php artisan db:seed --force

exec "$@"