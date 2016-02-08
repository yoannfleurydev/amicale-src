#!/bin/bash

composer install
php app/console doctrine:database:drop --force
php app/console doctrine:database:create
php app/console doctrine:schema:update --force
php app/console doctrine:fixtures:load -n

echo "Vous pouvez commencer à travailler"
