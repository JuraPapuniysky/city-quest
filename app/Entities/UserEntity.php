<?php

declare(strict_types=1);

namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;
use PsrFramework\Services\CheckAuth\IdentityInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="users", options={"collate"="utf8mb4_unicode_ci", "charset"="utf8mb4"})
 */
class UserEntity implements IdentityInterface
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
     * @ORM\Column(type="string", name="full_name", unique=false, nullable=false)
     */
    private $fullName;

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
    private $isConfimed;

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

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function setUuid(string $uuid): void
    {
        $this->uuid = $uuid;
    }

    public function getFullName(): string
    {
        return $this->fullName;
    }

    public function setFullName(string $fullName): void
    {
        $this->fullName = $fullName;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getPasswordHash(): string
    {
        return $this->passwordHash;
    }

    public function setPasswordHash(string $passwordHash): void
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


    public function getIsConfirmed(): bool
    {
        return $this->isConfimed;
    }

    public function setIsConfirmed(bool $isConfimed): void
    {
        $this->isConfimed = $isConfimed;
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
