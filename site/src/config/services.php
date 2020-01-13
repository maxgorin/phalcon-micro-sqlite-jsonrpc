<?php

use Phalcon\Mvc\View\Engine\Volt;
use Phalcon\Mvc\View\Simple;

$container->set('volt', function ($view) use ($container) {

    $volt = new Volt($view, $container);

    $volt->setOptions([
        'path' => function ($templatePath) {

            $dir = ROOT_PATH . '/cache/templates/';

            if (!is_dir($dir) && !mkdir($dir, 0755, true) && !is_dir($dir)) {
                throw new \RuntimeException(sprintf('Directory "%s" was not created', $dir));
            }

            return $dir . md5($templatePath) . '.compiled';
        },
    ]);

    return $volt;
});


$container->set('view', function () {
    $view = new Simple();

    $view->registerEngines([
        '.volt' => 'volt',
    ]);

    $view->setViewsDir(ROOT_PATH . 'src/views');

    return $view;
});