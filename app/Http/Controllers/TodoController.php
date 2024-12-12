<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTodoRequest;
use App\Http\Requests\UpdateTodoRequest;
use App\Http\Resources\TodoResource;
use App\Models\Todo;
use Illuminate\Support\Facades\Gate;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAny', Todo::class);

        $todos = auth()->user()->todos()->paginate(5);

        return TodoResource::collection($todos);
    }

    /**
     * Store a newly created resource in storage.
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
     * Display the specified resource.
     */
    public function show(Todo $todo)
    {
        Gate::authorize('view', $todo);

        return new TodoResource($todo);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTodoRequest $request, Todo $todo)
    {
        $validatedData = $request->validated();

        $todo->fill($validatedData)->save();

        return new TodoResource($todo);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Todo $todo)
    {
        Gate::authorize('delete', $todo);

        $todo->delete();

        return response()->noContent();
    }
}
