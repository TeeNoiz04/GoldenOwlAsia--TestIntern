#!/bin/sh

php artisan key:generate --force

php artisan migrate --force || true

php artisan livewire:publish --force

php artisan optimize:clear

exec "$@"
