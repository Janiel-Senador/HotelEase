<?php

use Illuminate\Support\Facades\Route;
use App\Models\Room;
use App\Models\Booking;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\GuestAdminController;

Route::get('/', function () {
    return view('index');
})->name('home');

Route::get('/services', function () {
    return view('service');
})->name('services');

Route::get('/book', [BookingController::class, 'webCreate'])->name('book');
Route::post('/book-now', [BookingController::class, 'webStore'])->name('book-now');
Route::get('/receipt/{booking}', [BookingController::class, 'receipt'])->name('booking.receipt');

Route::get('/login', [GuestController::class, 'showLogin'])->name('login');
Route::post('/login', [GuestController::class, 'login'])->name('login.post');
Route::get('/register', [GuestController::class, 'showRegister'])->name('register');
Route::post('/register', [GuestController::class, 'register'])->name('register.post');
Route::post('/logout', [GuestController::class, 'logout'])->name('logout');
Route::middleware('auth')->group(function(){
    Route::get('/my-bookings', [GuestController::class, 'myBookings'])->name('my_bookings');
});

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
    Route::post('/admin/bookings/{booking}/delete', [BookingController::class, 'adminDelete'])->name('admin.booking.delete');

    Route::get('/admin/staff', [StaffController::class, 'index'])->name('admin.staff');
    Route::post('/admin/staff', [StaffController::class, 'store'])->name('admin.staff.store');
    Route::post('/admin/staff/{user}/update', [StaffController::class, 'update'])->name('admin.staff.update');
    Route::post('/admin/staff/{user}/deactivate', [StaffController::class, 'deactivate'])->name('admin.staff.deactivate');
    Route::post('/admin/staff/{user}/activate', [StaffController::class, 'activate'])->name('admin.staff.activate');
    Route::post('/admin/staff/{user}/delete', [StaffController::class, 'destroy'])->name('admin.staff.delete');

    Route::get('/admin/rooms', function(){ return view('admin_rooms'); })->name('admin.rooms');
    Route::post('/admin/rooms', [RoomController::class, 'store'])->name('admin.rooms.store');
    Route::post('/admin/rooms/{room}/update', [RoomController::class, 'update'])->name('admin.rooms.update');
    Route::post('/admin/rooms/{room}/delete', [RoomController::class, 'destroy'])->name('admin.rooms.delete');

    Route::get('/admin/history/export/docx', [BookingController::class, 'exportHistoryDocx'])->name('admin.history.export.docx');
    Route::get('/admin/history/export/doc', [BookingController::class, 'exportHistoryDoc'])->name('admin.history.export.doc');

    Route::post('/admin/guests/{guest}/activate', [GuestAdminController::class, 'activate'])->name('admin.guests.activate');
    Route::post('/admin/guests/{guest}/deactivate', [GuestAdminController::class, 'deactivate'])->name('admin.guests.deactivate');
    Route::post('/admin/guests/{guest}/update', [GuestAdminController::class, 'update'])->name('admin.guests.update');
    Route::post('/admin/guests/{guest}/delete', [GuestAdminController::class, 'destroy'])->name('admin.guests.delete');
});

Route::get('/DBarea', function () {
    $rooms = Room::query()->withCount('bookings')->orderBy('number')->get();
    $bookings = Booking::query()->with('room')->orderByDesc('id')->limit(50)->get();
    return view('dbarea', compact('rooms', 'bookings'));
})->name('dbarea');

Route::view('/about', 'about')->name('about');
Route::view('/faqs', 'faqs')->name('faqs');
Route::view('/terms', 'terms')->name('terms');
Route::view('/privacy', 'privacy')->name('privacy');
Route::view('/language', 'language')->name('language');
