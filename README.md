# Rick and Morty API

Workshop project containing some of "Rick and Morty" characters, episodes, and locations. 

## Set up

 1. `$ docker-compose up -d`
 1. `$ docker exec -it php bash`
 1. `$ composer install`
 1. `$ bin/console doctrine:migrations:migrate`
 1. `$ bin/console doctrine:fixtures:load`
 1. `$ bin/phpunit`

