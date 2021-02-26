<?php

declare(strict_types=1);

namespace Quest\Factories\Entity\Request;

use App\Entities\Request\QuestQuestionRequestEntity;
use App\Entities\Request\QuestRequestEntity;
use Karriere\JsonDecoder\Bindings\ArrayBinding;
use Karriere\JsonDecoder\Bindings\FieldBinding;
use Karriere\JsonDecoder\ClassBindings;
use Karriere\JsonDecoder\Transformer;

class QuestRequestEntityTransformer implements Transformer
{

    public function register(ClassBindings $classBindings)
    {
        $classBindings->register(new ArrayBinding(
            'questionEntities',
            'questionEntities',
            QuestQuestionRequestEntity::class
        ));
    }

    public function transforms()
    {
        return QuestRequestEntity::class;
    }
}
