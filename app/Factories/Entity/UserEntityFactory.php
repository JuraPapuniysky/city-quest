<?php

declare(strict_types=1);

namespace App\Factories\Entity;

use App\Entities\Request\UserRequestEntity;
use App\Entities\UserEntity;
use PsrFramework\Adapters\PasswordHash\PasswordHashInterface;
use PsrFramework\Adapters\UuidGenerator\UuidGeneratorInterface;

final class UserEntityFactory
{
    private UuidGeneratorInterface $uuidGenerator;

    private PasswordHashInterface $passwordHash;

    public function __construct(UuidGeneratorInterface $uuidGenerator, PasswordHashInterface $passwordHash)
    {
        $this->uuidGenerator = $uuidGenerator;
        $this->passwordHash = $passwordHash;
    }

    public function create(UserRequestEntity $userRequestEntity): UserEntity
    {
        $userEntity = new UserEntity();
        $userEntity->setUuid($this->uuidGenerator->generate());
        $userEntity->setFullName($userRequestEntity->fullName);
        $userEntity->setEmail($userRequestEntity->email);
        $userEntity->setPasswordHash($this->passwordHash->hash($userRequestEntity->password));
        $userEntity->setRegistrationConfirmToken($this->uuidGenerator->generate());
        $userEntity->setCreatedAt(new \DateTime('now'));

        return $userEntity;
    }
}
