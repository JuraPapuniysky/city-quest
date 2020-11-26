<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Services\HelloService;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class HelloController
{
    private HelloService $helloService;

    public function __construct(HelloService $helloService)
    {
        $this->helloService = $helloService;
    }

    public function index(ServerRequestInterface $request, string $name): ResponseInterface
    {
        return new JsonResponse([
            'message' => $this->helloService->sayHello($name),
            'authError' => json_encode($request->getAttribute('authError')),
        ], 200);
    }

    public function post(ServerRequestInterface $request): ResponseInterface
    {
        return new JsonResponse([
            'body' => json_decode($request->getBody()->getContents()),
            'authUser' => $request->getAttribute('authUser'),
        ], 200);
    }

    public function error(ServerRequestInterface $request): ResponseInterface
    {
        throw new \Exception('opps');
    }
}
