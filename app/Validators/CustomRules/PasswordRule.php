<?php

declare(strict_types=1);

namespace App\Validators\CustomRules;

use App\Entities\UserEntity;
use Doctrine\ORM\EntityManagerInterface;
use PsrFramework\Adapters\PasswordHash\PasswordHashInterface;
use Rakit\Validation\Rule;

final class PasswordRule extends Rule
{
    private PasswordHashInterface $passwordHash;

    private EntityManagerInterface $entityManager;

    protected $message = ":attribute :value a incorrect";

    protected $fillableParams = ['email'];

    public function __construct(EntityManagerInterface $entityManager, PasswordHashInterface $passwordHash)
    {
        $this->entityManager = $entityManager;
        $this->passwordHash = $passwordHash;
    }

    public function check($value): bool
    {
        $this->requireParameters(['email']);

        $userEmail = $this->parameter('email');

        /** @var UserEntity $userEntity */
        $userEntity = $this->entityManager->getRepository(UserEntity::class)->findOneBy([
            'email' => $userEmail,
        ]);

        if ($userEntity === null) {
            $this->message = 'User not found';

            return false;
        }

        if ($userEntity->getIsConfirmed() !== true) {
            $this->message = "User is not confirmed";

            return false;
        }

        return $this->passwordHash->check($value, $userEntity->getPasswordHash());
    }
}
