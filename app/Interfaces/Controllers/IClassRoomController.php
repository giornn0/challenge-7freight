<?php

namespace App\Interfaces\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

interface IClassRoomController
{
    public function getSchedule(Request $request): JsonResponse;
    public function book(Request $request): JsonResponse;
    public function removeBooked(Request $request): JsonResponse;
}
