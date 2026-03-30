<?php

namespace Src\Core\Router;

use Src\Core\Request;

final readonly class RouteDispatcher
{
    public function __construct(
        private Request $request
    )
    {
    }

    /**
     * @param array<Route> $routes
     * @return Route|null
     */
    public function process(array $routes): ?Route
    {
        $path = $this->request->getSeparatedPath();

        foreach ($routes as $route) {
            if (!str_starts_with($route->path(), '/')) {
                $route->setPath('/' . $route->path());
            }

            $route_path = array_values(array_filter(explode('/', $route->path())));
            if (count($route_path) > count($path) || count($route_path) < count($path)) {
                continue;
            }
            $pathCount = count($path);

            if ($pathCount === 0 && count($route_path) === 0) {
                return $route;
            }

            for ($i = 0; $i < $pathCount; $i++) {
                if (stripos($route_path[$i], '{') !== false || stripos($route_path[$i], '}') !== false) {
                    $param = trim($route_path[$i], '{}');
                    if (
                        $pathCount - 1 == $i
                        && array_find(
                            $route->getParameterNames(),
                            function (string $value) use ($param) {
                                return $value == $param;
                            }) ?? false) {
                        return $route;
                    }
                } elseif ($route_path[$i] == $path[$i]) {
                    if ($pathCount - 1 == $i) {
                        return $route;
                    }
                } else {
                    break;
                }
            }
        }

        return null;
    }
}