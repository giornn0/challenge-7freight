<?php

namespace App\Models;

use App\Interfaces\Repositories\IRepository;
use App\Interfaces\Traits\IHasValidation;
use App\Repositories\Repository;
use App\Traits\HasValidation;

class ElasticModel extends Repository implements IHasValidation, IRepository
{
    use HasValidation;
    public ?string $table;
    public function tableToUse(): string
    {
        return $this->table;
    }

    public function __construct(?array $data = null, ?string $table = null)
    {
        $this->value = $this->value ?? $data;
        $this->table = $this->table ?? $table;
    }
}
