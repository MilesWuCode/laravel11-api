<?php

use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function (): void {
    // Auth
    Route::post('/register', [App\Http\Controllers\Api\V1\AuthController::class, 'register']);
    Route::post('/login', [App\Http\Controllers\Api\V1\AuthController::class, 'login']);

    // Me
    Route::middleware(['auth:sanctum'])->group(function (): void {
        Route::get('/me', [App\Http\Controllers\Api\V1\AuthController::class, 'me']);
        Route::patch('/me', [App\Http\Controllers\Api\V1\AuthController::class, 'update']);
        Route::patch('/me/change-password', [App\Http\Controllers\Api\V1\AuthController::class, 'changePassword']);
        Route::delete('/logout', [App\Http\Controllers\Api\V1\AuthController::class, 'logout']);
    });
});

// 多版本或外部檔案引入
Route::prefix('v2')->group(base_path('routes/api_v2.php'));
