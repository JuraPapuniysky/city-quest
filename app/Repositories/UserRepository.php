<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Entities\UserEntity;

final class UserRepository extends BaseRepository
{
    public function findUserEntityByUuid(string $uuid): ?UserEntity
    {
        return $this->entityManager->getRepository(UserEntity::class)->findOneBy([
            'uuid' => $uuid,
        ]);
    }

    public function findUserEntityByEmail(string $email): ?UserEntity
    {
        return $this->entityManager->getRepository(UserEntity::class)->findOneBy([
            'email' => $email,
        ]);
    }

    public function findUserEntityByRegistrationConfirmToken(string $registrationConfirmToken): ?UserEntity
    {
        return $this->entityManager->getRepository(UserEntity::class)->findOneBy([
            'registrationConfirmToken' => $registrationConfirmToken,
        ]);
    }
}
