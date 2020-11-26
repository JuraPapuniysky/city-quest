<?php

declare(strict_types=1);

namespace PsrFramework\Adapters\PasswordHash;

interface PasswordHashInterface
{
    public function hash(string $password): string;

    public function check(string $password, string $passwordHash): bool;
}
