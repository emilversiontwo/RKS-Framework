<?php

namespace Src\App\Controller\Error;

use Src\Core\Controller;
use Src\Core\View;

class ErrorController extends Controller
{
    public function notFound(): View|string
    {
        return app()->view->setTitle('Not Found')->render('errors/404', [], 'default');
    }
}