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
use PsrFramework\Adapters\JWT\JWTInterface;

class JwtAuthMiddleware implements MiddlewareInterface
{
    private JWTInterface $jwtCreator;

    private EntityManagerInterface $entityManager;

    public function __construct(JWTInterface $jwtCreator, EntityManagerInterface $entityManager)
    {
        $this->jwtCreator = $jwtCreator;
        $this->entityManager = $entityManager;
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

            return $handler->handle($request->withAttribute('authUserEntity', $userEntity));
        } catch (\Throwable $e) {
            return $handler->handle($request->withAttribute('authUserEntity', null)->withAttribute('authError', $e->getMessage()));
        }
    }
}
