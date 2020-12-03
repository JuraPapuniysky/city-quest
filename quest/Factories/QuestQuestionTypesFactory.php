<?php

declare(strict_types=1);

namespace Quest\Factories;

class QuestQuestionTypesFactory
{
    const TYPE_STRING = 'string';

    public function questionTypes(): array
    {
        return [
            self::TYPE_STRING => 'String',
        ];
    }
}
