<?php

namespace App\Services;

use App\Interfaces\Services\IClassRoomService;
use App\Interfaces\Services\IStudentService;
use App\Models\BookedClass;
use Exception;
use Illuminate\Support\Facades\DB;

class ClassRoomService implements IClassRoomService
{
    private IStudentService $_studentService;
    public function __construct(IStudentService $studentService = null)
    {
        $this->_studentService = $studentService ?? new StudentService();
    }
    public function getSchedule(): array
    {
        $rawResults = DB::select(
            'SELECT cr.name,hb.start_time,hb.end_time, crhb.id,
                CASE
                    WHEN crhb.weekday = 0 THEN \'Sunday\'
                    WHEN crhb.weekday = 1 THEN \'Monday\'
                    WHEN crhb.weekday = 2 THEN \'Tuesday\'
                    WHEN crhb.weekday = 3 THEN \'Wednesday\'
                    WHEN crhb.weekday = 4 THEN \'Thursday\'
                    WHEN crhb.weekday = 5 THEN \'Friday\'
                    WHEN crhb.weekday = 6 THEN \'Saturday\'
                    ELSE \'Unknown\'
                END AS weekday_name
            FROM class_room_hour_blocks crhb
            JOIN class_rooms cr ON cr.id=crhb.class_room_id
            JOIN hour_blocks hb ON hb.id=crhb.hour_block_id
            WHERE crhb.is_active=1;'
        );
        return collect($rawResults)->reduce(function (array $result, $class) {
            if (!isset($result[$class->name])) {
                $result[$class->name] = [];
            }
            if (!isset($result[$class->name][$class->weekday_name])) {
                $result[$class->name][$class->weekday_name] = [];
            }
            $result[$class->name][$class->weekday_name][] = ['startTime' => $class->start_time,'endTime' => $class->end_time, 'classBlockId' => $class->id];
            return $result;
        }, []);
    }

    public function bookClass(int $studentId, int $classBlockId): bool
    {
        if (!$this->_studentService->canBookClass($studentId, $classBlockId)) {
            throw new Exception('Can\'t book class, overlaps with another class.');
        }

        if (!$this->availableSpot($classBlockId)) {
            throw new Exception('Can\'t book class, block without space.');
        }
        $book = new BookedClass(['student_id' => $studentId, 'class_room_hour_block_id' => $classBlockId]);
        $book->create();

        return true;
    }

    public function cancelBookedClass(int $studentId, int $classBlockId): bool
    {
        if(!$this->_studentService->canCancelClass($studentId, $classBlockId)) {
            throw new Exception('Can\'t cancel class, out of grace time for cancelation.');
        }
        if (!isset(DB::select('SELECT * FROM booked_classes WHERE student_id=? AND class_room_hour_block_id=?', [$studentId, $classBlockId])[0])) {
            throw new Exception('Student doesn\' have a correspondent booked class');
        }
        DB::delete('DELETE FROM booked_classes WHERE student_id=? AND class_room_hour_block_id=?', [$studentId, $classBlockId]);

        return true;
    }

    private function availableSpot(int $classBlockId): bool
    {
        $classRoomInfo = $this->getClassRoomInfo($classBlockId);

        $listBooked = DB::select('SELECT * FROM booked_classes WHERE class_room_hour_block_id=?', [$classBlockId]);

        return count($listBooked) < $classRoomInfo->max_students_per_hour_block;
    }

    private function getClassRoomInfo(int $classBlockId)
    {
        $result = DB::select(
            '
            SELECT cr.id,cr.max_students_per_hour_block FROM class_rooms cr
            JOIN class_room_hour_blocks crhb ON cr.id=crhb.class_room_id
            WHERE crhb.id=?',
            [$classBlockId]
        );
        if(!isset($result[0])) {
            throw new Exception("Couldn't find the class room information via class-block.");
        }

        return $result[0];
    }
}
