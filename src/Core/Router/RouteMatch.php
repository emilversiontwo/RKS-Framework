<?php

namespace Src\Core\Router;

use Closure;
use ReflectionClass;
use ReflectionException;
use Src\Core\Controller;

class RouteMatch
{
    public array $middleware = [];

    public function __construct(
        public  string|Closure|array $callback,
        public  array $params = [],
        array|string|null $middleware = [],
    )
    {
        if ($middleware ?? false) {
            $this->middleware = is_string($middleware) ? [$middleware] : $middleware;
        }
    }

    public function isClosure(): bool
    {
        return $this->callback instanceof Closure;
    }

    /**
     * @throws ReflectionException
     */
    public function isController(): bool
    {
        if (is_array($this->callback)) {
            $reflection = new ReflectionClass($this->callback[0]);
            if ($reflection->isSubclassOf(Controller::class))
            {
                return true;
            }
        }
        return false;
    }
}