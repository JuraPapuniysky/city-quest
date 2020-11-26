<?php

declare(strict_types=1);

namespace PsrFramework\Adapters\UuidGenerator;

use Ramsey\Uuid\Uuid;

class RamseyUuidAdapter implements UuidGeneratorInterface
{
    public function generate(): string
    {
        $uuid = Uuid::uuid6();

        return $uuid->toString();
    }
}
