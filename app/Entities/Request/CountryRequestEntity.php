<?php

declare(strict_types=1);

namespace App\Entities\Request;

class CountryRequestEntity implements RequestEntityInterface
{
    public string $name;
    public string $isoCode;
    public string $description;
}