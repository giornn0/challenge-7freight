<?php

namespace App\Models;

class BookedClass extends ElasticModel
{
    public ?string $table = 'booked_classes';

    public ?array $rules = [
        'student_id' => 'int|exists:students,id',
        'class_room_hour_block_id' => 'int|exists:class_room_hour_blocks,id',
        'was_canceled' => 'nullable|boolean',
    ];
}
