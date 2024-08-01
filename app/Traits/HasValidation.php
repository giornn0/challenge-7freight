<?php

namespace App\Traits;

use Illuminate\Contracts\Validation\Validator as ValidationValidator;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Exception;

trait HasValidation
{
    public ?array $value = null;
    public ?array $rules = null;

    public function getRules(): array
    {
        if (!$this->rules) {
            throw new Exception('Pending implementation for getRules()');
        }
        return $this->rules;
    }

    public function rawArray(): array
    {
        if (!$this->value) {
            throw new Exception('Pending to set HasValidation \$value');
        }
        return $this->value;
    }

    public function validate(?array $data = null): void
    {
        $to_validate = $data ?? $this->rawArray();

        $validator = $this->getValidator($to_validate);
        $this->checkValidator($validator);
    }

    public function getValidator(array $data): ValidationValidator
    {

        return Validator::make($data, $this->getRules());
    }
    public function checkValidator(ValidationValidator $validator): void
    {
        if ($validator->fails()) {
            $this->throwValidationException($validator->errors()->all());
        }
    }

    public function throwValidationException(array $message): void
    {
        throw ValidationException::withMessages($message);
    }
}
