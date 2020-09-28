<?php

declare(strict_types=1);

namespace App\Factories\Entity;

use App\Entities\QuestEntity;
use App\Entities\Request\QuestRequestEntity;
use PsrFramework\Adapters\UuidGenerator\UuidGeneratorInterface;

final class QuestEntityFactory
{
    private UuidGeneratorInterface $uuidGenerator;

    public function __construct(UuidGeneratorInterface $uuidGenerator)
    {
        $this->uuidGenerator = $uuidGenerator;
    }

    public function create(QuestRequestEntity $requestEntity): QuestEntity
    {
        $questEntity = new QuestEntity();
        $questEntity->setUuid($this->uuidGenerator->generate());
        $questEntity->setCreatedAt(new \DateTime('now'));
        $questEntity = $this->setAttributes($requestEntity, $questEntity);

        return $questEntity;
    }

    public function update(QuestRequestEntity $requestEntity, QuestEntity $questEntity): QuestEntity
    {
        $questEntity = $this->setAttributes($requestEntity, $questEntity);
        $questEntity->setUpdatedAt(new \DateTime());

        return $questEntity;
    }

    private function setAttributes(QuestRequestEntity $requestEntity, QuestEntity $questEntity): QuestEntity
    {
        $questEntity->setCountryUuid($requestEntity->countryUuid);
        $questEntity->setCityUuid($requestEntity->cityUuid);
        $questEntity->setDescription($requestEntity->description);
        $questEntity->setName($requestEntity->name);

        return $questEntity;
    }

}