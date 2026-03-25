<?php

namespace Src\Core;

use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use ReflectionException;
use ReflectionMethod;
use RequestParseBodyException;
use Src\App\Controller\Error\ErrorController;
use Src\Core\Container\Container;
use Src\Core\Container\Exceptions\ContainerException;
use Src\Core\Container\Exceptions\ServiceNotFoundException;
use Src\Core\Router\Router;
use Src\Providers\interfaces\ServiceProviderInterface;

class Application
{
    public static Application $app;
    public ContainerInterface $container;

    public Response $response;
    public Router $router;
    public View $view;
    public Request $request;

    /**
     * @var array<ServiceProviderInterface>
     */
    private array $providers = [];
    protected string $uri;

    /**
     * @throws NotFoundExceptionInterface
     * @throws ContainerExceptionInterface
     * @throws ContainerException
     * @throws ReflectionException
     * @throws ServiceNotFoundException
     */
    public function __construct()
    {
        self::$app = $this;

        $this->container = new Container();

        $this->uri = $_SERVER['REQUEST_URI'];

        $this->request = new Request($this->uri);

        $this->response = new Response();

        require_once realpath(APP_PATH . '/Providers/Providers.php') ;

        foreach (self::$app->providers as $provider) {
            $provider->register();
        };

        $this->router = $this->container->get(Router::class);

        $this->view = $this->container->get(View::class);
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

        $routeMatch = $this->router->dispatch();
        //TODO call a Middlewares
        if ($routeMatch->isClosure()) {
            echo $routeMatch->callback->call($this, $routeMatch->params);
        } elseif ($routeMatch->isController()){
            $object = $this->container->get($routeMatch->callback[0]);
            $controllerMethod = new ReflectionMethod($object, $routeMatch->callback[1]);
            echo $controllerMethod->invoke($object, $routeMatch->params);
        } elseif (is_string($routeMatch->callback)) {
            echo ($routeMatch->callback)();
        } else {
            echo $this->container->get(ErrorController::class)->notFound();
        }
    }

    public function addProvider(ServiceProviderInterface $provider): void
    {
        app()->providers[] = $provider;
    }
}