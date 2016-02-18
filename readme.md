# Accuweather Crawler


A simple Laravel 5.1 application which crawls through an accuweather link and pulls the temperature every hour.
To crawl I am using Goutte - https://github.com/FriendsOfPHP/Goutte

## Installation

cd into the project directory and run "composer install" then "composer update".
Create the tables: "php artisan migrate"
Setup a crontab to call the laravel scheduler every minute: contab -e then add "* * * * * php /path/to/artisan schedule:run >> /dev/null 2>&1"

## Official Documentation

Documentation for the framework can be found on the [Laravel website](http://laravel.com/docs).

## License

The Laravel framework is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
