<?php

declare(strict_types=1);

namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="quest_questions", indexes={@ORM\Index(name="uuid", columns={"uuid"})})
 */
class QuestQuestionEntity
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
     * @ORM\Column(type="datetime", name="created_at", nullable=true)
     */
    private ?\DateTime $createdAt;

    /**
     * @ORM\Column(type="datetime", name="updated_at", nullable=true)
     */
    private ?\DateTime $updatedAt;

    /**
     * @ORM\Column(type="string", name="quest_uuid", unique=false, nullable=false)
     */
    private ?string $questUuid = null;

    /**
     * @ORM\Column(type="text", name="description", nullable=false)
     */
    private ?string $description;

    /**
     * @ORM\Column(type="string", name="type", nullable=false)
     */
    private ?string $type;

    /**
     * @ORM\Column(type="string", name="answer", nullable=false)
     */
    private ?string $answer;


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

    public function getQuestUuid(): ?string
    {
        return $this->questUuid;
    }

    public function setQuestUuid(?string $questUuid): void
    {
        $this->questUuid = $questUuid;
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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): void
    {
        $this->type = $type;
    }

    public function getAnswer(): string
    {
        return $this->answer;
    }

    public function setAnswer(string $answer): void
    {
        $this->answer = $answer;
    }
}