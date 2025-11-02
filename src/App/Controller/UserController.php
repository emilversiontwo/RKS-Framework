<?php

namespace Src\App\Controller;

use Src\Core\Request;

class UserController extends BaseController
{
    public function registerIndex()
    {
        return app()->view->setTitle('Регистрация')->render('users/register', [], 'default');
    }

    public function loginIndex()
    {
        return app()->view->setTitle('Вход')->render('users/login', [], 'default');
    }

    public function registerStore(Request $request)
    {

    }

    public function loginStore()
    {

    }
}