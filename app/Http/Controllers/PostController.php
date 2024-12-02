<?php

namespace App\Http\Controllers;

use App\Data\PostData;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use Illuminate\Support\Facades\Gate;
use Spatie\QueryBuilder\QueryBuilder;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAny', Post::class);

        $posts = QueryBuilder::for(Post::class)
            ->allowedFilters(['title'])
            ->allowedIncludes(['user'])
            // ->allowedFields(['id', 'title'])
            ->paginate(5);

        $data = PostData::collect($posts);

        return $data;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        $postData = PostData::from($request);

        $post = Post::create($postData->toArray());

        $post->addMediaFromRequest('cover')->toMediaCollection('cover');
        $post->addMediaFromRequest('images')->toMediaCollection('images');

        $data = PostData::from($post);

        return $data;
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return PostData::from($post->with('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        //
    }
}
