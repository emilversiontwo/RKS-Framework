<?php

use Src\App\Controller\HomeController;
use Src\App\Controller\UserController;
use Src\Core\Application;

/** @var Application $app */

$app->router->get('/', [HomeController::class, 'index']);

$app->router->get('/login', [UserController::class, 'loginIndex']);
$app->router->get('/login', [UserController::class, 'loginStore']);
$app->router->get('/register', [UserController::class, 'registerIndex']);
$app->router->get('/register', [UserController::class, 'registerStore']);

$app->router->get('/post/(?P<slug>[a-z0-9- ]+)/?', function () use ($app) {
    return '<p> Some content </p>';
});

$app->router->get('/assets/output.css', function () use ($app) {
    header("Content-Type: text/css");
    return file_get_contents("../public/assets/output.css");
});