<?php

declare(strict_types=1);

namespace Geo\Factories\Entity;

use App\Entities\CityEntity;
use App\Entities\Request\CityRequestEntity;
use PsrFramework\Adapters\UuidGenerator\UuidGeneratorInterface;

class CityEntityFactory
{
    private UuidGeneratorInterface $uuidGenerator;

    public function __construct(UuidGeneratorInterface $uuidGenerator)
    {
        $this->uuidGenerator = $uuidGenerator;
    }

    public function create(CityRequestEntity $requestEntity): CityEntity
    {
        $city = new CityEntity();
        $city->setUuid($this->uuidGenerator->generate());
        $city->setCreatedAt(new \DateTime('now'));

        $this->setAttributes($requestEntity, $city);

        return $city;
    }

    public function update(CityRequestEntity $requestEntity, CityEntity $city): CityEntity
    {
        $city = $this->setAttributes($requestEntity, $city);

        $city->setUpdatedAt(new \DateTime());

        return $city;
    }

    private function setAttributes(CityRequestEntity $requestEntity, CityEntity $city): CityEntity
    {
        $city->setName($requestEntity->name);
        $city->setCountryUuid($requestEntity->countryUuid);
        $city->setDescription($requestEntity->description);

        return $city;
    }
}
