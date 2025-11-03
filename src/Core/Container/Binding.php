<?php

namespace Src\Core\Container;

use Closure;
use Src\Core\Container\Enum\BindingTypeEnum;

class Binding
{
    public string $id;

    public BindingTypeEnum $scope;

    public array $arguments = [];

    public string|Closure|null $concrete = null;

    public ?object $instance = null;

    public ?Closure $callback = null;

    /**
     * @param string $id
     * @param BindingTypeEnum $scope
     * @param array $arguments
     * @param Closure|string|null $concrete
     * @param object|null $instance
     * @param Closure|null $callback
     */
    public function __construct(
        string $id,
        BindingTypeEnum $scope,
        array $arguments,
        Closure|string|null $concrete,
        ?object $instance = null,
        ?Closure $callback = null
    )
    {
        $this->id = $id;
        $this->scope = $scope;
        $this->arguments = $arguments;
        $this->concrete = $concrete;
        $this->instance = $instance;
        $this->callback = $callback;
    }

}