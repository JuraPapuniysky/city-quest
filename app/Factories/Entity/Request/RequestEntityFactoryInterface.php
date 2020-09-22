<?php

declare(strict_types=1);

namespace App\Factories\Entity\Request;

use App\Entities\Request\RequestEntityInterface;
use Psr\Http\Message\ServerRequestInterface;

interface RequestEntityFactoryInterface
{
    public function create(ServerRequestInterface $request, string $className): RequestEntityInterface;
}