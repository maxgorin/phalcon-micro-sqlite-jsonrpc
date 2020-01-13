<?php

return new \Phalcon\Config([

    'database' => [
        'sqlite' => [
            'adapter' => 'sqlite',
            'suffix' => '.db',
            'dbname' => './db/users',
        ],
    ]

]);