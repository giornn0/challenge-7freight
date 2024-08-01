<?php

namespace Database\Seeders;

use App\Enums\ClassRoomsNames;
use App\Models\ClassRoomHourBlock;
use App\Models\HourBlock;
use App\Models\ClassRoom;
use Carbon\WeekDay;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClassRoomHourBlockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    private array $_classRoomsInformation = [
        ClassRoomsNames::Math->value => [
            'weekdays' => [WeekDay::Monday,WeekDay::Tuesday,WeekDay::Wednesday],
            'schedule' => [2 , [9,19]],
        ],
        ClassRoomsNames::Art ->value => [
            'weekdays' => [WeekDay::Monday,WeekDay::Thursday,WeekDay::Saturday],
            'schedule' => [1 , [8,18]],
        ],
        ClassRoomsNames::Science ->value => [
            'weekdays' => [WeekDay::Tuesday,WeekDay::Friday,WeekDay::Saturday],
            'schedule' => [1 , [15,22]],
        ],
        ClassRoomsNames::Geography->value => [
            'weekdays' => [WeekDay::Thursday,WeekDay::Friday],
            'schedule' => [2 , [8,18]],
        ],
        ClassRoomsNames::Computer->value => [
            'weekdays' => [WeekDay::Monday,WeekDay::Friday],
            'schedule' => [1 , [13,15]],
        ],
        ClassRoomsNames::History ->value => [
            'weekdays' => [WeekDay::Tuesday,WeekDay::Wednesday],
            'schedule' => [3 , [10,19]],
        ],
    ];
    public function run(): void
    {
        $classRoomClass = new ClassRoom();
        $hourBlockClass = new HourBlock();
        foreach ($this->_classRoomsInformation as $classRoomName => $info) {
            $classRoomId =  DB::select('SELECT id from '.$classRoomClass->table.' WHERE name=?', [$classRoomName])[0]->id;
            [$classDuration, [$start, $end]] = $info['schedule'];

            $bottomHour = $start;
            $hourBlocksIds = [];
            while ($bottomHour < $end) {
                $startTime = $bottomHour < 10 ? '0'.$bottomHour : ''.$bottomHour;
                $e = $bottomHour + $classDuration;
                $endTime = $e < 10 ? '0'.$e : ''.$e;
                $hourBlocksIds[] =  DB::select('SELECT id from '.$hourBlockClass->table.' WHERE start_time=? AND end_time=?', [$startTime.':00', $endTime.':00'])[0]->id;
                $bottomHour += $classDuration;
            }

            foreach ($info['weekdays'] as $weekday) {
                foreach ($hourBlocksIds as $hourBlockId) {
                    $classRoomHourBlock = new ClassRoomHourBlock(
                        [
                            'hour_block_id' => $hourBlockId,
                            'class_room_id' => $classRoomId,
                            'weekday' => $weekday->value,
                        ]
                    );
                    $classRoomHourBlock->create();
                }
            }
        }
    }
}
