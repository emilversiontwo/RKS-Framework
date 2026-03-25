<?php

namespace Src\Core\Router;

use Src\App\Controller\Error\ErrorController;
use Src\Core\Router\Enum\GroupAttributeEnum;
use Src\Core\Router\Enum\HttpMethodEnum;

final class Router
{
    private static Router $instance;
    private static array $groupStack = [];
    private RouteCollection $routeCollection;
    private RouteDispatcher $routeDispatcher;

    public function __construct(RouteCollection $routeCollection, RouteDispatcher $routeDispatcher)
    {
        self::$instance = $this;

        self::$instance->routeCollection = $routeCollection;

        self::$instance->routeDispatcher = $routeDispatcher;
    }

    public static function get(string $path, $action): Route
    {
        return self::addRoute(methods: HttpMethodEnum::GET, path: $path, action: $action);
    }

    /**
     * @param HttpMethodEnum|HttpMethodEnum[]|null $methods
     * @param string $path
     * @param $action
     * @return Route
     */
    public static function addRoute(HttpMethodEnum|array|null $methods, string $path, $action): Route
    {
        $route = new Route(path: $path, action: $action, methods: $methods);

        if (self::$groupStack) {
            $compilePath = "";

            foreach (self::$groupStack as $attributes) {
                foreach ($attributes as $key => $attribute) {
                    switch ($key) {
                        case GroupAttributeEnum::PREFIX->value:
                            $compilePath .= $attribute;
                            break;
                        case GroupAttributeEnum::MIDDLEWARE->value:
                            $route->middleware($attribute);
                            break;
                    }
                }
            }

            $route->setPath($compilePath . $path);
        }

        self::$instance->routeCollection->add($route);
        return $route;
    }

    public static function post(string $path, $action): Route
    {
        return self::addRoute(methods: HttpMethodEnum::POST, path: $path, action: $action);
    }

    public static function put(string $path, $action): Route
    {
        return self::addRoute(methods: HttpMethodEnum::PUT, path: $path, action: $action);
    }

    public static function patch(string $path, $action): Route
    {
        return self::addRoute(methods: HttpMethodEnum::PATCH, path: $path, action: $action);
    }

    public static function delete(string $path, $action): Route
    {
        return self::addRoute(methods: HttpMethodEnum::DELETE, path: $path, action: $action);
    }

    public static function any(string $path, $action): Route
    {
        return self::addRoute(methods: null, path: $path, action: $action);
    }

    /**
     * @param HttpMethodEnum[] $methods
     * @param string $path
     * @param $action
     * @return Route
     */
    public static function match(array $methods, string $path, $action): Route
    {
        return self::addRoute(methods: $methods, path: $path, action: $action);
    }

    public static function group(array $options, callable $callback): void
    {
        self::pushGroup($options);
        $callback();
        self::popGroup();
    }

    private static function pushGroup(array $attrs): void
    {
        self::$groupStack[] = $attrs;
    }

    private static function popGroup(): void
    {
        array_pop(self::$groupStack);
    }

    public function dispatch(): RouteMatch
    {
        $route = self::$instance->routeDispatcher->process(self::$instance->routeCollection->all());

        if ($route == null) {
            return new RouteMatch([ErrorController::class, 'notFound']);
        }
        $route_path = array_values(array_filter(explode('/', $route->path())));
        $path = app()->request->getSeparatedPath();
        $params = [];
        for ($i = 0; $i < count($path); $i++) {
            if (stripos($route_path[$i], '{') !== false || stripos($route_path[$i], '}') !== false) {
                $param = trim($route_path[$i], '{}');
                if (array_find($route->getParameterNames(), function (string $value) use ($param) {
                    return $value == $param;
                }) ?? false) {
                    $params[$param] = $path[$i];
                }
            }
        }

        return new RouteMatch(callback: $route->action(), params: $params, middleware: $route->getMiddleware());
    }
}