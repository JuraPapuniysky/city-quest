<?php

declare(strict_types=1);

namespace PsrFramework\Adapters\PasswordHash;

class PasswordHash implements PasswordHashInterface
{

    public function hash(string $password): string
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public function check(string $password, string $passwordHash): bool
    {
        return password_verify($password, $passwordHash);
    }
}