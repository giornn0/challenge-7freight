<?php

namespace App\Models;

class HourBlock extends ElasticModel
{
    public ?string $table = 'hour_blocks';

    public ?array $rules = [
        'start_time' => 'date_format:H:i',
        'end_time' => 'date_format:H:i|after:start_time'
    ];
}
