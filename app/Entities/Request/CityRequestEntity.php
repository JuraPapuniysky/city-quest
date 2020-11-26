<?php

declare(strict_types=1);

namespace App\Entities\Request;

class CityRequestEntity implements RequestEntityInterface
{
    public ?string $countryUuid = null;
    public ?string $name = null;
    public ?string $description = null;
}
