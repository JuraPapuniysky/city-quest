<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Exceptions\ValidationException;
use App\Services\UserService;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class AuthController
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function registration(ServerRequestInterface $request): ResponseInterface
    {
        try {
            $this->userService->create($request);
        } catch (ValidationException $e) {
            return new JsonResponse([
                'status' => 'validation error',
                'errors' => $this->userService->getValidationErrors(),
            ], 400);
        }

        return new JsonResponse([
            'status' => 'success',
            'message' => 'Account created successfully. Please check your email to confirm.'
        ], 201);
    }

    public function auth(ServerRequestInterface $request): ResponseInterface
    {
        $sessionEntity = $this->userService->authUser($request);

        return new JsonResponse([
            'status' => 'sucsess',
            'accessToken' => $sessionEntity->getAccessToken(),
            'refreshToken' => $sessionEntity->getRefreshToken(),
        ], 201);
    }

    public function confirm(ServerRequestInterface $request, $confirmToken): ResponseInterface
    {

    }
}