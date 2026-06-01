#!/bin/bash
set -e

cd /app

export SESSION_DRIVER="${SESSION_DRIVER:-file}"
export CACHE_STORE="${CACHE_STORE:-file}"

mkdir -p storage/framework/views storage/framework/cache/data storage/framework/sessions storage/logs bootstrap/cache
chmod -R 775 storage bootstrap/cache

php artisan config:clear || true

if [ -f artisan ]; then
  php artisan package:discover --ansi || true
  php artisan storage:link --force || true
  php artisan migrate --force || true
  php artisan catalog:sync-media || true

  if [ "${SEED_ON_START:-true}" != "false" ] && [ -f database/data/catalog.json ]; then
    echo "Importing site data from catalog.json..."
    php artisan db:seed --class=CatalogImportSeeder --force
  fi
fi

exec php artisan serve --host=0.0.0.0 --port="${PORT:-8080}" --no-reload
