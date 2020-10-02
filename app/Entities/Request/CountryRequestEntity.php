<?php

declare(strict_types=1);

namespace App\Entities\Request;

class CountryRequestEntity implements RequestEntityInterface
{
    public ?string $name = null;
    public ?string $isoCode = null;
    public ?string $description = null;
    public ?string $uuid = null;
}