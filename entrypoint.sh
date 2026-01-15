#!/bin/sh

php artisan key:generate --force || true
php artisan migrate --force || true
php artisan livewire:publish --force || true
php artisan filament:assets || true
php artisan optimize:clear || true

php-fpm -D
nginx -g "daemon off;"
