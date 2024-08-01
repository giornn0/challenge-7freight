<?php

namespace App\Models;

class ClassRoom extends ElasticModel
{
    public ?string $table = 'class_rooms';

    public ?array $rules = [
        'name' => 'string|max:255|unique:class_rooms',
        'max_students_per_hour_block' => 'integer|max:50'
    ];

}
