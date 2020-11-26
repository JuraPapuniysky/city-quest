<?php

declare(strict_types=1);

namespace App\Validators;

use App\Entities\CountryEntity;
use App\Entities\Request\RequestEntityInterface;
use App\Validators\CustomRules\UniqueRule;
use Rakit\Validation\Validator;

final class CountryValidator extends AbstractValidator implements ValidatorInterface
{
    private UniqueRule $uniqueRule;

    public function __construct(Validator $validator, UniqueRule $uniqueRule)
    {
        parent::__construct($validator);
        $this->uniqueRule = $uniqueRule;
    }

    public function validate(RequestEntityInterface $requestEntity): bool
    {
        $this->validator->addValidator('unique', $this->uniqueRule);

        $uniqueClassname = CountryEntity::class;

        $this->validation = $this->validator->make([
            'name' => $requestEntity->name,
            'isoCode' => $requestEntity->isoCode,
            'description' => $requestEntity->description,
        ], [
            'isoCode' => "required|unique:$uniqueClassname,isoCode,{$requestEntity->uuid}",
            'name' => 'required',
        ]);

        $this->validation->validate();

        if ($this->validation->fails()) {
            return false;
        }

        return true;
    }
}
