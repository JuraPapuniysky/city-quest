<?php

declare(strict_types=1);

namespace Geo\Repositories;

use App\Entities\CityEntity;
use App\Entities\CountryEntity;
use App\Repositories\BaseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;

class CityRepository extends BaseRepository
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager);
        $this->repository = $this->entityManager->getRepository(CityEntity::class);
    }

    public function findOneByUuid(string $uuid): CityEntity
    {
        $city = $this->repository->findOneBy([
            'uuid' => $uuid,
            'isDeleted' => false,
        ]);

        if ($city === null) {
            throw new EntityNotFoundException('CityEntity not found');
        }

        return $city;
    }

    public function findAllByCountry(CountryEntity $country): array
    {
        return $this->repository->findBy([
            'countryUuid' => $country->getUuid(),
            'isDeleted' => false,
        ]);
    }
}
