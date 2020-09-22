<?php

declare(strict_types=1);

namespace App\Validators;

use App\Entities\Request\RequestEntityInterface;
use App\Entities\UserEntity;
use App\Validators\CustomRules\UniqueRule;
use Rakit\Validation\Validator;

final class UserCreateValidator extends AbstractValidator implements ValidatorInterface
{
    private UniqueRule $uniqueRule;

    public function __construct(Validator $validator, UniqueRule $uniqueRule)
    {
        parent::__construct($validator);
        $this->uniqueRule = $uniqueRule;
    }

    public function validate(RequestEntityInterface $userRequestEntity): bool
    {
        $this->validator->addValidator('unique', $this->uniqueRule);

        $uniqueClassname = UserEntity::class;

        $this->validation = $this->validator->make([
            'email' => $userRequestEntity->email,
            'password' => $userRequestEntity->password,
            'confirmPassword' => $userRequestEntity->confirmPassword,
        ], [
            'email' => "required|email|unique:$uniqueClassname,email",
            'password' => 'required|min:8',
            'confirmPassword' => 'required|same:password',
        ]);

        $this->validation->validate();

        if ($this->validation->fails()) {
           return false;
        }

        return true;
    }

}