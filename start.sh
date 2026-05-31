#!/bin/bash
set -e

cd /app

php artisan config:clear || true

if [ -f artisan ]; then
  php artisan package:discover --ansi || true
  php artisan storage:link --force || true
  php artisan migrate --force || true
  php artisan catalog:sync-media || true

  if [ "${SEED_ON_START:-true}" = "true" ]; then
    php artisan db:seed --class=CatalogImportSeeder --force || true
  fi
fi

exec php artisan serve --host=0.0.0.0 --port="${PORT:-8080}" --no-reload
