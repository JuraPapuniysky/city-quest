<?php

declare(strict_types=1);

namespace Quest\Services;

use App\Entities\QuestEntity;
use App\Entities\QuestQuestionEntity;
use App\Entities\Request\QuestQuestionRequestEntity;
use App\Entities\Request\RequestEntityInterface;
use App\Exceptions\ValidationException;
use Quest\Factories\Entity\QuestQuestionFactory;
use App\Factories\Entity\Request\RequestEntityFactoryInterface;
use Quest\Factories\QuestQuestionTypesFactory;
use Quest\Repositories\QuestQuestionRepository;
use Quest\Validators\QuestQuestionValidator;
use Psr\Http\Message\ServerRequestInterface;

class QuestQuestionService
{
    private QuestQuestionRepository $questQuestionRepository;
    private RequestEntityFactoryInterface $requestEntityFactory;
    private QuestQuestionValidator $questQuestionValidator;
    private QuestQuestionFactory $questQuestionFactory;
    private QuestQuestionTypesFactory $questQuestionTypesFactory;

    public function __construct(
        QuestQuestionRepository $questionRepository,
        RequestEntityFactoryInterface $requestEntityFactory,
        QuestQuestionValidator $questQuestionValidator,
        QuestQuestionFactory $questQuestionFactory,
        QuestQuestionTypesFactory $questQuestionTypesFactory
    ) {
        $this->questQuestionRepository = $questionRepository;
        $this->requestEntityFactory = $requestEntityFactory;
        $this->questQuestionValidator = $questQuestionValidator;
        $this->questQuestionFactory = $questQuestionFactory;
        $this->questQuestionTypesFactory = $questQuestionTypesFactory;
    }

    public function getQuestQuestion(string $uuid): QuestQuestionEntity
    {
        return $this->questQuestionRepository->findOneByCriteria(['uuid' => $uuid]);
    }

    public function getQuestQuestionsByQuest(QuestEntity $questEntity): array
    {
        return $this->questQuestionRepository->findAllByCriteria([
            'questUuid' => $questEntity->getUuid(),
        ]);
    }

    public function create(RequestEntityInterface $requestEntity, QuestEntity $questEntity): QuestQuestionEntity
    {
        if ($this->questQuestionValidator->validate($requestEntity) === false) {
            throw new ValidationException($this->questQuestionValidator->errorsToString());
        }

        $entity = $this->questQuestionFactory->create($requestEntity, $questEntity);
        $this->questQuestionRepository->save($entity, false);

        return $entity;
    }

    public function update(
        ServerRequestInterface $request,
        QuestQuestionEntity $questQuestionEntity
    ): QuestQuestionEntity {
        $requestEntity = $this->requestEntityFactory->create($request, QuestQuestionRequestEntity::class);

        if ($this->questQuestionValidator->validate($requestEntity) === false) {
            throw new ValidationException($this->questQuestionValidator->errorsToString());
        }

        $entity = $this->questQuestionFactory->update($requestEntity, $questQuestionEntity);
        $this->questQuestionRepository->save($entity);

        return $entity;
    }

    public function delete(QuestQuestionEntity $questQuestionEntity): void
    {
        $this->questQuestionRepository->delete($questQuestionEntity);
    }

    public function getQuestionTypes(): array
    {
        return $this->questQuestionTypesFactory->questionTypes();
    }
}
