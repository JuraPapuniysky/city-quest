<?php

declare(strict_types=1);

namespace Quest\Validators;

use App\Entities\CityEntity;
use App\Entities\CountryEntity;
use App\Entities\QuestEntity;
use App\Entities\Request\RequestEntityInterface;
use App\Validators\AbstractValidator;
use App\Validators\CustomRules\EntityExistsRule;
use App\Validators\CustomRules\UniqueRule;
use App\Validators\ValidatorInterface;
use Rakit\Validation\Validator;

final class QuestValidator extends AbstractValidator implements ValidatorInterface
{
    private EntityExistsRule $entityExistsRule;
    private UniqueRule $uniqueRule;

    public function __construct(Validator $validator, EntityExistsRule $entityExistsRule, UniqueRule $uniqueRule)
    {
        parent::__construct($validator);
        $this->entityExistsRule = $entityExistsRule;
        $this->uniqueRule = $uniqueRule;
    }

    public function validate(RequestEntityInterface $requestEntity): bool
    {
        $this->validator->addValidator('entityExists', $this->entityExistsRule);
        $this->validator->addValidator('unique', $this->uniqueRule);

        $existsClassCountry = CountryEntity::class;
        $existsClassCity = CityEntity::class;
        $uniqueClassnameName = QuestEntity::class;

        $this->validation = $this->validator->make([
            'name' => $requestEntity->name,
            'countryUuid' => $requestEntity->countryUuid,
            'cityUuid' => $requestEntity->cityUuid,
            'description' => $requestEntity->description,
        ], [
            'countryUuid' => "required|entityExists:$existsClassCountry,uuid",
            'cityUuid' => "required|entityExists:$existsClassCity,uuid",
            'name' => "required|unique:$uniqueClassnameName,name",
        ]);

        $this->validation->validate();

        if ($this->validation->fails()) {
            return false;
        }

        return true;
    }
}
