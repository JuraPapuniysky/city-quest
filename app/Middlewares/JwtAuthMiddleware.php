<?php

declare(strict_types=1);

namespace App\Middlewares;

use App\Entities\UserEntity;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Log\LoggerInterface;
use PsrFramework\Adapters\JWT\JWTInterface;

class JwtAuthMiddleware implements MiddlewareInterface
{
    public function __construct(
        private JWTInterface $jwtCreator,
        private EntityManagerInterface $entityManager,
        private LoggerInterface $logger
    )
    {
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $jwt = $request->getHeaderLine('Authorization');

        try {
            $payload = $this->jwtCreator->decode($jwt);
            $userEntity = $this->entityManager->getRepository(UserEntity::class)->findOneBy([
                'email' => $payload->data->email,
            ]);

            if ($userEntity === null) {
                throw new EntityNotFoundException('User not found', 412);
            }

            return $handler->handle($request->withAttribute(UserEntity::class, $userEntity));
        } catch (\Throwable $e) {
            $this->logger->error($e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);

            return $handler->handle($request->withAttribute(UserEntity::class, null)->withAttribute('authError', $e->getMessage()));
        }
    }
}
