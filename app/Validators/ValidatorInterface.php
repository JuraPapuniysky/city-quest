<?php

declare(strict_types=1);

namespace App\Validators;

use App\Entities\Request\RequestEntityInterface;

interface ValidatorInterface
{
    public function validate(RequestEntityInterface $requestEntity): bool;

    public function errors(): array;
}