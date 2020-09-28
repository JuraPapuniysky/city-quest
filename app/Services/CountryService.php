<?php

declare(strict_types=1);

namespace App\Services;

use App\Entities\CountryEntity;
use App\Entities\Request\CountryRequestEntity;
use App\Exceptions\ValidationException;
use App\Factories\Entity\CountryEntityFactory;
use App\Factories\Entity\Request\RequestEntityFactoryInterface;
use App\Repositories\CountryRepository;
use App\Validators\CountryValidator;
use Psr\Http\Message\ServerRequestInterface;

class CountryService
{
    private CountryRepository $countryRepository;
    private CountryEntityFactory $countryEntityFactory;
    private RequestEntityFactoryInterface $requestEntityFactory;
    private CountryValidator $countryValidator;

    public function __construct(
        CountryRepository $countryRepository,
        CountryEntityFactory $countryEntityFactory,
        RequestEntityFactoryInterface $requestEntityFactory,
        CountryValidator $countryValidator
    ) {
        $this->countryRepository = $countryRepository;
        $this->countryEntityFactory = $countryEntityFactory;
        $this->requestEntityFactory = $requestEntityFactory;
        $this->countryValidator = $countryValidator;
    }

    public function getAllCountries(): array
    {
        return $this->countryRepository->findAllCountries();
    }

    public function getOneCountryByUuid(string $uuid): CountryEntity
    {
        return $this->countryRepository->findOneCountryByUuid($uuid);
    }

    public function create(ServerRequestInterface $request): CountryEntity
    {
        $requestEntity = $this->requestEntityFactory->create($request, CountryRequestEntity::class);

        if ($this->countryValidator->validate($requestEntity) === false) {
            throw new ValidationException('Validation error', 400);
        }

        $country = $this->countryEntityFactory->create($requestEntity);

        $this->countryRepository->save($country);

        return $country;
    }

    public function update(ServerRequestInterface $request, CountryEntity $countryEntity): CountryEntity
    {
        $requestEntity = $this->requestEntityFactory->create($request, CountryRequestEntity::class);

        if ($this->countryValidator->validate($requestEntity) === false) {
            throw new ValidationException($this->countryValidator->errorsToString(), 400);
        }

        $countryEntity = $this->countryEntityFactory->update($requestEntity, $countryEntity);

        $this->countryRepository->save($countryEntity);

        return $countryEntity;
    }

    public function delete(CountryEntity $countryEntity): void
    {
        $countryEntity->setIsDeleted(true);
        $this->countryRepository->save($countryEntity);
    }
}