<?php

declare(strict_types=1);

namespace App\Repositories;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;
use Doctrine\Persistence\ObjectRepository;

abstract class BaseRepository
{
    protected EntityManagerInterface $entityManager;

    protected ObjectRepository $repository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function findOneByCriteria(array $criteria): object
    {
        $object = $this->repository->findOneBy($criteria);

        if ($object === null) {
            throw new EntityNotFoundException($this->repository->getClassName(). ' not found');
        }

        return $object;
    }

    public function findAllByCriteria(array $criteria): array
    {
        return $this->repository->findBy($criteria);
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

    public function flash(): void
    {
        $this->entityManager->flush();
    }

}
