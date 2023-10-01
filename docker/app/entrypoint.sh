#!/bin/bash
set -e

# Set Laravel storage folder permissions
chown -R www-data:www-data /var/www/storage

composer install &&
php artisan cache:clear &&
php artisan view:cache &&
php artisan route:clear

# Start PHP-FPM
exec "$@"