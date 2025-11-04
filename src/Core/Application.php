<?php

namespace Src\Core;

use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use ReflectionException;
use ReflectionMethod;
use RequestParseBodyException;
use Src\Core\Container\Container;
use Src\Core\Container\Exceptions\ContainerException;
use Src\Core\Container\Exceptions\ServiceNotFoundException;

class Application
{
    public static Application $app;
    public ContainerInterface $container;

    public Response $response;
    public Router $router;
    public View $view;
    public Request $request;
    protected string $uri;

    public function __construct()
    {
        self::$app = $this;

        $this->container = new Container();

        $this->uri = $_SERVER['REQUEST_URI'];

        $this->request = new Request($this->uri);

        $this->response = new Response();

        $this->router = new Router($this->request, $this->response);

        $this->view = new View(LAYOUT);
    }

    /**
     * @throws ContainerException
     * @throws ServiceNotFoundException
     * @throws RequestParseBodyException
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws ReflectionException
     */
    public function run(): void
    {
        $this->request->handleBodyRequest();

        $matchController = $this->router->dispatch();

        require_once realpath(APP_PATH . '/Providers/Providers.php') ;

        if ($matchController['callback'] instanceof \Closure) {
            echo $matchController['callback']();
        }

        $object = $this->container->get($matchController['callback'][0]);


        $controllerMethod = new ReflectionMethod($object, $matchController['callback'][1]);

        echo $controllerMethod->invoke($object);
    }
}