<?php

declare(strict_types=1);

namespace App\Validators;

use App\Entities\CountryEntity;
use App\Entities\Request\RequestEntityInterface;
use App\Validators\CustomRules\EntityExistsRule;
use Rakit\Validation\Validator;

final class CityValidator extends AbstractValidator implements ValidatorInterface
{
    private EntityExistsRule $entityExistsRule;

    public function __construct(Validator $validator, EntityExistsRule $entityExistsRule)
    {
        parent::__construct($validator);
        $this->entityExistsRule = $entityExistsRule;
    }

    public function validate(RequestEntityInterface $requestEntity): bool
    {
        $this->validator->addValidator('entityExists', $this->entityExistsRule);

        $existsClassname = CountryEntity::class;

        $this->validation = $this->validator->make([
            'name' => $requestEntity->name,
            'countryUuid' => $requestEntity->countryUuid,
            'description' => $requestEntity->description,
        ], [
            'countryUuid' => "required|entityExists:$existsClassname,uuid",
            'name' => 'required',
        ]);

        $this->validation->validate();

        if ($this->validation->fails()) {
            return false;
        }

        return true;
    }
}