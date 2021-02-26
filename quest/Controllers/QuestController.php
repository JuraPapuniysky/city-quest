<?php

declare(strict_types=1);

namespace Quest\Controllers;

use App\Entities\UserEntity;
use App\Exceptions\ValidationException;
use Quest\Factories\Response\QuestResponseFactory;
use Geo\Services\CountryService;
use Quest\Services\QuestQuestionService;
use Quest\Services\QuestService;
use Doctrine\ORM\EntityNotFoundException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class QuestController
{
    public function __construct(
        private QuestService $questService,
        private QuestResponseFactory $questResponseFactory,
        private CountryService $countryService,
        private QuestQuestionService $questQuestionService,
    ) {
    }

    public function quest(ServerRequestInterface $request, string $uuid): ResponseInterface
    {
        try {
            $questEntity = $this->questService->getUserQuestByUuid($request, $uuid);
        } catch (EntityNotFoundException $e) {
            return $this->questResponseFactory->notFound($e);
        }

        return $this->questResponseFactory->quest($questEntity);
    }

    public function quests(ServerRequestInterface $request): ResponseInterface
    {
        return $this->questResponseFactory->quests($this->questService->getUserQuests($request));
    }

    public function create(ServerRequestInterface $request): ResponseInterface
    {
        try {
            $requestEntity = $this->questService->createRequestEntity($request);

            $questEntity = $this->questService->create($requestEntity, $request->getAttribute(UserEntity::class));

            foreach ($requestEntity->questionEntities as $questionEntity) {

                $questionEntity = $this->questQuestionService->create($questionEntity, $questEntity);
            }
            $this->questService->commit();

            return $this->questResponseFactory->quest($questEntity, 201);
        } catch (ValidationException $e) {
            return $this->questResponseFactory->validationError($e);
        }
    }

    public function update(ServerRequestInterface $request, string $uuid): ResponseInterface
    {
        try {
            $questEntity = $this->questService->getUserQuestByUuid($request, $uuid);
            $requestEntity = $this->questService->createRequestEntity($request);

            $questEntity = $this->questService->update($requestEntity, $questEntity, $request->getAttribute(UserEntity::class));

            return $this->questResponseFactory->quest($questEntity, 201);
        } catch (ValidationException $e) {
            return $this->questResponseFactory->validationError($e);
        } catch (EntityNotFoundException $e) {
            return $this->questResponseFactory->notFound($e);
        }
    }

    public function delete(ServerRequestInterface $request, string $uuid): ResponseInterface
    {
        try {
            $questEntity = $this->questService->getUserQuestByUuid($request, $uuid);
            $this->questService->delete($questEntity);

            return $this->questResponseFactory->deleted();
        } catch (EntityNotFoundException $e) {
            return $this->questResponseFactory->notFound($e);
        }
    }

    public function questionTypes(): ResponseInterface
    {
        return $this->questResponseFactory->types($this->questQuestionService->getQuestionTypes());
    }
}
