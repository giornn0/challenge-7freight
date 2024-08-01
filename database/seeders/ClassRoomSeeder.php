<?php

namespace Database\Seeders;

use App\Enums\ClassRoomsNames;
use App\Models\ClassRoom;
use Illuminate\Database\Seeder;

class ClassRoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    private array $_classRooms = [
       ClassRoomsNames::Math->value => 10,
       ClassRoomsNames::Art ->value => 15,
       ClassRoomsNames::Science ->value => 7,
       ClassRoomsNames::Geography->value => 15,
       ClassRoomsNames::Computer->value => 23,
       ClassRoomsNames::History ->value => 11,
    ];
    public function run(): void
    {

        foreach ($this->_classRooms as $className => $maxStudents) {
            $classroom = new ClassRoom(['name' => $className ,'max_students_per_hour_block' => $maxStudents]);
            $classroom->create();
        }
    }
}
