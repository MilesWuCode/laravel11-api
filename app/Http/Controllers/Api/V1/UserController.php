<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;

class UserController extends Controller
{
    /**
     * 顯示用戶資料
     */
    public function show(User $user)
    {
        return new UserResource($user);
    }
}
