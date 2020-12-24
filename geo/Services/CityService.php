<?php

declare(strict_types=1);

namespace Geo\Services;

use App\Entities\CityEntity;
use App\Entities\CountryEntity;
use App\Entities\Request\CityRequestEntity;
use App\Exceptions\ValidationException;
use Geo\Exceptions\ExternalServiceException;
use Geo\Factories\Entity\CityEntityFactory;
use App\Factories\Entity\Request\RequestEntityFactoryInterface;
use Geo\Factories\ExternalGeoRepositoryFactory;
use Geo\Repositories\CityRepository;
use Geo\Validators\CityValidator;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;

class CityService
{
    public const CITY_SEARCH_COUNT = 5;

    public function __construct(
        private CityRepository $cityRepository,
        private RequestEntityFactoryInterface $requestEntityFactory,
        private CityEntityFactory $cityEntityFactory,
        private CityValidator $cityValidator,
        private ExternalGeoRepositoryFactory $externalGeoRepositoryFactory,
        private LoggerInterface $logger
    ) {
    }

    /**
     * @param CountryEntity $country
     * @return CityEntity[]
     */
    public function getCitiesByCountry(CountryEntity $country): array
    {
        return $this->cityRepository->findAllByCountry($country);
    }

    public function getCityByUuid(string $uuid): CityEntity
    {
        return $this->cityRepository->findOneByUuid($uuid);
    }

    public function create(ServerRequestInterface $request): CityEntity
    {
        $cityRequestEntity = $this->requestEntityFactory->create($request, CityRequestEntity::class);

        if ($this->cityValidator->validate($cityRequestEntity) === false) {
            throw new ValidationException($this->cityValidator->errorsToString(), 400);
        }

        $city = $this->cityEntityFactory->create($cityRequestEntity);

        $this->cityRepository->save($city);

        return $city;
    }

    public function update(ServerRequestInterface $request, CityEntity $city): CityEntity
    {
        $cityRequestEntity = $this->requestEntityFactory->create($request, CityRequestEntity::class);

        if ($this->cityValidator->validate($cityRequestEntity) === false) {
            throw new ValidationException($this->cityValidator->errorsToString(), 400);
        }

        $city = $this->cityEntityFactory->update($cityRequestEntity, $city);

        $this->cityRepository->save($city);

        return $city;
    }


    public function search(CountryEntity $countryEntity, string $prefix): array
    {
        $cityEntities = $this->cityRepository->getCities($countryEntity, $prefix, self::CITY_SEARCH_COUNT);

        if (empty($cityEntities)) {
            $cityExternalRepository = $this->externalGeoRepositoryFactory->createCityRepository();

            try {
                $cityEntities = $cityExternalRepository->getCities($countryEntity, $prefix, self::CITY_SEARCH_COUNT);
            } catch (ExternalServiceException $e) {
                $this->logger->error($e->getMessage(), $e->getTrace());

                return [];
            }

            foreach ($cityEntities as $cityEntity) {
                $this->cityRepository->save($cityEntity);
            }
        }

        return $cityEntities;
    }

    public function delete(CityEntity $cityEntity): void
    {
        $cityEntity->setIsDeleted(true);
        $this->cityRepository->save($cityEntity);
    }
}
