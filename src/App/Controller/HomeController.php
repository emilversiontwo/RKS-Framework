<?php

namespace Src\App\Controller;

use Src\Core\View;

class HomeController extends BaseController
{
    public function index(): View|string
    {
        return app()
            ->view
            ->setTitle('Home')
            ->render(
                'home',
                ['name' => 'Djohn Doe'],
                'default'
            );
    }
}