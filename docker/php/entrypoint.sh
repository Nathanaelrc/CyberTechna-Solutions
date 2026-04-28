#!/usr/bin/env bash
set -e

cd /var/www/html

if [ ! -f .env ] && [ -f .env.example ]; then
    cp .env.example .env
fi

for key in APP_ENV APP_URL DB_CONNECTION DB_HOST DB_PORT DB_DATABASE DB_USERNAME DB_PASSWORD DB_ROOT_PASSWORD; do
    value="${!key:-}"

    if [ -z "$value" ] || [ ! -f .env ]; then
        continue
    fi

    escaped_value=${value//\\/\\\\}
    escaped_value=${escaped_value//&/\\&}
    escaped_value=${escaped_value//|/\\|}

    if grep -q "^${key}=" .env; then
        sed -i "s|^${key}=.*$|${key}=${escaped_value}|" .env
    else
        printf '%s=%s\n' "$key" "$value" >> .env
    fi
done

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

until php artisan migrate:status > /dev/null 2>&1; do
    echo "Database not ready, retrying..."
    sleep 3
done

php artisan migrate --force
php artisan db:seed --force

exec "$@"