<?php

declare(strict_types=1);

namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="countries", indexes={@ORM\Index(name="uuid", columns={"uuid"})}, options={"collate"="utf8mb4_unicode_ci", "charset"="utf8mb4"})
 */
class CountryEntity
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private ?int $id = null;

    /**
     * @ORM\Column(type="string", unique=true, nullable=false)
     */
    private ?string $uuid = null;

    /**
     * @ORM\Column(type="boolean", name="is_deleted", nullable=false, options={"default": false})
     */
    private ?bool $isDeleted = false;

    /**
     * @ORM\Column(type="datetime", name="created_at", nullable=true)
     */
    private ?\DateTime $createdAt;

    /**
     * @ORM\Column(type="datetime", name="updated_at", nullable=true)
     */
    private ?\DateTime $updatedAt;

    /**
     * @ORM\Column(type="text", name="name", nullable=false)
     */
    private ?string $name = null;

    /**
     * @ORM\Column(type="text", name="iso_code", nullable=false)
     */
    private ?string $isoCode = null;

    /**
     * @ORM\Column(type="text", name="description", nullable=true)
     */
    private ?string $description;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getUuid(): ?string
    {
        return $this->uuid;
    }

    public function setUuid(?string $uuid): void
    {
        $this->uuid = $uuid;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function getIsoCode(): ?string
    {
        return $this->isoCode;
    }

    public function setIsoCode(?string $isoCode): void
    {
        $this->isoCode = $isoCode;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function getIsDeleted(): ?bool
    {
        return $this->isDeleted;
    }

    public function setIsDeleted(?bool $isDeleted): void
    {
        $this->isDeleted = $isDeleted;
    }

    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTime $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }
}
