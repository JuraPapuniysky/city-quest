<?php

declare(strict_types=1);

namespace App\Middlewares;

use Laminas\Diactoros\Response\JsonResponse;
use phpDocumentor\Reflection\Types\Integer;
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
        } catch (\Throwable $e) {
            $this->logger->error($e->getMessage(), [
                'trace' => $e->getTrace()
            ]);

            $code = $e->getCode();

            if ((int)$code < 100) {
                $code = 500;
            }

            return new JsonResponse([
                'status' => 'error',
                'message' => $e->getMessage()
            ], (int)$code);
        }
    }
}
