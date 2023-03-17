#!/bin/bash

if [ ! -f ".env" ];
then
    cp .env.example .env
fi

if [ ! -f "vendor/autoload.php" ];
then
    composer install --no-progress --no-interaction
fi

php artisan migrate --seed
php artisan key:generate
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan storage:link
php artisan serve --port=$PORT --host=0.0.0.0 --env=.env
exec docker-php-entrypoint "$@"

