<?php

declare(strict_types=1);

namespace App\Factories\Response;

use App\Exceptions\ValidationException;
use Doctrine\ORM\EntityNotFoundException;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;

abstract class AbstractResponseFactory
{
    public function notFound(EntityNotFoundException $e): JsonResponse
    {
        return new JsonResponse([
            'status' => 'error',
            'message' => $e->getMessage(),
        ], 404);
    }

    public function validationError(ValidationException $validationException): JsonResponse
    {
        return new JsonResponse([
            'status' => 'error',
            'description' => 'Validation',
            'message' => $validationException->getMessage(),
        ], 400);
    }

    public function deleted(): ResponseInterface
    {
        return new JsonResponse([
            'status' => 'success',
        ], 201);
    }
}