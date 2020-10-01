<?php

declare(strict_types=1);

namespace App\Factories\Response;

use App\Entities\QuestQuestionEntity;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;

class QuestQuestionResponseFactory extends AbstractResponseFactory
{
    public function question(QuestQuestionEntity $entity, int $status = 200): ResponseInterface
    {
        return new JsonResponse([
            'status' => 'success',
            'question' => [
                'uuid' => $entity->getUuid(),
                'questUuid' => $entity->getQuestUuid(),
                'description' => $entity->getDescription(),
                'answer' => $entity->getAnswer(),
                'type' => $entity->getType(),
                'createdAt' => $entity->getCreatedAt()->format('Y-m-d H:i:s'),
            ]
        ], $status);
    }

    /**
     * @param QuestQuestionEntity[] $entities
     * @return JsonResponse
     */
    public function questions(array $entities): ResponseInterface
    {
        $questions = [];

        foreach ($entities as $entity) {
            $questions[] = [
                'uuid' => $entity->getUuid(),
                'questUuid' => $entity->getQuestUuid(),
                'description' => $entity->getDescription(),
                'answer' => $entity->getAnswer(),
                'type' => $entity->getType(),
                'createdAt' => $entity->getCreatedAt()->format('Y-m-d H:i:s'),
            ];
        }

        return new JsonResponse([
            'status' => 'success',
            'questions' => $questions,
        ], 200);
    }

    public function questionTypes(array $types): ResponseInterface
    {
        return new JsonResponse([
            'status' => 'success',
            'types' => $types,
        ], 200);
    }
}