#!/bin/sh

# Navigate to the working directory
cd /var/www/html

# Install Composer dependencies
composer install --prefer-dist --no-interaction --no-scripts --no-progress

# Start PHP-FPM
php-fpm -F -O 2>&1 | tee /var/log/php-fpm.log
