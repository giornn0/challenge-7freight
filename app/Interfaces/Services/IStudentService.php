<?php

namespace App\Interfaces\Services;

interface IStudentService
{
    public function canBookClass(int $studentId, int $classBlockId): bool;
    public function canCancelClass(int $studentId, int $classBlockId): bool;
}
