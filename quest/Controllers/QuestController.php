<?php

declare(strict_types=1);

namespace Quest\Controllers;

use App\Exceptions\ValidationException;
use Quest\Factories\Response\QuestResponseFactory;
use Geo\Services\CountryService;
use Quest\Services\QuestService;
use Doctrine\ORM\EntityNotFoundException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class QuestController
{
    public function __construct(
        private QuestService $questService,
        private QuestResponseFactory $questResponseFactory,
        private CountryService $countryService
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
            $questEntity = $this->questService->create($request);
        } catch (ValidationException $e) {
            return $this->questResponseFactory->validationError($e);
        }

        return $this->questResponseFactory->quest($questEntity, 201);
    }

    public function update(ServerRequestInterface $request, string $uuid): ResponseInterface
    {
        try {
            $questEntity = $this->questService->getQuestByUuid($uuid);
            $questEntity = $this->questService->update($request, $questEntity);
        } catch (ValidationException $e) {
            return $this->questResponseFactory->validationError($e);
        } catch (EntityNotFoundException $e) {
            return $this->questResponseFactory->notFound($e);
        }

        return $this->questResponseFactory->quest($questEntity, 201);
    }

    public function delete(ServerRequestInterface $request, string $uuid): ResponseInterface
    {
        try {
            $questEntity = $this->questService->getUserQuestByUuid($request, $uuid);
            $this->questService->delete($questEntity);
        } catch (EntityNotFoundException $e) {
            return $this->questResponseFactory->notFound($e);
        }

        return $this->questResponseFactory->deleted();
    }
}
