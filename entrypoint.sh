#!/bin/sh

echo "Running migrations..."
php artisan migrate --force || true

echo "Starting PHP server..."
exec php -S 0.0.0.0:$PORT -t public
