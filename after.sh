#!/bin/bash
set -e 

echo "Caching route and config"
php artisan route:cache
php artisan config:cache

echo "Migrating database 'php artisan migrate --force'..."
php artisan migrate --force

echo "Restart queue"
php artisan queue:restart
