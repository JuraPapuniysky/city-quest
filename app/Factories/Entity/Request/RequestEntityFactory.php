<?php

declare(strict_types=1);

namespace App\Factories\Entity\Request;

use App\Entities\Request\RequestEntityInterface;
use Karriere\JsonDecoder\JsonDecoder;
use Psr\Http\Message\ServerRequestInterface;

class RequestEntityFactory implements RequestEntityFactoryInterface
{
    public function create(ServerRequestInterface $request, string $className): RequestEntityInterface
    {
        return (new JsonDecoder())->decode($request->getBody()->getContents(), $className);
    }
}