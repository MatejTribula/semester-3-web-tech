<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/generate-csrf', function () {
    return response()->json([
        'csrf_token' => csrf_token(),
    ]);
});

Route::get('/', [ProductController::class, 'index'])->name('home');
Route::post('/products', [ProductController::class, 'store']);

Route::get('/create', [ProductController::class, 'create'])->name('create');

//
//
//
//

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
    return view('product');
})->name('product');

Route::get('/library', function () {
    return view('library');
})->name('library');

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::get('/register', function () {
    return view('register');
})->name('register');

Route::get('/publish-new-game', function () {
    return view('publish-new-game');
})->name('publish-new-game');
