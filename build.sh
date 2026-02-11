#!/bin/bash
# Build script for Render

set -e

echo "Installing dependencies..."
composer install --optimize-autoloader --no-dev

echo "Setting up Laravel..."
php artisan config:clear
php artisan cache:clear

echo "Build complete!"
