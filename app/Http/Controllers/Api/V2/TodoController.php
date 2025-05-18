<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTodoRequest;
use App\Http\Requests\UpdateTodoRequest;
use App\Http\Resources\TodoResource;
use App\Models\Todo;
use Dedoc\Scramble\Attributes\Group;
use Illuminate\Support\Facades\Gate;

#[Group(name: 'Todo', weight: 1)]
class TodoController extends Controller
{
    /**
     * 列表
     */
    public function index()
    {
        Gate::authorize('viewAny', Todo::class);

        $todos = auth()->user()->todos()->paginate(5);

        return TodoResource::collection($todos);
    }

    /**
     * 新增
     */
    public function store(StoreTodoRequest $request)
    {
        // * 開啓SQL查詢日誌
        // \Illuminate\Support\Facades\DB::enableQueryLog();

        $validatedData = $request->validated();

        $todo = new Todo($validatedData);

        $todo->user()->associate(auth()->user())->save();

        // * SQL操作寫到log檔
        // logger(\Illuminate\Support\Facades\DB::getQueryLog());

        return new TodoResource($todo);
    }

    /**
     * 顯示
     */
    public function show(Todo $todo)
    {
        Gate::authorize('view', $todo);

        return new TodoResource($todo);
    }

    /**
     * 修改
     */
    public function update(UpdateTodoRequest $request, Todo $todo)
    {
        $validatedData = $request->validated();

        $todo->fill($validatedData)->save();

        return new TodoResource($todo);
    }

    /**
     * 刪除
     */
    public function destroy(Todo $todo)
    {
        Gate::authorize('delete', $todo);

        $todo->delete();

        return response()->noContent();
    }
}
