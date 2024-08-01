<?php

namespace Database\Seeders;

use App\Models\HourBlock;
use Illuminate\Database\Seeder;

class HourBlockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    private array $_scheduler = [
    // classDuration , [start , end]
        [1 , [8,22]],
        [2 , [7,23]],
        [2 , [8,22]],
        [3 , [7,22]],
    ];
    public function run(): void
    {
        foreach ($this->_scheduler as  $item) {
            [$classDuration, [$start,$end]] = $item;
            $bottomHour = $start;
            while ($bottomHour < $end) {
                $startTime = $bottomHour < 10 ? '0'.$bottomHour : ''.$bottomHour;
                $e = $bottomHour + $classDuration;
                $endTime = $e < 10 ? '0'.$e : ''.$e;
                $hourBlock = new HourBlock(
                    [
                     'start_time' => $startTime.':00',
                     'end_time' => $endTime.':00'
                    ]
                );
                $hourBlock->create();
                $bottomHour += $classDuration;
            }
        }
    }
}
