<?php

declare(strict_types=1);

namespace PsrFramework\Http\Router;

use App\Entities\UserEntity;
use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use Invoker\InvokerInterface;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use PsrFramework\Services\CheckAuth\CheckAuthInterface;
use function FastRoute\simpleDispatcher;

class Router implements MiddlewareInterface
{
    private InvokerInterface $invoker;

    private RouteCollector $routerCollector;

    private CheckAuthInterface $checkAuthService;

    private array $routes = [];


    public function __construct(InvokerInterface $invoker, CheckAuthInterface $checkAuthService)
    {
        $this->invoker = $invoker;
        $this->checkAuthService = $checkAuthService;
    }

    public function get(string $name, string $pattern, array $handler, bool $auth = false): void
    {
        $this->routes[] = ['httpMethod' => 'GET', 'route' => $pattern, 'handler' => $handler, 'auth' => $auth];
    }

    public function post(string $name, string $pattern, array $handler, bool $auth = false): void
    {
        $this->routes[] = ['httpMethod' => 'POST', 'route' => $pattern, 'handler' => $handler, 'auth' => $auth];
    }

    public function put(string $name, string $pattern, array $handler, bool $auth = false): void
    {
        $this->routes[] = ['httpMethod' => 'PUT', 'route' => $pattern, 'handler' => $handler, 'auth' => $auth];
    }

    public function patch(string $name, string $pattern, array $handler, bool $auth = false): void
    {
        $this->routes[] = ['httpMethod' => 'PATCH', 'route' => $pattern, 'handler' => $handler, 'auth' => $auth];
    }

    public function delete(string $name, string $pattern, array $handler, bool $auth = false): void
    {
        $this->routes[] = ['httpMethod' => 'DELETE', 'route' => $pattern, 'handler' => $handler, 'auth' => $auth];
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $dispatcher = simpleDispatcher(function (RouteCollector $router) use ($request) {
            foreach ($this->routes as $route) {
                /*if ($route['auth'] === true) {
                    if ($request->getAttribute(UserEntity::class) !== null) {
                        $router->addRoute($route['httpMethod'], $route['route'], $route['handler']);
                    }

                    continue;
                }*/

                $router->addRoute($route['httpMethod'], $route['route'], $route['handler']);
            }
        });

        $httpMethod = $request->getMethod();
        $uri = $request->getUri()->getPath();

        if (false !== $pos = strpos($uri, '?')) {
            $uri = substr($uri, 0, $pos);
        }
        $uri = rawurldecode($uri);
        $routeInfo = $dispatcher->dispatch($httpMethod, $uri);

        switch ($routeInfo[0]) {
            case Dispatcher::NOT_FOUND:
                $code = 404;
                $message = 'Not found';

                return new JsonResponse($message, $code);
            case Dispatcher::METHOD_NOT_ALLOWED:
                $code = 403;
                $message = 'Method not allowed';

                return new JsonResponse($message, $code);
            case Dispatcher::FOUND:
                if ($this->searchRoute($routeInfo)['auth']) {
                    $this->checkAuthService->checkIdentity($request);
                }

                $controllerHandler = $routeInfo[1];
                $vars['request'] = $request;
                foreach ($routeInfo[2] as $varName => $value) {
                    $vars[$varName] = $value;
                }

                return $this->invoker->call($controllerHandler, $vars);
        }
    }

    private function searchRoute(array $routerInfo): array
    {
        foreach ($this->routes as $route) {
            $handler = $routerInfo[1];
            if ($route['handler'] === $handler) {
                return $route;
            }
        }
    }
}
