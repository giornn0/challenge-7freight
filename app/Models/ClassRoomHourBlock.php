<?php

namespace App\Models;

use Carbon\WeekDay;
use Illuminate\Validation\Rule;

class ClassRoomHourBlock extends ElasticModel
{
    public ?string $table = 'class_room_hour_blocks';


    public function getRules(): array
    {
        return [
            'class_room_id' => 'int|exists:class_rooms,id',
            'hour_block_id' => 'int|exists:hour_blocks,id',
            'weekday' => [Rule::enum(WeekDay::class)],
            'is_active' => 'nullable|boolean',
        ];
    }
}
