<?php

declare(strict_types=1);

namespace Quest\Factories;

class QuestQuestionTypesFactory
{
    const TYPE_STRING = 'string';
    const TYPE_TEXT = 'text';

    public function questionTypes(): array
    {
        return [
            [
                'value' => self::TYPE_STRING,
                'description' => 'String',
            ],
            [
                'value' => self::TYPE_TEXT,
                'description' => 'Text',
            ],
        ];
    }
}
