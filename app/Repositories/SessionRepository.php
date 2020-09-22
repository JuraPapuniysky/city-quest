<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Entities\SessionEntity;
use App\Entities\UserEntity;
use Doctrine\Persistence\ObjectRepository;

final class SessionRepository extends BaseRepository
{
    public function findSessionByUserFingerPrint(UserEntity $userEntity, string $fingerPrint): ?SessionEntity
    {
        return $this->entityManager->getRepository(SessionEntity::class)->findOneBy([
            'userUuid' => $userEntity->getUuid(),
            'fingerPrint' => $fingerPrint,
        ]);
    }

    public function findSessionEntitiesByUser(UserEntity $userEntity): array
    {
        return $this->entityManager->getRepository(SessionEntity::class)->findBy([
            'userUuid' => $userEntity->getUuid(),
        ]);
    }
}