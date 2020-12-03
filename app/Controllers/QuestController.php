<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Exceptions\ValidationException;
use App\Factories\Response\QuestResponseFactory;
use Geo\Services\CountryService;
use App\Services\QuestService;
use Doctrine\ORM\EntityNotFoundException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class QuestController
{
    private QuestService $questService;
    private QuestResponseFactory $questResponseFactory;
    private CountryService $countryService;

    public function __construct(QuestService $questService, QuestResponseFactory $questResponseFactory, CountryService $countryService)
    {
        $this->questService = $questService;
        $this->questResponseFactory = $questResponseFactory;
        $this->countryService = $countryService;
    }

    public function quest(ServerRequestInterface $request, string $uuid): ResponseInterface
    {
        try {
            $questEntity = $this->questService->getQuestByUuid($uuid);
        } catch (EntityNotFoundException $e) {
            return $this->questResponseFactory->notFound($e);
        }

        return $this->questResponseFactory->quest($questEntity);
    }

    public function quests(ServerRequestInterface $request): ResponseInterface
    {
        return $this->questResponseFactory->quests($this->questService->getQuests());
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
            $questEntity = $this->questService->getQuestByUuid($uuid);
            $this->questService->delete($questEntity);
        } catch (EntityNotFoundException $e) {
            return $this->questResponseFactory->notFound($e);
        }

        return $this->questResponseFactory->deleted();
    }
}
