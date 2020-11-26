<?php

declare(strict_types=1);

namespace PsrFramework\Factories;

use PsrFramework\Adapters\PasswordHash\PasswordHash;
use PsrFramework\Adapters\PasswordHash\PasswordHashInterface;

class PasswordHashFactory
{
    public function __invoke(): PasswordHashInterface
    {
        return new PasswordHash();
    }
}
