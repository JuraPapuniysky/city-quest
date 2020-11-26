<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Entities\QuestQuestionEntity;
use Doctrine\ORM\EntityManagerInterface;

class QuestQuestionRepository extends BaseRepository
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager);
        $this->repository = $this->entityManager->getRepository(QuestQuestionEntity::class);
    }
}
