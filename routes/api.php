<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('password/email', [PasswordResetController::class, 'sendResetLink'])->name('password.email');
Route::post('password/reset', [PasswordResetController::class, 'reset'])->name('password.update');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/users', [UserController::class, 'index']);
    Route::get('/users/{user}', [UserController::class, 'show']);
    Route::put('/users/{user}', [UserController::class, 'update']);
    Route::delete('/users/{user}', [UserController::class, 'destroy']);
    Route::get('/users/trashed', [UserController::class, 'trashed']); // should be fixed
    Route::post('/users/{user}/restore', [UserController::class, 'restore']); // should be fixed
    Route::delete('/users/force-delete/{user}', [UserController::class, 'forceDelete']);
    Route::post('/users/bulk-delete', [UserController::class, 'bulkDelete']);
    Route::post('/users/bulk-restore', [UserController::class, 'bulkRestore']); // should be fixed
    Route::delete('/users/bulk-force-delete', [UserController::class, 'bulkForceDelete']); // should be fixed
});
