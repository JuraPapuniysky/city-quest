<?php

declare(strict_types=1);

namespace PsrFramework\Adapters\UuidGenerator;

interface UuidGeneratorInterface
{
    public function generate(): string;
}
