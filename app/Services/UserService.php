<?php

declare(strict_types=1);

namespace App\Services;

use App\Entities\Request\AuthRequestEntity;
use App\Entities\Request\RequestEntityInterface;
use App\Entities\Request\UserRequestEntity;
use App\Entities\SessionEntity;
use App\Entities\UserEntity;
use App\Exceptions\RefreshTokenException;
use App\Exceptions\ValidationException;
use App\Factories\Entity\Request\RequestEntityFactoryInterface;
use App\Factories\Entity\SessionEntityFactory;
use App\Factories\Entity\UserEntityFactory;
use App\Repositories\SessionRepository;
use App\Repositories\UserRepository;
use App\Validators\AuthValidator;
use App\Validators\UserCreateValidator;
use Doctrine\ORM\EntityNotFoundException;
use Psr\Http\Message\ServerRequestInterface;
use PsrFramework\Adapters\JWT\JWTInterface;
use PsrFramework\Services\CheckAuth\CheckAuthInterface;
use PsrFramework\Services\CheckAuth\CheckAuthService;
use PsrFramework\Services\CheckAuth\IdentityInterface;

final class UserService extends CheckAuthService
{
    const MAX_USER_SESSIONS = 5;

    private UserRepository $userRepository;

    private RequestEntityFactoryInterface $requestEntityFactory;

    private UserCreateValidator $userCreateValidator;

    private UserEntityFactory $userEntityFactory;

    private SessionEntityFactory $sessionEntityFactory;

    private AuthValidator $authValidator;

    private SessionRepository $sessionRepository;

    private JWTInterface $jwt;

    public function __construct(
        UserRepository $userRepository,
        RequestEntityFactoryInterface $requestEntityFactory,
        UserCreateValidator $userCreateValidator,
        UserEntityFactory $userEntityFactory,
        SessionEntityFactory $sessionEntityFactory,
        AuthValidator $authValidator,
        SessionRepository $sessionRepository,
        JWTInterface $jwt
    ) {
        $this->userRepository = $userRepository;
        $this->requestEntityFactory = $requestEntityFactory;
        $this->userCreateValidator = $userCreateValidator;
        $this->userEntityFactory = $userEntityFactory;
        $this->sessionEntityFactory = $sessionEntityFactory;
        $this->authValidator = $authValidator;
        $this->sessionRepository = $sessionRepository;
        $this->jwt = $jwt;
    }

    public function create(RequestEntityInterface $requestEntity): UserEntity
    {
        if ($this->userCreateValidator->validate($requestEntity) === false) {
            throw new ValidationException('Validation error', 400);
        }

        $userEntity = $this->userEntityFactory->create($requestEntity);

        $this->userRepository->save($userEntity);

        return $userEntity;
    }

    public function getValidationErrors(): array
    {
        return $this->userCreateValidator->errors();
    }

    public function confirmUser(string $registrationConfirmToken): UserEntity
    {
        $userEntity = $this->userRepository->findUserEntityByRegistrationConfirmToken($registrationConfirmToken);

        if ($userEntity === null) {
            throw new EntityNotFoundException('User not found', 404);
        }

        $userEntity->setIsConfirmed(true);
        $this->userRepository->save($userEntity);

        return $userEntity;
    }

    public function authUser(ServerRequestInterface $request): SessionEntity
    {
        $authEntity = $this->requestEntityFactory->create($request, AuthRequestEntity::class);

        if ($this->authValidator->validate($authEntity) === false) {
            throw new ValidationException('Validation error', 400);
        }

        $userEntity = $this->userRepository->findUserEntityByEmail($authEntity->email);

        if ($userEntity === null) {
            throw new EntityNotFoundException('User not found', 404);
        }

        try {
            $sessionEntity = $this->sessionRepository->findSessionByUserFingerPrint(
                $userEntity,
                $authEntity->fingerPrint
            );
        } catch (EntityNotFoundException $e) {
            $userSessions = $this->sessionRepository->findSessionEntitiesByUser($userEntity);

            if (count($userSessions) >= self::MAX_USER_SESSIONS) {
                $this->sessionRepository->delete($userSessions[0]);
            }

            $sessionEntity = $this->sessionEntityFactory->create($authEntity, $userEntity);
        }

        $sessionEntity = $this->sessionEntityFactory->update($sessionEntity, $userEntity);
        $this->sessionRepository->save($sessionEntity);

        return $sessionEntity;
    }

    public function refreshSession(ServerRequestInterface $request): SessionEntity
    {
        $refreshToken = $request->getHeaderLine('Refresh-Token');

        if ($refreshToken === null) {
            throw new RefreshTokenException('Token does not exists', 403);
        }

        $payload = $this->jwt->decode($refreshToken);
        $userEntity = $this->userRepository->findUserEntityByEmail($payload->data->email);
        $session = $this->sessionRepository->findSessionByUserFingerPrint($userEntity, $payload->data->fingerPrint);

        $session = $this->sessionEntityFactory->update($session, $userEntity);
        $this->sessionRepository->save($session);

        return $session;
    }
}
