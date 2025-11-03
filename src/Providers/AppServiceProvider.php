<?php

namespace Src\Providers;

use Src\Core\Container\Binding;
use Src\Core\Container\Enum\BindingTypeEnum;
use Src\Core\Request;
use Src\Providers\interfaces\ServiceProviderInterface;

class AppServiceProvider implements ServiceProviderInterface
{
    public function register(): void
    {
        app()->container->set(binding: new Binding(
            id: Request::class,
            scope: BindingTypeEnum::INSTANCE,
            arguments: [],
            concrete: Request::class,
            instance: app()->request
        ));
    }
}