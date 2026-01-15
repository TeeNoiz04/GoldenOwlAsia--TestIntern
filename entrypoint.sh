#!/bin/sh

echo "== Laravel booting =="

php artisan key:generate --force

php artisan migrate --force || true

php artisan livewire:publish --force

php artisan filament:assets || true

php artisan optimize:clear

exec "$@"
