<?php

declare(strict_types=1);

namespace App\Entities;


use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 */
class UserEntity
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
     * @ORM\Column(type="string", unique=true, nullable=false)
     */
    private $email;

    /**
     * @ORM\Column(type="string", nullable=false, name="password_hash")
     */
    private $passwordHash;

    /**
     * @ORM\Column(type="string", nullable=true, name="registration_confirm_token")
     */
    private $registrationConfirmToken;

    /**
     * @ORM\Column(type="boolean", options={"default": false}, name="is_confirmed", nullable=true)
     */
    private $isConfimd;

    /**
     * @ORM\Column(type="datetime", name="created_at", nullable=true)
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", name="updated_at", nullable=true)
     */
    private $updatedAt;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getUuid()
    {
        return $this->uuid;
    }

    /**
     * @param mixed $uuid
     */
    public function setUuid($uuid): void
    {
        $this->uuid = $uuid;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email): void
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getPasswordHash()
    {
        return $this->passwordHash;
    }

    /**
     * @param mixed $passwordHash
     */
    public function setPasswordHash($passwordHash): void
    {
        $this->passwordHash = $passwordHash;
    }

    public function getRegistrationConfirmToken(): string
    {
        return $this->registrationConfirmToken;
    }

    public function setRegistrationConfirmToken(string $registrationConfirmToken): void
    {
        $this->registrationConfirmToken = $registrationConfirmToken;
    }


    public function getIsConfimd(): bool
    {
        return $this->isConfimd;
    }

    public function setIsConfimd(bool $isConfimd): void
    {
        $this->isConfimd = $isConfimd;
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getUpdatedAt(): \DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTime $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }
}