<?php

namespace App\Interfaces\Traits;

use Illuminate\Contracts\Validation\Validator as ValidationValidator;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

interface IHasValidation
{
    public function getRules(): array;
    public function validate(?array $data): void;
    public function rawArray(): array;
    public function getValidator(array $data): ValidationValidator;
    public function checkValidator(ValidationValidator $validator): void;
    public function throwValidationException(array $message): void;
}
