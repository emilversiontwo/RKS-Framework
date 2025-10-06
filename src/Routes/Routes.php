<?php

use Src\App\Controller\SomeController;
use Src\Core\Application;

/** @var Application $app */

$app->router->add('/test', [], 'get');

$app->router->get('/', [SomeController::class, 'index']);

$app->router->get('/post/(?P<slug>[a-z0-9- ]+)/?', function () use ($app) {
    return '<p> Some content </p>';
});