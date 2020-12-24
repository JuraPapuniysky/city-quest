<?php

declare(strict_types=1);

namespace Geo\Repositories;


use App\Entities\CityEntity;
use App\Entities\CountryEntity;

interface CountryRepositoryInterface
{
    /**
     * @param string $prefix
     * @param int $count
     * @return CountryEntity[]
     */
    public function getCountries(string $prefix, int $count): array;
}
