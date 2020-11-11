<?php

declare(strict_types=1);

namespace App\Entities\Request;

class UserRequestEntity implements RequestEntityInterface
{
    public string $fullName = '';
    public string $email = '';
    public string $password = '';
    public string $confirmPassword = '';
}
