<?php

declare(strict_types=1);

namespace App\Factories\Entity;

use App\Entities\Request\RequestEntityInterface;
use App\Entities\SessionEntity;
use App\Entities\UserEntity;
use PsrFramework\Adapters\JWT\JWTInterface;
use PsrFramework\Adapters\UuidGenerator\UuidGeneratorInterface;

class SessionEntityFactory
{
    private UuidGeneratorInterface $uuidGenerator;

    private JWTInterface $jwtCreator;

    public function __construct(UuidGeneratorInterface $uuidGenerator, JWTInterface $jwtCreator)
    {
        $this->uuidGenerator = $uuidGenerator;
        $this->jwtCreator = $jwtCreator;
    }

    public function create(RequestEntityInterface $requestEntity, UserEntity $userEntity): SessionEntity
    {
        $sessionEntity = new SessionEntity();
        $sessionEntity->setUuid($this->uuidGenerator->generate());
        $sessionEntity->setAccessToken($this->jwtCreator->encodeAccessToken([
            'email' => $userEntity->getEmail(),
        ]));
        $sessionEntity->setRefreshToken($this->jwtCreator->encodeRefreshToken([
            'email' => $userEntity->getEmail(),
            'fingerPrint' => $requestEntity->fingerPrint,
        ]));
        $sessionEntity->setUserUuid($userEntity->getUuid());
        $sessionEntity->setFingerPrint($requestEntity->fingerPrint);
        $sessionEntity->setCreatedAt(new \DateTime('now'));

        return $sessionEntity;
    }

    public function update(SessionEntity $sessionEntity, UserEntity $userEntity): SessionEntity
    {
        $sessionEntity->setAccessToken($this->jwtCreator->encodeAccessToken([
            'email' => $userEntity->getEmail()
        ]));
        $sessionEntity->setRefreshToken($this->jwtCreator->encodeRefreshToken([
            'email' => $userEntity->getEmail(),
            'fingerPrint' => $sessionEntity->getFingerPrint(),
        ]));
        $sessionEntity->setUpdatedAt(new \DateTime('now'));

        return $sessionEntity;
    }
}
