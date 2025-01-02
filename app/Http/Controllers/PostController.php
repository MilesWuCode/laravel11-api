<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Services\PostService;
use Illuminate\Support\Facades\DB;

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
        $data = $this->postService->list();

        return PostResource::collection($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        $data = $request->safe()->only([
            'title',
            'description',
        ]);

        $post = DB::transaction(function () use ($data) {
            $post = $this->postService->create($data);

            return $post;
        });

        $post->load(['user', 'media']);

        return new PostResource($post);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        $post = $this->postService->show($post);

        $post->load(['user', 'media']);

        return new PostResource($post);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        $data = $request->safe()->only([
            'title',
            'description',
        ]);

        $post = DB::transaction(function () use ($post, $data) {
            return $this->postService->update($post, $data);
        });

        $post->load(['user', 'media']);

        return new PostResource($post);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        // * 使用交易,自動提交/還原
        DB::transaction(function () use ($post) {
            $this->postService->delete($post);
        });

        return response()->noContent();

        // * 使用交易,手動提交/還原
        // DB::beginTransaction();

        // try {
        //     $this->postService->delete($post);

        //     DB::commit();

        //     return response()->noContent();
        // } catch (\Exception $ex) {
        //     DB::rollBack();

        //     throw $ex;
        // }
    }

    public function destroyImage(Post $post, int $mediaId)
    {
        DB::transaction(function () use ($post, $mediaId) {
            $this->postService->deleteImage($post, $mediaId);
        });

        $post->load(['user', 'media']);

        return new PostResource($post);
    }
}
