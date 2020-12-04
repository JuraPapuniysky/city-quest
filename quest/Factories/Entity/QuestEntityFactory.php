<?php

declare(strict_types=1);

namespace Quest\Factories\Entity;

use App\Entities\QuestEntity;
use App\Entities\Request\QuestRequestEntity;
use App\Entities\UserEntity;
use PsrFramework\Adapters\UuidGenerator\UuidGeneratorInterface;

final class QuestEntityFactory
{
    public function __construct(private UuidGeneratorInterface $uuidGenerator)
    {
    }

    public function create(QuestRequestEntity $requestEntity, UserEntity $userEntity): QuestEntity
    {
        $questEntity = new QuestEntity();
        $questEntity->setUuid($this->uuidGenerator->generate());
        $questEntity->setCreatedAt(new \DateTime('now'));
        $questEntity = $this->setAttributes($requestEntity, $questEntity, $userEntity);

        return $questEntity;
    }

    public function update(
        QuestRequestEntity $requestEntity,
        QuestEntity $questEntity,
        UserEntity $userEntity
    ): QuestEntity {
        $questEntity = $this->setAttributes($requestEntity, $questEntity, $userEntity);
        $questEntity->setUpdatedAt(new \DateTime());

        return $questEntity;
    }

    private function setAttributes(
        QuestRequestEntity $requestEntity,
        QuestEntity $questEntity,
        UserEntity $userEntity
    ): QuestEntity {
        $questEntity->setUserUuid($userEntity->getUuid());
        $questEntity->setCountryUuid($requestEntity->countryUuid);
        $questEntity->setCityUuid($requestEntity->cityUuid);
        $questEntity->setDescription($requestEntity->description);
        $questEntity->setName($requestEntity->name);

        return $questEntity;
    }
}
