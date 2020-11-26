<?php

declare(strict_types=1);

namespace App\Factories\Response;

use App\Entities\QuestEntity;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;

class QuestResponseFactory extends AbstractResponseFactory
{
    public function quest(QuestEntity $questEntity, int $status = 200): ResponseInterface
    {
        return new JsonResponse([
            'status' => 'success',
            'quest' => [
                'uuid' => $questEntity->getUuid(),
                'countryUuid' => $questEntity->getCountryUuid(),
                'cityUuid' => $questEntity->getCityUuid(),
                'name' => $questEntity->getName(),
                'description' => $questEntity->getDescription(),
            ],
        ], $status);
    }

    /**
     * @param QuestEntity[] $questEntities
     * @return ResponseInterface
     */
    public function quests(array $questEntities): ResponseInterface
    {
        $quests = [];

        foreach ($questEntities as $questEntity) {
            $quests[] = [
                'uuid' => $questEntity->getUuid(),
                'countryUuid' => $questEntity->getCountryUuid(),
                'cityUuid' => $questEntity->getCityUuid(),
                'name' => $questEntity->getName(),
                'description' => $questEntity->getDescription(),
            ];
        }

        return new JsonResponse([
            'status' => 'success',
            'quests' => $quests,
        ], 200);
    }
}
