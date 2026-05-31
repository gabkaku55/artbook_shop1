#!/bin/bash
set -e

cd /app

php artisan config:clear || true

# Відкриваємо порт одразу — Railway healthcheck і домен бачать живий сервіс
php artisan serve --host=0.0.0.0 --port="${PORT:-8080}" --no-reload &
SERVER_PID=$!

sleep 2

if [ -f artisan ]; then
  php artisan package:discover --ansi || true
  php artisan storage:link --force || true
  php artisan migrate --force || true
  php artisan catalog:sync-media || true

  if [ "${SEED_ON_START:-true}" = "true" ]; then
    php artisan db:seed --class=CatalogImportSeeder --force || true
  fi
fi

wait $SERVER_PID
