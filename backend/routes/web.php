<?php

use Illuminate\Support\Facades\Route;
use App\Models\Room;
use App\Models\Booking;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('index');
})->name('home');

Route::get('/services', function () {
    return view('service');
})->name('services');

Route::get('/book', [BookingController::class, 'webCreate'])->name('book');
Route::post('/book-now', [BookingController::class, 'webStore'])->name('book-now');
Route::get('/receipt/{booking}', [BookingController::class, 'receipt'])->name('booking.receipt');

Route::get('/admin/login', [AuthController::class, 'loginForm'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'login'])->name('admin.login.post');
Route::post('/admin/logout', [AuthController::class, 'logout'])->name('admin.logout');

Route::middleware('admin')->group(function(){
    Route::get('/admin', function () {
        return view('admin');
    })->name('admin');
    Route::post('/admin/bookings/{booking}/accept', [BookingController::class, 'accept'])->name('booking.accept');
    Route::post('/admin/bookings/{booking}/cancel', [BookingController::class, 'cancel'])->name('booking.cancel');
    Route::get('/admin/room-management', function(){
        $bookings = Booking::with('room')->orderByDesc('id')->get();
        return view('admin_room_management', compact('bookings'));
    })->name('admin.room_management');
    Route::post('/admin/bookings/{booking}/update', [BookingController::class, 'adminUpdate'])->name('admin.booking.update');
});

Route::get('/DBarea', function () {
    $rooms = Room::query()->withCount('bookings')->orderBy('number')->get();
    $bookings = Booking::query()->with('room')->orderByDesc('id')->limit(50)->get();
    return view('dbarea', compact('rooms', 'bookings'));
})->name('dbarea');
