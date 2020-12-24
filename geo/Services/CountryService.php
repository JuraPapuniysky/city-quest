<?php

declare(strict_types=1);

namespace Geo\Services;

use App\Entities\CountryEntity;
use App\Entities\Request\CountryRequestEntity;
use App\Exceptions\ValidationException;
use Geo\Exceptions\ExternalServiceException;
use Geo\Factories\Entity\CountryEntityFactory;
use App\Factories\Entity\Request\RequestEntityFactoryInterface;
use Geo\Factories\ExternalGeoRepositoryFactory;
use Geo\Repositories\CountryRepository;
use Geo\Repositories\CountryRepositoryInterface;
use Geo\Validators\CountryValidator;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;
use PsrFramework\Adapters\UuidGenerator\UuidGeneratorInterface;

class CountryService
{
    public const COUNTRY_SEARCH_COUNT = 5;

    public function __construct(
        private CountryRepository $countryRepository,
        private CountryEntityFactory $countryEntityFactory,
        private RequestEntityFactoryInterface $requestEntityFactory,
        private CountryValidator $countryValidator,
        private ExternalGeoRepositoryFactory $externalGeoRepositoryFactory,
        private UuidGeneratorInterface $uuidGenerator,
        private LoggerInterface $logger
    ) {
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
            throw new ValidationException($this->countryValidator->errorsToString(), 400);
        }

        $country = $this->countryEntityFactory->create($requestEntity);

        $this->countryRepository->save($country);

        return $country;
    }

    public function update(ServerRequestInterface $request, CountryEntity $countryEntity): CountryEntity
    {
        /** @var CountryRequestEntity $requestEntity */
        $requestEntity = $this->requestEntityFactory->create($request, CountryRequestEntity::class);
        $requestEntity->uuid = $countryEntity->getUuid();

        if ($this->countryValidator->validate($requestEntity) === false) {
            throw new ValidationException($this->countryValidator->errorsToString(), 400);
        }

        $countryEntity = $this->countryEntityFactory->update($requestEntity, $countryEntity);

        $this->countryRepository->save($countryEntity);

        return $countryEntity;
    }

    /**
     * @param string $prefixName
     * @return CountryEntity[]
     */
    public function search(string $prefixName): array
    {
        $countryEntities = $this->countryRepository->getCountries($prefixName, self::COUNTRY_SEARCH_COUNT);

        if (empty($countryEntities)) {
            $externalCountryGeoRepository = $this->externalGeoRepositoryFactory->createCountryRepository();

            try {
                $countryEntities = $externalCountryGeoRepository
                    ->getCountries($prefixName, self::COUNTRY_SEARCH_COUNT);
            } catch (ExternalServiceException $e) {
                $this->logger->error($e->getMessage(), $e->getTrace());

                return [];
            }

            foreach ($countryEntities as $countryEntity) {
                $this->countryRepository->save($countryEntity);
            }
        }

        return $countryEntities;
    }

    public function delete(CountryEntity $countryEntity): void
    {
        $countryEntity->setIsDeleted(true);
        $this->countryRepository->save($countryEntity);
    }
}
