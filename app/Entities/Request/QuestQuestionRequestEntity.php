<?php

declare(strict_types=1);

namespace App\Entities\Request;

class QuestQuestionRequestEntity implements RequestEntityInterface
{
    public ?string $description;
    public ?string $type;
    public ?string $answer;
}
