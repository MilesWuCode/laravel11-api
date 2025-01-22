<?php

use Illuminate\Support\Facades\Route;

// Auth
Route::post('/register', [App\Http\Controllers\AuthController::class, 'register']);
Route::post('/login', [App\Http\Controllers\AuthController::class, 'login']);
Route::middleware(['auth:sanctum'])->group(function (): void {
    Route::get('/me', [App\Http\Controllers\AuthController::class, 'me']);
    Route::patch('/me', [App\Http\Controllers\AuthController::class, 'update']);
    Route::patch('/me/change-password', [App\Http\Controllers\AuthController::class, 'changePassword']);
    Route::delete('/logout', [App\Http\Controllers\AuthController::class, 'logout']);
});

Route::apiResource('todos', App\Http\Controllers\TodoController::class)
    ->middleware(['auth:sanctum', 'cache.response']);

Route::apiResource('posts', App\Http\Controllers\PostController::class)
    ->middleware(['auth:sanctum', 'cache.response']);

Route::delete('/posts/{post}/image/{mediaId}', [App\Http\Controllers\PostController::class, 'destroyImage'])
    ->middleware(['auth:sanctum', 'cache.response']);
