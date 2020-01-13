#!/bin/bash

if [ ! -d vendor ]
then
    composer install --prefer-dist --no-interaction
else
    composer update --prefer-dist --no-interaction
fi

php src/main.php