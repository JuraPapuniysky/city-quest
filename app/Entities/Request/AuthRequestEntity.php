<?php

declare(strict_types=1);

namespace App\Entities\Request;

class AuthRequestEntity implements RequestEntityInterface
{
    public string $email;
    public string $password;
    public string $fingerPrint;
}