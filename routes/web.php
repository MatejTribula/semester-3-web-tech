<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// only for making requests through postman
Route::get('/generate-csrf', function () {
    return response()->json([
        'csrf_token' => csrf_token(),
    ]);
});

Route::get('/', function () {
    return redirect('/products'); // done
});

// Auth
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister']); // done
    Route::post('/register', [AuthController::class, 'register'])->name('register'); // done
    Route::get('/login', [AuthController::class, 'showLogin']); // done
    Route::post('/login', [AuthController::class, 'login'])->name('login'); // done
});

Route::middleware('auth')->group(function () {
    Route::get('/products/create', [ProductController::class, 'create'])->name('create'); // done
    Route::post('/products', [ProductController::class, 'store'])->name('store'); // done

    Route::get('products/{id}/edit', [ProductController::class, 'edit'])->name('edit'); // done
    Route::put('/products/{id}', [ProductController::class, 'update'])->name('update'); // done

    Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('destroy'); // done

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout'); // done

    Route::get('/favorites', [FavoriteController::class, 'getFavoriteProducts'])->name('favorites'); // done
    Route::post('/products/{id}/favorite', [FavoriteController::class, 'addFavorite'])->name('star');
    Route::delete('/products/{id}/favorite', [FavoriteController::class, 'removeFavorite'])->name('unstar');

    Route::get('/my-uploads', [UserController::class, 'productsByCollaborator'])->name('my-uploads'); // done
    Route::put('/profile/{userId}', [UserController::class, 'updateProfile'])->name('profile.update');
});

Route::get('/products', [ProductController::class, 'index'])->name('home'); // done
Route::get('/products/{id}', [ProductController::class, 'show'])->name('show'); // done

// Route::get('/profile/{id}', function () {
//    return view('profile');
// })->name('profile');

// Route::get('/library', function () {
//    return view('library');
// })->name('library');

// Route::get('/publish-new-game', function () {
//     return view('products/create');
// })->name('publish-new-game');

Route::get('/profile/{userId?}', [UserController::class, 'showUserPage'])->name('profile');
