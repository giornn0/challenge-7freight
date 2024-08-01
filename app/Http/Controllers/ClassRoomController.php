<?php

namespace App\Http\Controllers;

use App\Interfaces\Controllers\IClassRoomController;
use App\Interfaces\Services\IClassRoomService;
use App\Services\ClassRoomService;
use App\Traits\HasApiResponse;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class ClassRoomController implements IClassRoomController
{
    use HasApiResponse;
    private IClassRoomService $_classRoomService;

    public function __construct(IClassRoomService $classRoomService = null)
    {
        $this->_classRoomService = $classRoomService ?? new ClassRoomService();
    }

    public function getSchedule(Request $request): JsonResponse
    {
        try {
            $schedule = $this->_classRoomService->getSchedule();
            return $this->success($schedule);
        } catch(Exception $e) {
            return $this->error(500, $e->getMessage());
        }
    }

    public function book(Request $request): JsonResponse
    {
        DB::beginTransaction();
        try {
            $studentId = $request->get('studentId');
            $classBlockId = $request->get('classBlockId');
            $resultBooked = $this->_classRoomService->bookClass($studentId, $classBlockId);
            DB::commit();
            return $this->success($resultBooked);
        } catch(Exception $e) {
            DB::rollBack();
            return $this->error(500, $e->getMessage());
        }
    }

    public function removeBooked(Request $request): JsonResponse
    {
        DB::beginTransaction();
        try {
            $studentId = $request->get('studentId');
            $classBlockId = $request->get('classBlockId');
            $resultCancelation = $this->_classRoomService->cancelBookedClass($studentId, $classBlockId);
            DB::commit();
            return $this->success($resultCancelation);
        } catch(Exception $e) {
            DB::rollBack();
            return $this->error(500, $e->getMessage());
        }
    }

}
