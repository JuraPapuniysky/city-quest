<?php

declare(strict_types=1);

namespace App\Entities\Request;

class QuestRequestEntity implements RequestEntityInterface
{
    public $countryUuid;
    public $cityUuid;
    public $name;
    public $description;
}
