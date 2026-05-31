#!/bin/bash
set -e

php artisan config:clear
php artisan migrate --force
php artisan db:seed --class=CatalogImportSeeder --force
php artisan storage:link --force
php artisan optimize:clear
php artisan config:cache
php artisan event:cache
php artisan route:cache
php artisan view:cache
