<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FavoriteController;

Route::get('/generate-csrf', function () {
    return response()->json([
        'csrf_token' => csrf_token(),
    ]);
});

Route::get('/', function () {
    return redirect('/products');
});

// Auth
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister']);
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::get('/login', [AuthController::class, 'showLogin']);
    Route::post('/login', [AuthController::class, 'login'])->name('login');
});

Route::middleware('auth')->group(function () {
    Route::get('/products/create', [ProductController::class, 'create'])->name('create');
    Route::post('/products', [ProductController::class, 'store'])->name('store');

    Route::get('products/{id}/edit', [ProductController::class, 'edit']);
    Route::put('/products/{id}', [ProductController::class, 'update'])->name('update');

    Route::delete('/products/{id}', [ProductController::class, 'destroy']);

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/favorites', [FavoriteController::class, 'getFavoriteProducts'])->name('favorites');
    Route::post('/products/{id}/favorite', [FavoriteController::class, 'addFavorite'])->name('star');
    Route::post('/products/{id}/unfavorite', [FavoriteController::class, 'removeFavorite'])->name('unstar');

    Route::get('/my-uploads', [UserController::class, 'productsByCollaborator'])->name('my-uploads');

});

Route::get('/products', [ProductController::class, 'index'])->name('home');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('show');

Route::get('/profile', function () {
    return view('profile');
})->name('profile');

Route::get('/product', function () {
    return view('product');
})->name('product');

Route::get('/library', function () {
    return view('library');
})->name('library');

Route::get('/publish-new-game', function () {
    return view('publish-new-game');
})->name('publish-new-game');
