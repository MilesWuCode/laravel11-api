<?php

namespace App\Http\Controllers;

use App\Data\PostData;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Services\PostService;
use Illuminate\Support\Facades\Gate;

// * HTTP請求
// * 調用Service
// * Request驗證輸入
// * Response返回輸出
// * 調用中間件
// * 視圖渲染
// * 權限控制

class PostController extends Controller
{
    protected $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAny', Post::class);

        $data = $this->postService->list();

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

        return PostResource::make($post);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        Gate::authorize('view', $post);

        $post->load(['user']);

        return PostResource::make($post);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        print_r($post);
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
