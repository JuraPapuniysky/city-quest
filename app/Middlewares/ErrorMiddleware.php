<?php

//declare(strict_types=1);

namespace App\Middlewares;

use App\Exceptions\AuthException;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Log\LoggerInterface;

class ErrorMiddleware implements MiddlewareInterface
{
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {
            return $handler->handle($request);
        }   catch (AuthException $e) {
            return new JsonResponse([
                'error' => $e->getMessage(),
            ], 412);
        } catch (\Throwable $e) {
            $this->logger->error($e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);

            return new JsonResponse([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
