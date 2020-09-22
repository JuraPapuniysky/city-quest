<?php

declare(strict_types=1);

namespace PsrFramework\Factories;

use PsrFramework\Adapters\UuidGenerator\RamseyUuidAdapter;
use PsrFramework\Adapters\UuidGenerator\UuidGeneratorInterface;

class UuidGeneratorFactory
{
    public function __invoke(): UuidGeneratorInterface
    {
        return new RamseyUuidAdapter();
    }
}