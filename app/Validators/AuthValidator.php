<?php

declare(strict_types=1);

namespace App\Validators;

use App\Entities\Request\RequestEntityInterface;

class AuthValidator extends AbstractValidator implements ValidatorInterface
{
    public function validate(RequestEntityInterface $authRequestEntity): bool
    {
        $this->validation = $this->validator->make([
            'email' => $authRequestEntity->email,
            'password' => $authRequestEntity->password,
            'fingerPrint' => $authRequestEntity->fingerPrint,
        ], [
            'email' => "required|email",
            'password' => 'required|min:8',
        ]);

        $this->validation->validate();

        if ($this->validation->fails()) {
            return false;
        }

        return true;
    }
}