<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAuthRequest;
use App\Http\Requests\UpdateAuthRequest;
use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

/**
 * @tags 01.Auth
 */
class AuthController extends Controller
{
    /**
     * 註冊
     *
     * @unauthenticated
     */
    public function register(StoreAuthRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        /**
         * @status 201
         */
        return new UserResource($user);
    }

    /**
     * 登入
     *
     * @unauthenticated
     */
    public function login(Request $request)
    {
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
    }

    /**
     * 登出
     */
    public function logout(Request $request)
    {
        // * 直接取得token的值
        // * $token = $request->bearerToken();

        $request->user()->currentAccessToken()?->delete();

        return response(null, 204);
    }

    /**
     * 資料
     */
    public function me()
    {
        $user = auth()->user();

        return new UserResource($user);
    }

    /**
     * 修改
     */
    public function update(UpdateAuthRequest $request)
    {
        $user = auth()->user();

        $user->fill($request->safe()->only(['name']));

        $user->save();

        return new UserResource($user);
    }

    /**
     * 變更密碼
     */
    public function changePassword(UpdatePasswordRequest $request)
    {
        $user = auth()->user();

        if (! Hash::check($request->old_password, $user->password)) {
            return response()->json([
                'message' => 'The old password is incorrect.',
            ], 422);
        }

        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return new UserResource($user);
    }
}
