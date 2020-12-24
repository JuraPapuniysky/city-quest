<?php

declare(strict_types=1);

namespace Geo\Repositories;

use App\Entities\CityEntity;
use App\Entities\CountryEntity;

interface CityRepositoryInterface
{
    /**
     * @param CountryEntity $countryEntity
     * @param string $prefix
     * @param int $count
     * @return CityEntity[]
     */
    public function getCities(CountryEntity $countryEntity, string $prefix, int $count): array;
}
