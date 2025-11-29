<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\BookingController;

Route::prefix('v1')->group(function () {
    Route::apiResource('rooms', RoomController::class);
    Route::apiResource('bookings', BookingController::class);
});

