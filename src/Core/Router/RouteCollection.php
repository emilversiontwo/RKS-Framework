<?php

namespace Src\Core\Router;

use Countable;
use IteratorAggregate;
use Traversable;

class RouteCollection implements Countable, IteratorAggregate
{
    /**
     * @var $routes Route[]
     */
    private array $routes = [];

    public function add(Route $route): void {
        $this->routes[] = $route;
    }

    /**
     * @return Route[]
     */
    public function all(): array {
        return $this->routes;
    }

    public function findByName(string $name): ?Route {
        return array_find($this->routes, fn($route) => $route->getName() == $name);
    }

    public function getIterator(): Traversable
    {
        // TODO: Implement getIterator() method.
    }

    public function count(): int
    {
        // TODO: Implement count() method.
    }
}