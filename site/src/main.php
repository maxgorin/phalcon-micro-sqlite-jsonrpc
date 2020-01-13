<?php

use Phalcon\Di\FactoryDefault;
use Phalcon\Mvc\Micro\Collection;

require __DIR__ . '/config/defines.php';

$config = require CONFIG_PATH . 'config.php';

require VENDOR_PATH . 'autoload.php';

$container = new FactoryDefault();

require CONFIG_PATH . 'services.php';

$app = new \Site\Application\MicroSwooleApplication('0.0.0.0', 8080, $container);

$container->set('application', $app);

$users = new Collection();

$users->setHandler(new \Site\Controllers\UsersController())
    ->mapVia('/', 'authorization', ['GET', 'POST']);

$app->mount($users);

$app->notFound(function () use ($app) {
    $app->response->setStatusCode(404, 'Not Found');
    return 'Nothing to see here. Move along....';
});

$app->start();