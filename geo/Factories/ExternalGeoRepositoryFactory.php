<?php

declare(strict_types=1);

namespace Geo\Factories;

use Geo\Repositories\CityRepositoryInterface;
use Geo\Repositories\CountryRepositoryInterface;
use Geo\Repositories\ExternalGeoRepositories\RapidApiGeoRepository;

class ExternalGeoRepositoryFactory
{
    public function __construct(private RapidApiGeoRepository $rapidApiGeoRepository)
    {
    }

    public function createCountryRepository(): CountryRepositoryInterface
    {
        return $this->rapidApiGeoRepository;
    }

    public function createCityRepository(): CityRepositoryInterface
    {
        return $this->rapidApiGeoRepository;
    }
}
