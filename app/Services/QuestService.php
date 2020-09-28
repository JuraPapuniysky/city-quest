<?php

declare(strict_types=1);

namespace App\Services;

use App\Entities\CityEntity;
use App\Entities\CountryEntity;
use App\Entities\QuestEntity;
use App\Entities\Request\QuestRequestEntity;
use App\Exceptions\ValidationException;
use App\Factories\Entity\QuestEntityFactory;
use App\Factories\Entity\Request\RequestEntityFactoryInterface;
use App\Repositories\QuestRepository;
use App\Validators\QuestValidator;
use Psr\Http\Message\ServerRequestInterface;

class QuestService
{
    private QuestRepository $questRepository;
    private RequestEntityFactoryInterface $requestEntityFactory;
    private QuestValidator $questValidator;
    private QuestEntityFactory $questEntityFactory;

    public function __construct(
        QuestRepository $questRepository,
        RequestEntityFactoryInterface $requestEntityFactory,
        QuestValidator $questValidator,
        QuestEntityFactory $questEntityFactory
    ) {
        $this->questRepository = $questRepository;
        $this->requestEntityFactory = $requestEntityFactory;
        $this->questValidator = $questValidator;
        $this->questEntityFactory = $questEntityFactory;
    }

    public function getQuestByUuid(string $uuid): QuestEntity
    {
        return $this->questRepository->findOneByCriteria([
            'uuid' => $uuid,
            'isDeleted' => false,
        ]);
    }

    public function getQuests(): array
    {
        return $this->questRepository->findAll();
    }

    public function getQuestsByCountry(CountryEntity $countryEntity): array
    {
        return $this->questRepository->findAllByCriteria([
            'countryUuid' => $countryEntity->getUuid(),
            'isDeleted' => false,
        ]);
    }

    public function getQuestsByCity(CityEntity $cityEntity): array
    {
        return $this->questRepository->findAllByCriteria([
            'cityUuid' => $cityEntity->getUuid(),
            'isDeleted' => false,
        ]);
    }

    public function create(ServerRequestInterface $request): QuestEntity
    {
        $requestEntity = $this->requestEntityFactory->create($request, QuestRequestEntity::class);

        if ($this->questValidator->validate($requestEntity) === false) {
            throw new ValidationException($this->questValidator->errorsToString());
        }

        $questEntity = $this->questEntityFactory->create($requestEntity);

        return $this->questRepository->save($questEntity);
    }

    public function update(ServerRequestInterface $request, QuestEntity $questEntity): QuestEntity
    {
        $requestEntity = $this->requestEntityFactory->create($request, QuestRequestEntity::class);

        if ($this->questValidator->validate($requestEntity) === false) {
            throw new ValidationException($this->questValidator->errorsToString());
        }

        $questEntity = $this->questEntityFactory->update($requestEntity, $questEntity);

        return $this->questRepository->save($questEntity);
    }

    public function delete(QuestEntity $questEntity): void
    {
        $questEntity->setIsDeleted(true);
        $this->questRepository->save($questEntity);
    }
}