<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Public routes (no auth)
Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);

// Protected routes (require auth)
Route::middleware('auth:sanctum')->group(function () {
    // Route::post('/logout', [UserController::class, 'logout']);
    // Route::delete('/users/{id}', [UserController::class, 'delete']);
});
