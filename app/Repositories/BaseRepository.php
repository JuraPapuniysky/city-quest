<?php

declare(strict_types=1);

namespace App\Repositories;

use Doctrine\ORM\EntityManagerInterface;

abstract class BaseRepository
{
    protected EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function save(object $entity, bool $flash = true): void
    {
        $this->entityManager->persist($entity);

        if ($flash === true) {
            $this->entityManager->flush();
        }
    }

    public function delete(object $entity, bool $flash = true): void
    {
        $this->entityManager->remove($entity);

        if ($flash === true) {
            $this->entityManager->flush();
        }
    }
}