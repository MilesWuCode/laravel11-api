<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

// 取得用戶資料
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// 取得用戶令牌
Route::post('/sanctum/token', function (Request $request) {
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

    return $user->createToken($request->device_name)->plainTextToken;
});

// 撤銷用戶令牌
// Route::post('/logout', function (Request $request) {


//     $user->tokens()->where('id', $tokenId)->delete();
//     return $request->user();
// })->middleware('auth:sanctum');
