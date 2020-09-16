#!/bin/bash
cd /var/www/app
# reset all files
# git reset --hard

# install project dependencies
composer install -q --no-ansi --no-interaction --no-scripts --no-progress --prefer-dist
# npm install

# copy environment variables
# cp .env.staging .env
# cp .env.production .env

# refresh all caches and generate new key
php artisan key:generate
php artisan optimize:clear
php artisan route:cache
php artisan view:cache
php artisan config:cache

# migrate database
php artisan migrate
#php artisan migrate:fresh --seed

# run project optimization
composer install --optimize-autoloader --no-dev

# set permissions
sudo chmod -R 775 /var/www/app
sudo chmod -R 777 storage bootstrap/cache
sudo chmod -R 600 storage/keys

# Generate API Documentation
php artisan l5-swagger:generate
