<?php

declare(strict_types=1);

namespace Geo\Repositories;

use App\Entities\CountryEntity;
use App\Repositories\BaseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;
use Doctrine\Persistence\ObjectRepository;

final class CountryRepository extends BaseRepository implements CountryRepositoryInterface
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

    public function getCountries(string $prefix, int $count): array
    {
        $builder = $this->entityManager->getRepository(CountryEntity::class)
            ->createQueryBuilder('CountryEntity');
        $builder->setMaxResults($count);
        $builder->where('CountryEntity.name LIKE :prefix', )
            ->setParameter('prefix', "$prefix%");

        $query = $builder->getQuery();

        return $query->getResult();
    }
}
