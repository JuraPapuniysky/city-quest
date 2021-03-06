<?php

declare(strict_types=1);

namespace Geo\Factories\Response;

use App\Entities\CountryEntity;
use App\Factories\Response\AbstractResponseFactory;
use Laminas\Diactoros\Response\JsonResponse;

final class CountryResponseFactory extends AbstractResponseFactory
{
    public function country(CountryEntity $country): JsonResponse
    {
        return new JsonResponse([
            'status' => 'Success',
            'country' => [
                'uuid' => $country->getUuid(),
                'name' => $country->getName(),
                'isoCode' => $country->getIsoCode(),
                'description' => $country->getDescription(),
            ]
        ], 200);
    }

    /**
     * @param CountryEntity[] $countries
     * @return JsonResponse
     */
    public function countries(array $countries): JsonResponse
    {
        $countriesResponse = [];
        foreach ($countries as $country) {
            $countriesResponse[] = [
                'uuid' => $country->getUuid(),
                'name' => $country->getName(),
                'isoCode' => $country->getIsoCode(),
                'description' => $country->getDescription(),
            ];
        }

        return new JsonResponse([
            'status' => 'Success',
            'countries' => $countriesResponse,
        ], 200);
    }
}
