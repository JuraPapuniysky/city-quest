<?php

declare(strict_types=1);

namespace Quest\Repositories;

use App\Entities\QuestEntity;
use App\Repositories\BaseRepository;
use Doctrine\ORM\EntityManagerInterface;

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
