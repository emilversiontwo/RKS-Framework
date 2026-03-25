<?php

namespace Src\Providers;

use Src\App\Controller\HomeController;
use Src\App\Controller\UserController;
use Src\Core\Container\Binding;
use Src\Core\Container\Enum\BindingTypeEnum;
use Src\Core\Request;
use Src\Core\Router\Router;
use Src\Core\View;
use Src\Providers\interfaces\ServiceProviderInterface;

class AppServiceProvider implements ServiceProviderInterface
{
    public function register(): void
    {
        app()->container->set(binding: new Binding(
            id: Router::class,
            scope: BindingTypeEnum::SHARED,
            arguments: [],
            concrete: Router::class
        ));
        app()->container->set(binding: new Binding(
            id: View::class,
            scope: BindingTypeEnum::SHARED,
            arguments: ['layout' => LAYOUT],
            concrete: View::class
        ));
        app()->container->set(binding: new Binding(
            id: Request::class,
            scope: BindingTypeEnum::INSTANCE,
            arguments: [],
            concrete: Request::class,
            instance: app()->request
        ));
        app()->container->set(binding: new Binding(
            id: HomeController::class,
            scope: BindingTypeEnum::PROTOTYPE,
            arguments: [],
            concrete: HomeController::class,
        ));
        app()->container->set(binding: new Binding(
            id: UserController::class,
            scope: BindingTypeEnum::PROTOTYPE,
            arguments: [],
            concrete: UserController::class,
        ));
    }
}