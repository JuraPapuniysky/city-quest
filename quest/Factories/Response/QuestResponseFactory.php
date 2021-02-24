<?php

declare(strict_types=1);

namespace Quest\Factories\Response;

use App\Entities\QuestEntity;
use App\Factories\Response\AbstractResponseFactory;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;

class QuestResponseFactory extends AbstractResponseFactory
{
    public function quest(QuestEntity $questEntity, int $status = 200): ResponseInterface
    {
        return new JsonResponse([
            'status' => 'success',
            'quest' => $this->questToArray($questEntity),
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
            $quests[] = $this->questToArray($questEntity);
        }

        return new JsonResponse([
            'status' => 'success',
            'quests' => $quests,
        ], 200);
    }

    public function types(array $types): ResponseInterface
    {
        return new JsonResponse($types);
    }

    private function questToArray(QuestEntity $questEntity): array
    {
        return [
            'uuid' => $questEntity->getUuid(),
            'userUuid' => $questEntity->getUserUuid(),
            'countryUuid' => $questEntity->getCountryUuid(),
            'cityUuid' => $questEntity->getCityUuid(),
            'name' => $questEntity->getName(),
            'description' => $questEntity->getDescription(),
        ];
    }
}
