<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\ValidationException;

// 取得用戶令牌
Route::post('/login', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
        'device_name' => 'required',
    ]);

    $user = User::where('email', $request->email)->first();

    if (! $user || ! Hash::check($request->password, $user->password)) {
        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.'],
        ]);
    }

    return response()->json(['token' => $user->createToken($request->device_name)->plainTextToken]);
});

// 撤銷用戶令牌
Route::delete('/logout', function (Request $request) {
    // * 直接取得token的值
    // * $token = $request->bearerToken();

    $request->user()->currentAccessToken()?->delete();

    return response(null, 204);

})->middleware('auth:sanctum');

Route::post('/register', [App\Http\Controllers\UserController::class, 'store']);

// 取得用戶資料
Route::get('/user', fn(Request $request) => $request->user())->middleware(['auth:sanctum', 'cache.response']);

Route::get('/me', [App\Http\Controllers\UserController::class, 'me'])
    ->middleware(['auth:sanctum', 'cache.response']);

Route::patch('/me', [App\Http\Controllers\UserController::class, 'update'])
    ->middleware(['auth:sanctum', 'cache.response']);

Route::apiResource('todos', App\Http\Controllers\TodoController::class)
    ->middleware(['auth:sanctum', 'cache.response']);

Route::apiResource('posts', App\Http\Controllers\PostController::class)
    ->middleware(['auth:sanctum', 'cache.response']);

Route::delete('/posts/{post}/image/{mediaId}', [App\Http\Controllers\PostController::class, 'destroyImage'])
    ->middleware(['auth:sanctum', 'cache.response']);
