<?php

namespace App\Interfaces\Services;

interface IClassRoomService
{
    public function getSchedule(): array;
    public function bookClass(int $studentId, int $classBlockId): bool;
    public function cancelBookedClass(int $studentId, int $classBlockId): bool;
}
