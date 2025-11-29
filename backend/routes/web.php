<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
})->name('home');

Route::get('/services', function () {
    return view('service');
})->name('services');

Route::get('/book', function () {
    return view('book');
})->name('book');

Route::get('/admin', function () {
    return view('admin');
})->name('admin');
