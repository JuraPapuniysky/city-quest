<?php

declare(strict_types=1);

namespace Quest\Controllers;

use App\Exceptions\ValidationException;
use Quest\Factories\Response\QuestQuestionResponseFactory;
use Quest\Services\QuestQuestionService;
use Quest\Services\QuestService;
use Doctrine\ORM\EntityNotFoundException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class QuestQuestionController
{
    private QuestQuestionService $questQuestionService;
    private QuestQuestionResponseFactory $questQuestionResponseFactory;
    private QuestService $questService;

    public function __construct(
        QuestQuestionService $questQuestionService,
        QuestQuestionResponseFactory $questQuestionResponseFactory,
        QuestService $questService
    ) {
        $this->questQuestionService = $questQuestionService;
        $this->questQuestionResponseFactory = $questQuestionResponseFactory;
        $this->questService = $questService;
    }

    public function question(ServerRequestInterface $request, string $uuid): ResponseInterface
    {
        try {
            $question = $this->questQuestionService->getQuestQuestion($uuid);
        } catch (EntityNotFoundException $e) {
            return $this->questQuestionResponseFactory->notFound($e);
        }

        return $this->questQuestionResponseFactory->question($question);
    }

    public function questions(ServerRequestInterface $request, string $questUuid): ResponseInterface
    {
        try {
            $quest = $this->questService->getQuestByUuid($questUuid);
            $questions = $this->questQuestionService->getQuestQuestionsByQuest($quest);
        } catch (EntityNotFoundException $e) {
            return $this->questQuestionResponseFactory->notFound($e);
        }

        return $this->questQuestionResponseFactory->questions($questions);
    }

    public function create(ServerRequestInterface $request, string $questUuid): ResponseInterface
    {
        try {
            $quest = $this->questService->getQuestByUuid($questUuid);
            $question = $this->questQuestionService->create($request, $quest);
        } catch (EntityNotFoundException $e) {
            return $this->questQuestionResponseFactory->notFound($e);
        } catch (ValidationException $e) {
            return $this->questQuestionResponseFactory->validationError($e);
        }

        return $this->questQuestionResponseFactory->question($question, 201);
    }

    public function update(ServerRequestInterface $request, string $uuid): ResponseInterface
    {
        try {
            $question = $this->questQuestionService->getQuestQuestion($uuid);
            $question = $this->questQuestionService->update($request, $question);
        } catch (EntityNotFoundException $e) {
            return $this->questQuestionResponseFactory->notFound($e);
        } catch (ValidationException $e) {
            return $this->questQuestionResponseFactory->validationError($e);
        }

        return $this->questQuestionResponseFactory->question($question, 201);
    }

    public function questionTypes(): ResponseInterface
    {
        return $this->questQuestionResponseFactory->questionTypes($this->questQuestionService->getQuestionTypes());
    }

    public function delete(ServerRequestInterface $request, string $uuid): ResponseInterface
    {
        try {
            $question = $this->questQuestionService->getQuestQuestion($uuid);
            $this->questQuestionService->delete($question);
        } catch (EntityNotFoundException $e) {
            return $this->questQuestionResponseFactory->notFound($e);
        }

        return $this->questQuestionResponseFactory->deleted();
    }
}
