<?php

use Illuminate\Support\Facades\Route;

Route::apiResource('todos', App\Http\Controllers\Api\V2\TodoController::class)
    ->middleware(['auth:sanctum', 'cache.response']);

Route::apiResource('posts', App\Http\Controllers\Api\V2\PostController::class)
    ->middleware(['auth:sanctum', 'cache.response']);

Route::delete('/posts/{post}/image/{mediaId}', [App\Http\Controllers\Api\V2\PostController::class, 'destroyImage'])
    ->middleware(['auth:sanctum', 'cache.response']);
