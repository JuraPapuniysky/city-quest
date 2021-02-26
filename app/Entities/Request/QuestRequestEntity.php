<?php

declare(strict_types=1);

namespace App\Entities\Request;

class QuestRequestEntity implements RequestEntityInterface
{
    public ?string $countryUuid;
    public ?string $cityUuid;
    public ?string $name;
    public ?string $description;

    /** @var QuestQuestionRequestEntity[] $questionEntities */
    public array $questionEntities = [];
}
