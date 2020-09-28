<?php

declare(strict_types=1);

namespace App\Entities\Request;

class CityRequestEntity implements RequestEntityInterface
{
    public string $countryUuid;
    public string $name;
    public string $description;
}