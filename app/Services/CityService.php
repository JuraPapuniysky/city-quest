<?php

declare(strict_types=1);

namespace App\Services;

use App\Entities\CityEntity;
use App\Entities\CountryEntity;
use App\Entities\Request\CityRequestEntity;
use App\Exceptions\ValidationException;
use App\Factories\Entity\CityEntityFactory;
use App\Factories\Entity\Request\RequestEntityFactoryInterface;
use App\Repositories\CityRepository;
use App\Validators\CityValidator;
use Psr\Http\Message\ServerRequestInterface;

class CityService
{
    private CityRepository $cityRepository;
    private RequestEntityFactoryInterface $requestEntityFactory;
    private CityEntityFactory $cityEntityFactory;
    private CityValidator $cityValidator;

    public function __construct(
        CityRepository $cityRepository,
        RequestEntityFactoryInterface $requestEntityFactory,
        CityEntityFactory $cityEntityFactory,
        CityValidator $cityValidator
    ) {
        $this->cityRepository = $cityRepository;
        $this->requestEntityFactory = $requestEntityFactory;
        $this->cityEntityFactory = $cityEntityFactory;
        $this->cityValidator = $cityValidator;
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

        return $this->cityRepository->save($city);
    }

    public function update(ServerRequestInterface $request, CityEntity $city): CityEntity
    {
        $cityRequestEntity = $this->requestEntityFactory->create($request, CityRequestEntity::class);

        if ($this->cityValidator->validate($cityRequestEntity) === false) {
            throw new ValidationException($this->cityValidator->errorsToString(), 400);
        }

        $city = $this->cityEntityFactory->update($cityRequestEntity, $city);

        return $this->cityRepository->save($city);
    }

    public function delete(CityEntity $cityEntity): void
    {
        $cityEntity->setIsDeleted(true);
        $this->cityRepository->save($cityEntity);
    }
}