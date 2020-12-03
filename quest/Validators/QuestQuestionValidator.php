<?php

declare(strict_types=1);

namespace Quest\Validators;

use App\Entities\QuestEntity;
use App\Entities\Request\RequestEntityInterface;
use App\Validators\AbstractValidator;
use App\Validators\ValidatorInterface;
use Quest\Factories\QuestQuestionTypesFactory;
use App\Validators\CustomRules\EntityExistsRule;
use Rakit\Validation\Validator;

class QuestQuestionValidator extends AbstractValidator implements ValidatorInterface
{
    private EntityExistsRule $entityExistsRule;
    private QuestQuestionTypesFactory $questQuestionTypesFactory;

    public function __construct(
        Validator $validator,
        EntityExistsRule $entityExistsRule,
        QuestQuestionTypesFactory $questQuestionTypesFactory
    ) {
        parent::__construct($validator);
        $this->entityExistsRule = $entityExistsRule;
        $this->questQuestionTypesFactory = $questQuestionTypesFactory;
    }

    public function validate(RequestEntityInterface $requestEntity): bool
    {
        $this->validator->addValidator('entityExists', $this->entityExistsRule);

        $existsClassname = QuestEntity::class;

        $this->validation = $this->validator->make([
            'questUuid' => $requestEntity->questUuid,
            'answer' => $requestEntity->answer,
            'description' => $requestEntity->description,
            'type' => $requestEntity->type,
        ], [
            'questUuid' => "required|entityExists:$existsClassname,uuid",
            'description' => 'required',
            'answer' => 'required',
            'type' => [
                'required',
                $this->validator('in', array_keys($this->questQuestionTypesFactory->questionTypes()))->strict(),
            ],
        ]);

        $this->validation->validate();

        if ($this->validation->fails()) {
            return false;
        }

        return true;
    }
}
