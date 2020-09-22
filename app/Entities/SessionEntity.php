<?php

declare(strict_types=1);

namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="user_sessions", indexes={@ORM\Index(name="search_uuids", columns={"uuid", "user_uuid"})})
 */
class SessionEntity
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @ORM\Column(type="string", unique=true, nullable=false)
     */
    private $uuid;

    /**
     * @ORM\Column(type="string", name="user_uuid", unique=false, nullable=false)
     */
    private $userUuid;

    /**
     * @ORM\Column(type="text", name="access_token", nullable=false)
     */
    private $accessToken;

    /**
     * @ORM\Column(type="text", name="refresh_token", nullable=false)
     */
    private $refreshToken;

    /**
     * @ORM\Column(type="text", nullable=false, name="finger_print")
     */
    private $fingerPrint;

    /**
     * @ORM\Column(type="datetime", name="created_at", nullable=true)
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", name="updated_at", nullable=true)
     */
    private $updatedAt;


    public function getId()
    {
        return $this->id;
    }

    public function setId($id): void
    {
        $this->id = $id;
    }

    public function getUuid()
    {
        return $this->uuid;
    }

    public function setUuid($uuid): void
    {
        $this->uuid = $uuid;
    }

    public function getUserUuid()
    {
        return $this->userUuid;
    }

    public function setUserUuid($userUuid): void
    {
        $this->userUuid = $userUuid;
    }

    public function getAccessToken(): string
    {
        return $this->accessToken;
    }

    public function setAccessToken(string $accessToken): void
    {
        $this->accessToken = $accessToken;
    }

    public function getRefreshToken()
    {
        return $this->refreshToken;
    }

    public function setRefreshToken($refreshToken): void
    {
        $this->refreshToken = $refreshToken;
    }

    public function getFingerPrint()
    {
        return $this->fingerPrint;
    }

    public function setFingerPrint($fingerPrint): void
    {
        $this->fingerPrint = $fingerPrint;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function setCreatedAt($createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt($updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }
}
