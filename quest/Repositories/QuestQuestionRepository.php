<?php

declare(strict_types=1);

namespace Quest\Repositories;

use App\Entities\QuestQuestionEntity;
use App\Repositories\BaseRepository;
use Doctrine\ORM\EntityManagerInterface;

class QuestQuestionRepository extends BaseRepository
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager);
        $this->repository = $this->entityManager->getRepository(QuestQuestionEntity::class);
    }
}
