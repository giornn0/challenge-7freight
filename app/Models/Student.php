<?php

namespace App\Models;

class Student extends ElasticModel
{
    public ?string $table = 'students';

    public ?array $rules = [
        'fullname' => 'string|max:255|unique:students,fullname'
    ];
}
