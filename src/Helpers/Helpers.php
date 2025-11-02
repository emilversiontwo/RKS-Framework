<?php

use JetBrains\PhpStorm\NoReturn;
use Src\Core\Application;
use Src\Core\Request;
use Src\Core\Response;
use Src\Core\View;

function app(): Application
{
    return Application::$app;
}

function request(): Request
{
    return app()->request;
}

function response(): Response
{
    return app()->response;
}

function view($view = '', $data = [], $layout = ''): string|View
{
    if ($view) {
        return app()->view->render($view, $data, $layout);
    }

    return app()->view;
}

#[NoReturn]
function abort($error = '', int $code = 404): void
{
    response()->setResponseCode($code);
    echo view("errors/$code", ['error' => $error], false);
    die;
}
