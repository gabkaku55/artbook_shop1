#!/bin/bash
set -e

cd /app

mkdir -p storage/framework/views storage/framework/cache/data storage/framework/sessions storage/logs bootstrap/cache
chmod -R 775 storage bootstrap/cache

php artisan config:clear || true

if [ -f artisan ]; then
  php artisan package:discover --ansi || true
  php artisan storage:link --force || true
  php artisan migrate --force || true
  php artisan catalog:sync-media || true

  # Git LFS may not be pulled on deploy — VideoProject1.mp4 is then a tiny pointer file
  hero="/app/public/video/VideoProject1.mp4"
  fallback="/app/public/video/video2tem.mp4"
  if [ -f "$fallback" ]; then
    size=0
    [ -f "$hero" ] && size=$(wc -c < "$hero" | tr -d ' ')
    if [ "$size" -lt 10000 ]; then
      cp "$fallback" "$hero"
      echo "Hero video: copied video2tem fallback (VideoProject1 LFS missing)."
    fi
  fi

  if [ "${SEED_ON_START:-true}" = "true" ]; then
    php artisan db:seed --class=CatalogImportSeeder --force || true
  fi
fi

exec php artisan serve --host=0.0.0.0 --port="${PORT:-8080}" --no-reload
