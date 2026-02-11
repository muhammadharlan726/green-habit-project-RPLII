#!/bin/bash
# Start script for Render

set -e

echo "Running migrations..."
php artisan migrate --force --no-interaction

echo "Caching configuration..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "Creating storage link..."
php artisan storage:link || true

echo "Starting application..."
php artisan serve --host=0.0.0.0 --port=${PORT:-8080}
