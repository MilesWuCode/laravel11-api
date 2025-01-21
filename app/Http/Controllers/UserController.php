<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * 註冊
     */
    public function store(StoreUserRequest $request)
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
     * 顯示用戶資料
     */
    public function show(User $user)
    {
        return new UserResource($user);
    }

    /**
     * 取得用戶資料
     */
    public function me()
    {
        $user = auth()->user();

        return new UserResource($user);
    }

    /**
     * 更新用戶資料
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $user->fill($request->safe()->only(['name']));

        $user->save();

        return new UserResource($user);
    }

    public function changePassword(UpdatePasswordRequest $request)
    {
        // * 變更密碼

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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        // * 刪除帳號
    }
}
