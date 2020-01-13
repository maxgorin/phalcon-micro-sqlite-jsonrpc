<?php

use Phalcon\Config;

require __DIR__ . '/src/config/defines.php';

/**
 * @var Config $config
 */
$config = require CONFIG_PATH . 'config.php';

$database = $config->database->sqlite;

return [
    'paths' => [
        'migrations' => '%%PHINX_CONFIG_DIR%%/db/migrations',
        'seeds' => '%%PHINX_CONFIG_DIR%%/db/seeds',
    ],
    'environments' => [
        'default_migration_table' => 'phinxlog',
        'default_database' => $database->dbname,
        'default' => [
            'adapter' => $database->adapter,
            'name' => $database->dbname,
            'suffix'=> $database->suffix,
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
        ],
    ],
];