<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/favorites', function () {
    return view('favorites');
})->name('favorites');

Route::get('/my-uploads', function () {
    return view('my-uploads');
})->name('my-uploads');

Route::get('/profile', function () {
    return view('profile');
})->name('profile');

Route::get('/product', function () {
    return view('home');
})->name('product');