<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;

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
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        // * 註冊
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        // * 更新用戶資料
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        // * 刪除帳號
    }

    /**
     * Return the authenticated user's information.
     */
    public function me()
    {
        // * 取得用戶資料

        $user = auth()->user();

        // return response()->json($user);

        return new UserResource($user);
    }
}
