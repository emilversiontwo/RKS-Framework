<?php

namespace Src\Core;

use Psr\Container\ContainerInterface;
use RequestParseBodyException;

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
     * @throws RequestParseBodyException
     */
    public function run(): void
    {
        $this->request->handleBodyRequest();
        echo $this->router->dispatch();
    }
}