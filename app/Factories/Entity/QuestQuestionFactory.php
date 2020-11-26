<?php

declare(strict_types=1);

namespace App\Factories\Entity;

use App\Entities\QuestQuestionEntity;
use App\Entities\Request\QuestQuestionRequestEntity;
use PsrFramework\Adapters\UuidGenerator\UuidGeneratorInterface;

final class QuestQuestionFactory
{
    private UuidGeneratorInterface $uuidGenerator;

    public function __construct(UuidGeneratorInterface $uuidGenerator)
    {
        $this->uuidGenerator = $uuidGenerator;
    }

    public function create(QuestQuestionRequestEntity $requestEntity): QuestQuestionEntity
    {
        $entity = new QuestQuestionEntity();
        $entity->setUuid($this->uuidGenerator->generate());
        $entity->setCreatedAt(new \DateTime('now'));

        return $this->setAttributes($requestEntity, $entity);
    }

    public function update(
        QuestQuestionRequestEntity $requestEntity,
        QuestQuestionEntity $questQuestionEntity
    ): QuestQuestionEntity {
        $questQuestionEntity->setUpdatedAt(new \DateTime('now'));

        return $this->setAttributes($requestEntity, $questQuestionEntity);
    }

    private function setAttributes(
        QuestQuestionRequestEntity $requestEntity,
        QuestQuestionEntity $entity
    ): QuestQuestionEntity {
        $entity->setQuestUuid($requestEntity->questUuid);
        $entity->setDescription($requestEntity->description);
        $entity->setAnswer($requestEntity->answer);
        $entity->setType($requestEntity->type);

        return $entity;
    }
}
