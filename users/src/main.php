<?php

use Phalcon\Di\FactoryDefault;
use Phalcon\Mvc\Micro\Collection;
use Users\Application\MicroSwooleJsonRpcApplication;

require __DIR__ . '/config/defines.php';

$config = require CONFIG_PATH . 'config.php';

require VENDOR_PATH . 'autoload.php';

$container = new FactoryDefault();

require CONFIG_PATH . 'services.php';

$app = new MicroSwooleJsonRpcApplication('0.0.0.0', 8010, $container);

$container->set('application', $app);

$users = new Collection();

$users->setHandler(new \Users\Controllers\UsersController())
    ->post('authorization', 'authorization');

$app->mount($users);

$app->start();