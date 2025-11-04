<?php

namespace Src\Core;

class Router
{
    protected array $routes = [];

    protected array $routeParams = [];

    public function __construct(
        protected Request $request,
        protected Response $response,
    ){}

    public function add($path, $callback, $method): self
    {
        $method = strtoupper($method);

        $this->routes[] = [
            'path' => $path,
            'callback' => $callback,
            'middleware' => null,
            'method' => $method,
            'needToken' => true,
        ];

        return $this;
    }

    public function getRoutes(): array
    {
        return $this->routes;
    }

    public function get($path, $callback): self
    {
        return $this->add($path, $callback, 'GET');
    }

    public function post($path, $callback): self
    {
        return $this->add($path, $callback, 'POST');
    }

    public function dispatch(): array
    {
        $path = $this->request->getPath();
        $route = $this->matchRoute($path);
        if (!$route) {
            abort('Page not found', 404 );
        }

        return $route;
    }

    public function matchRoute(string $path): ?array
    {
        foreach ($this->routes as $route) {
            if ($this->request->getReqMethod() === $route['method']) {
                if (preg_match("#^{$route['path']}$#", "/$path", $matches)) {
                    foreach ($matches as $key => $value) {
                        if (is_string($key)) {
                            $this->routeParams[$key] = $value;
                        }
                    }
                    return $route;
                }
            }
        }
        return null;
    }
}