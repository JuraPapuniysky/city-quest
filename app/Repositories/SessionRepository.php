<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Entities\SessionEntity;
use App\Entities\UserEntity;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;

final class SessionRepository extends BaseRepository
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager);
        $this->repository = $this->entityManager->getRepository(SessionEntity::class);
    }

    public function findSessionByUserFingerPrint(UserEntity $userEntity, string $fingerPrint): SessionEntity
    {
        $sessionEntity = $this->entityManager->getRepository(SessionEntity::class)->findOneBy([
            'userUuid' => $userEntity->getUuid(),
            'fingerPrint' => $fingerPrint,
        ]);

        if ($sessionEntity === null) {
            throw new EntityNotFoundException('Session entity not found');
        }

        return $sessionEntity;
    }

    public function findSessionEntitiesByUser(UserEntity $userEntity): array
    {
        return $this->entityManager->getRepository(SessionEntity::class)->findBy([
            'userUuid' => $userEntity->getUuid(),
        ]);
    }
}
