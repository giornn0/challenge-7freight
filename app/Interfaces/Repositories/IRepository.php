<?php

namespace App\Interfaces\Repositories;

use App\Interfaces\Traits\IHasValidation;

interface IRepository
{
    public function tableToUse(): string;
    public function rawUpdateValuesQueryArray(IHasValidation $data): array;
    public function rawCreateValuesQueryArray(IHasValidation $data): array;
    public function create(?IHasValidation $data): void;
    public function delete(int $id): void;
    public function update(int $id, ?IHasValidation $data): void;
}
