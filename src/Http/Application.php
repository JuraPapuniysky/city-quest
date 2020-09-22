<?php

declare(strict_types=1);

namespace PsrFramework\Http;

use App\Middlewares\NotFoundHandler;
use Laminas\Stratigility\MiddlewarePipe;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use PsrFramework\Http\Router\Router;

class Application implements RequestHandlerInterface, MiddlewareInterface
{
    private ContainerInterface $container;

    private MiddlewarePipe $middlewarePipe;

    private NotFoundHandler $default;

    private Router $router;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->middlewarePipe = new MiddlewarePipe();
        $this->default = $this->container->get(NotFoundHandler::class);
        $this->router = $this->container->get(Router::class);
    }

    public function pipe(string $className): void
    {
        if ($this->container->has($className)) {
            $this->middlewarePipe->pipe($this->container->get($className));
        }
    }

    public function get(string $name, $pattern, array $handler): void
    {
        $this->router->get($name, $pattern, $handler);
    }

    public function post(string $name, $pattern, array $handler): void
    {
        $this->router->post($name, $pattern, $handler);
    }

    public function put(string $name, $pattern, array $handler): void
    {
        $this->router->put($name, $pattern, $handler);
    }

    public function patch(string $name, $pattern, array $handler): void
    {
        $this->router->patch($name, $pattern, $handler);
    }

    public function delete(string $name, $pattern, array $handler): void
    {
        $this->router->delete($name, $pattern, $handler);
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return $this->middlewarePipe->process($request, $this->default);
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        return $this->middlewarePipe->process($request, $handler);
    }
}