<?php

namespace App\Http\Controllers;

use App\Data\PostData;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\PostResource;
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

        $data = QueryBuilder::for(Post::class)
            ->allowedFilters(['title'])
            ->allowedFields(['description', 'published_at'])
            ->allowedIncludes(['user'])
            ->select(['id', 'title', 'created_at', 'updated_at', 'user_id'])
            ->paginate(5);

        return PostResource::collection($data);
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

        return $post;
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        Gate::authorize('view', $post);

        // return PostData::from($post->with('user'));

        $post->load('user');

        return PostResource::make($post);
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
        Gate::authorize('delete', $post);

        $post->delete();

        return response(null, 204);
    }
}
