#!/bin/bash
cd /var/www/app
php artisan down --message="Project is updating with the new exciting features. Be patient!" --retry=60
