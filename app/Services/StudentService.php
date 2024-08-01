<?php

namespace App\Services;

use App\Interfaces\Services\IStudentService;
use Carbon\Carbon;
use Carbon\WeekDay;
use Exception;
use Illuminate\Support\Facades\DB;

class StudentService implements IStudentService
{
    public function canBookClass(int $studentId, int $classBlockId): bool
    {
        $hourBlockInfo = $this->getHourBlockInfo($classBlockId);

        $overlapBookedClasses = DB::select(
            '
                SELECT bc.* FROM booked_classes bc
                JOIN class_room_hour_blocks crhb ON crhb.id=bc.class_room_hour_block_id
                JOIN hour_blocks hb ON hb.id=crhb.hour_block_id
                WHERE bc.student_id=:student_id AND bc.was_canceled=0 AND
                ((hb.start_time <= \''.$hourBlockInfo->end_time.'\' && hb.start_time>= \''.$hourBlockInfo->start_time.'\')
                OR  (hb.end_time <= \''.$hourBlockInfo->end_time.' \' && hb.end_time>=  \''.$hourBlockInfo->start_time.' \'))
            ',
            ['student_id' => $studentId]
        );

        return count($overlapBookedClasses) == 0;
    }

    public function canCancelClass(int $studentId, int $classBlockId): bool
    {
        $hourBlockInfo = $this->getHourBlockInfo($classBlockId);
        $classBlockInfo = $this->getClassBlockInfo($classBlockId);

        $now = Carbon::now();
        $weekday = WeekDay::from($classBlockInfo->weekday + 0);
        $targetDate = $now->copy()->next($weekday->name)->setTimeFromTimeString($hourBlockInfo->start_time);
        if($now->isSameDay($targetDate)) {
            return false;
        }
        if ($targetDate->isPast()) {
            $targetDate->addWeek();
        }
        return $now->diffInHours($targetDate) > 24;
    }

    private function getClassBlockInfo(int $classBlockId)
    {
        $result = DB::select('SELECT * FROM class_room_hour_blocks WHERE id=?', [$classBlockId]);
        if (!isset($result[0])) {
            throw new Exception("Couldn't find the class block information.");
        }
        return $result[0];
    }
    private function getHourBlockInfo(int $classBlockId)
    {
        $result = DB::select('SELECT hb.* FROM hour_blocks hb JOIN class_room_hour_blocks crhb ON hb.id=crhb.hour_block_id WHERE crhb.id=?', [$classBlockId]);
        if (!isset($result[0])) {
            throw new Exception("Couldn't find the block information");
        }
        return $result[0];
    }
}
