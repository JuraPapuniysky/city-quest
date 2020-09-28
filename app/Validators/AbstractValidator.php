<?php

declare(strict_types=1);

namespace App\Validators;

use Rakit\Validation\Validation;
use Rakit\Validation\Validator;

abstract class AbstractValidator
{
    protected Validator $validator;

    protected ?Validation $validation = null;

    public function __construct(Validator $validator)
    {
        $this->validator = $validator;
    }

    public function errors(): array
    {
        $errors = $this->validation->errors();

        return $errors->firstOfAll();
    }

    public function errorsToString(): string
    {
        return json_encode($this->validation->errors());
    }
}