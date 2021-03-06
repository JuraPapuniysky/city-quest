<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Entities\UserEntity;
use App\Exceptions\ValidationException;
use App\Factories\Entity\Request\RequestEntityFactoryInterface;
use App\Services\UserService;
use Doctrine\ORM\EntityNotFoundException;
use Firebase\JWT\ExpiredException;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class AuthController
{
    public function __construct(
        private UserService $userService,
        private RequestEntityFactoryInterface $requestEntityFactory
    ) {
    }

    public function registration(ServerRequestInterface $request): ResponseInterface
    {
        try {
            $this->userService->create($this->requestEntityFactory->create($request));
        } catch (ValidationException $e) {
            return new JsonResponse([
                'status' => 'validation error',
                'message' => $this->userService->getValidationErrors(),
            ], 400);
        }

        return new JsonResponse([
            'status' => 'success',
            'message' => 'Account created successfully. Please check your email to confirm.'
        ], 201);
    }

    public function confirm(ServerRequestInterface $request, $confirmToken): ResponseInterface
    {
        try {
            $this->userService->confirmUser($confirmToken);
        } catch (EntityNotFoundException $e) {
            return new JsonResponse([
                'status' => 'error',
                'message' => $e->getMessage(),
            ]);
        }

        return new JsonResponse([
            'status' => 'success',
            'message' => 'User confirmed',
        ], 201);
    }

    public function auth(ServerRequestInterface $request): ResponseInterface
    {
        $sessionEntity = $this->userService->authUser($request);

        return new JsonResponse([
            'status' => 'success',
            'accessToken' => $sessionEntity->getAccessToken(),
            'refreshToken' => $sessionEntity->getRefreshToken(),
        ], 201);
    }

    public function checkAccessToken(ServerRequestInterface $request): ResponseInterface
    {
        if ($request->getAttribute(UserEntity::class) !== null) {
            return new JsonResponse([
                'status' => 'success',
            ], 200);
        }

        return new JsonResponse([
            'status' => 'error',
            'request' => $request->getAttribute(UserEntity::class),
            'message' => $request->getAttribute('authError'),
        ], 412);
    }

    public function refresh(ServerRequestInterface $request): ResponseInterface
    {
        try {
            $session = $this->userService->refreshSession($request);
        } catch (ExpiredException $e) {
            return new JsonResponse([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 401);
        }

        return new JsonResponse([
            'status' => 'success',
            'accessToken' => $session->getAccessToken(),
            'refreshToken' => $session->getRefreshToken(),
        ]);
    }
}
