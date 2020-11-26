<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Entities\QuestEntity;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;

class QuestRepository extends BaseRepository
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager);
        $this->repository = $this->entityManager->getRepository(QuestEntity::class);
    }

    public function findAll(): array
    {
        return $this->repository->findAll();
    }
}
