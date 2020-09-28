<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Entities\CountryEntity;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;
use Doctrine\Persistence\ObjectRepository;

final class CountryRepository extends BaseRepository
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager);
        $this->repository = $this->entityManager->getRepository(CountryEntity::class);
    }

    public function findAllCountries(): array
    {
        return $this->repository->findBy([
            'isDeleted' => false,
        ]);
    }

    public function findOneCountryByUuid(string $uuid): CountryEntity
    {
        $country = $this->repository->findOneBy([
            'uuid' => $uuid,
            'isDeleted' => false,
        ]);

        if ($country === null) {
            throw new EntityNotFoundException('Country not found');
        }

        return $country;
    }
}