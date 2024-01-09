# laravel 10 game results

# Installation
+ To get started, the following steps needs to be taken:
+ Clone the repo.
+ `cd gr` to the project directory.
+ `cp src/.env.example src/.env` to use env config file
+ Run `docker-compose up -d` to start the containers.
+ Run `docker-compose exec php-fpm bash`
+ Run `composer install`
+ Run `php artisan migrate`
+ Run `php artisan db:seed`
+ Run `php artisan test`