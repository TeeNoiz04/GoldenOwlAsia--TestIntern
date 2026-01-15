#!/bin/sh

echo "=== Laravel starting ==="

php artisan key:generate --force || true
php artisan migrate --force || true
php artisan livewire:publish --force || true
php artisan filament:assets || true
php artisan optimize:clear || true

exec php -S 0.0.0.0:8080 -t public
