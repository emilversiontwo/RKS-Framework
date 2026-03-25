<?php

namespace Src\Core\Router;

use Closure;
use Src\Core\Router\Enum\HttpMethodEnum;

class Route
{
    private string $name;
    private string $path;

    private array|HttpMethodEnum|null $methods;

    private Closure|string|array $action;

    private array|string $middleware;

    private array $wheres = [];        // ['id' => '\d+', 'slug' => '[a-z-]+']
    private array $defaults = [];      // ['page' => 1, 'lang' => 'en']
    private ?string $compiledRegex = null;   // кешированное итоговое регулярное выражение
    private array $parameterNames = [];      // порядок и имена параметров, ['id','slug']
    private array $optionalParameters = [];  // ['slug'] — параметры с ?

    public function __construct(string $path, Closure|string|array $action, array|HttpMethodEnum|null $methods)
    {
        $this->path = $path;
        $this->action = $action;
        $this->methods = $methods;
    }

    public function name(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function middleware(array|string $middleware): self
    {
        $this->middleware = $middleware;

        return $this;
    }

    public function where(string $param, string $regex): self
    {
        $this->wheres[$param] = $regex;
        return $this;
    }

    public function defaults(array $defaults): self
    {
        $this->defaults = $defaults;
        return $this;
    }

    public function setPath($path): self
    {
        $this->path = $path;
        return $this;
    }

    public function methods(): array
    {
        return $this->methods;
    }

    public function path(): string
    {
        return $this->path;
    }

    public function action(): callable|string|array
    {
        return $this->action;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getMiddleware(): array|string|null
    {
        return $this->middleware ?? null;
    }

    public function getWheres(): array
    {
        return $this->wheres;
    }

    public function getDefaults(): array
    {
        return $this->defaults;
    }

    public function parameterNames(array $params): self
    {
        $this->parameterNames = $params;
        return $this;
    }

    public function getParameterNames(): array
    {
        return $this->parameterNames;
    }
}