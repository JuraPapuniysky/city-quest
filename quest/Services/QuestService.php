<?php

declare(strict_types=1);

namespace Quest\Services;

use App\Entities\CityEntity;
use App\Entities\CountryEntity;
use App\Entities\QuestEntity;
use App\Entities\Request\QuestRequestEntity;
use App\Entities\Request\RequestEntityInterface;
use App\Entities\UserEntity;
use App\Exceptions\ValidationException;
use Quest\Factories\Entity\QuestEntityFactory;
use App\Factories\Entity\Request\RequestEntityFactoryInterface;
use Quest\Repositories\QuestRepository;
use Quest\Validators\QuestValidator;
use Psr\Http\Message\ServerRequestInterface;

class QuestService
{
    public function __construct(
        private QuestRepository $questRepository,
        private RequestEntityFactoryInterface $requestEntityFactory,
        private QuestValidator $questValidator,
        private QuestEntityFactory $questEntityFactory
    ) {
    }

    public function getQuestByUuid(string $uuid): QuestEntity
    {
        return $this->questRepository->findOneByCriteria([
            'uuid' => $uuid,
            'isDeleted' => false,
        ]);
    }

    public function getUserQuestByUuid(ServerRequestInterface $request, $uuid): QuestEntity
    {
        return $this->questRepository->findOneByCriteria([
            'uuid' => $uuid,
            'userUuid' => $request->getAttribute(UserEntity::class),
        ]);
    }

    public function getUserQuests(ServerRequestInterface $request): array
    {
        return $this->questRepository->findAllByCriteria([
            'userUuid' => $request->getAttribute(UserEntity::class),
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

    public function createRequestEntity(ServerRequestInterface $request): RequestEntityFactoryInterface
    {
        return $this->requestEntityFactory->create($request, QuestRequestEntity::class);
    }

    public function create(RequestEntityInterface $requestEntity, UserEntity $userEntity): QuestEntity
    {
        if ($this->questValidator->validate($requestEntity) === false) {
            throw new ValidationException($this->questValidator->errorsToString());
        }

        $questEntity = $this->questEntityFactory->create($requestEntity, $userEntity);

        $this->questRepository->save($questEntity);

        return $questEntity;
    }

    public function update(
        RequestEntityInterface $requestEntity,
        QuestEntity $questEntity,
        UserEntity $userEntity
    ): QuestEntity {
        if ($this->questValidator->validate($requestEntity) === false) {
            throw new ValidationException($this->questValidator->errorsToString());
        }

        $questEntity = $this->questEntityFactory->update($requestEntity, $questEntity, $userEntity);

        return $this->questRepository->save($questEntity);
    }

    public function delete(QuestEntity $questEntity): void
    {
        $questEntity->setIsDeleted(true);
        $this->questRepository->save($questEntity);
    }
}
