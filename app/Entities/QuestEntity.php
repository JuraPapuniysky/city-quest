<?php

declare(strict_types=1);

namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="quests", indexes={@ORM\Index(name="uuid", columns={"uuid"})})
 */
class QuestEntity
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
    private ?bool $isDeleted;

    /**
     * @ORM\Column(type="text", name="description", nullable=false)
     */
    private ?string $description;

    /**
     * @ORM\Column(type="datetime", name="created_at", nullable=true)
     */
    private ?\DateTime $createdAt;

    /**
     * @ORM\Column(type="string", name="country_uuid" unique=false, nullable=false)
     */
    private ?string $countryUuid;

    /**
     * @ORM\Column(type="string", name="city_uuid" unique=false, nullable=false)
     */
    private ?string $cityUuid;

    /**
     * @ORM\Column(type="text", name="name", nullable=false)
     */
    private ?string $name = null;


    /**
     * @ORM\Column(type="datetime", name="updated_at", nullable=true)
     */
    private ?\DateTime $updatedAt;

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

    public function getCountryUuid(): ?string
    {
        return $this->countryUuid;
    }

    public function setCountryUuid(?string $countryUuid): void
    {
        $this->countryUuid = $countryUuid;
    }

    public function getCityUuid(): ?string
    {
        return $this->cityUuid;
    }

    public function setCityUuid(?string $cityUuid): void
    {
        $this->cityUuid = $cityUuid;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
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