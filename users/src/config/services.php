<?php

$container->set('db', function () use ($config) {

    return new \Phalcon\Db\Adapter\Pdo\Sqlite([
        'dbname' => $config->database->sqlite->dbname . $config->database->sqlite->suffix
    ]);

}, true);