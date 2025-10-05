<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/library', function () {
    return view('library');
})->name('library');

Route::get('/product', function () {
    return view('product');
})->name('product');