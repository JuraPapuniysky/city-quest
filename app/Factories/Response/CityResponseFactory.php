<?php

declare(strict_types=1);

namespace App\Factories\Response;

use App\Entities\CityEntity;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;

class CityResponseFactory extends AbstractResponseFactory
{
    public function city(CityEntity $cityEntity, int $statusCode = 200): ResponseInterface
    {
        return new JsonResponse([
            'status' => 'succsess',
            'city' => [
                'uuid' => $cityEntity->getUuid(),
                'countryUuid' => $cityEntity->getCountryUuid(),
                'name' => $cityEntity->getName(),
                'description' => $cityEntity->getDescription(),
                'createdAt' => $cityEntity->getCreatedAt()->format('Y-m-d H:i:s'),
            ],
        ], $statusCode);
    }

    /**
     * @param CityEntity[] $cities
     * @return ResponseInterface
     */
    public function cities(array $cities): ResponseInterface
    {
        $citiesResponse = [];
        foreach ($cities as $cityEntity) {
            $citiesResponse[] = [
                'uuid' => $cityEntity->getUuid(),
                'countryUuid' => $cityEntity->getCountryUuid(),
                'name' => $cityEntity->getName(),
                'description' => $cityEntity->getDescription(),
                'createdAt' => $cityEntity->getCreatedAt()->format('Y-m-d H:i:s'),
            ];
        }

        return new JsonResponse([
            'status' => 'success',
            'cities' => $citiesResponse
        ], 200);
    }
}
