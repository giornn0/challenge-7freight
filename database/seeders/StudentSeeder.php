<?php

namespace Database\Seeders;

use App\Models\Student;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $amount = 1;
        while ($amount <= 50) {
            $studentOne = new Student(['fullname' => 'Studen N° '. $amount]);
            $studentOne->create();
            $amount += 1;
        }
    }
}
