<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Entities\SessionEntity;
use App\Entities\UserEntity;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;

final class SessionRepository extends BaseRepository
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager);
        $this->repository = $this->entityManager->getRepository(SessionEntity::class);
    }

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
