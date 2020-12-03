<?php

declare(strict_types=1);

namespace Geo\Factories\Entity;

use App\Entities\CountryEntity;
use App\Entities\Request\RequestEntityInterface;
use PsrFramework\Adapters\UuidGenerator\UuidGeneratorInterface;

class CountryEntityFactory
{
    private UuidGeneratorInterface $uuidGenerator;

    public function __construct(UuidGeneratorInterface $uuidGenerator)
    {
        $this->uuidGenerator = $uuidGenerator;
    }

    public function create(RequestEntityInterface $requestEntity): CountryEntity
    {
        $country = new CountryEntity();
        $country->setUuid($this->uuidGenerator->generate());
        $country = $this->setCountryEntityFields($requestEntity, $country);
        $country->setCreatedAt(new \DateTime('now'));

        return $country;
    }

    public function update(RequestEntityInterface $requestEntity, CountryEntity $country): CountryEntity
    {
        $country = $this->setCountryEntityFields($requestEntity, $country);
        $country->setUpdatedAt(new \DateTime('now'));

        return $country;
    }

    private function setCountryEntityFields(RequestEntityInterface $requestEntity, CountryEntity $country): CountryEntity
    {
        $country->setName($requestEntity->name);
        $country->setIsoCode($requestEntity->isoCode);
        $country->setDescription($requestEntity->description);

        return $country;
    }
}
