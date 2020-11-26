<?php

declare(strict_types=1);

namespace App\Middlewares;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class CORSMiddleware implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: Content-type, Authorization, Origin, Cache-Control, User-Agent, Refresh-Token");
        header('Access-Control-Allow-Methods: GET,POST,PUT,DELETE,HEAD,OPTIONS');

        if ($request->getMethod() == 'OPTIONS') {
            exit(0);
        }

        return $handler->handle($request);
    }
}
