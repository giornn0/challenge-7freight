<?php

use App\Http\Controllers\ClassRoomController;
use Illuminate\Support\Facades\Route;

Route::prefix('classes')
    ->group(
        function () {
            // 1. Build an endpoint that shows all the available classes along with the name of the
            // classroom, its timetable and the current availability.
            Route::get('schedule', [ClassRoomController::class, 'getSchedule'])->name('getSchedule');
            // 2. Build an endpoint to book a class, we need to be able to choose the time slot that we
            // want to use. Be aware, assuming the same person is trying to book through your API,
            // make sure that different classes do not overlap with each other.
            Route::post('book', [ClassRoomController::class, 'book'])->name('bookClass');
            // 3. Build an endpoint to cancel a class that was booked previously, a class cannot be
            // canceled less than 24 hours in advance.
            Route::delete('book', [ClassRoomController::class, 'removeBooked'])->name('removeBookedClass');
        }
    );
