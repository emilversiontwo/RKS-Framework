<?php

use Src\App\Controller\HomeController;
use Src\App\Controller\UserController;
use Src\Core\Application;
use Src\Core\Router\Enum\GroupAttributeEnum;
use Src\Core\Router\Router;

/** @var Application $app */

Router::get('/', [HomeController::class, 'index'])->name('dashboard');

Router::get('/login', [UserController::class, 'loginIndex'])->name('login');
Router::post('/login', [UserController::class, 'loginStore'])->name('login.store');
Router::get('/register', [UserController::class, 'registerIndex'])->name('register');
Router::post('/register', [UserController::class, 'registerStore'])->name('register.store');
Router::get('/logout/{slug}', function (){
    echo 1;
})->name('test')->parameterNames(['slug']);

Router::get('/post/(?P<slug>[a-z0-9- ]+)/?', function () use ($app) {
    return '<p> Some content </p>';
})->name('some-route');

Router::get('/assets/output.css', function () use ($app) {
    header("Content-Type: text/css");
    return file_get_contents("../public/assets/output.css");
})->name('output-css');

Router::group([GroupAttributeEnum::PREFIX->value => '/test1', GroupAttributeEnum::MIDDLEWARE->value => 'auth'], function () {
    Router::get('/home', [HomeController::class, 'index']);
    Router::group([GroupAttributeEnum::PREFIX->value => '/test2'], function () {
        Router::get('/home2', [HomeController::class, 'index']);
    });
    Router::get('/home3', [HomeController::class, 'index']);
});
