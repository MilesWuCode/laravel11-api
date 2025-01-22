<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Services\PostService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

// * HTTP請求
// * 調用Service
// * Request驗證輸入
// * Response返回輸出
// * 調用中間件
// * 視圖渲染
// * 權限控制

/**
 * @tags 03.Post
 */
class PostController extends Controller
{
    protected $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    /**
     * 列表
     *
     * 顯示Post及頁碼
     */
    public function index(Request $request)
    {
        $request->validate([
            /**
             * 查詢
             */
            'filter[title]' => 'string',

            // 'fields[posts]' => 'string',

            /**
             * 關聯
             *
             * user
             */
            'include' => 'string',

            'sort' => 'string',

            /**
             * 頁數
             *
             * @default 1
             */
            'page' => 'numeric',

            /**
             * 筆數
             *
             * @default 15
             */
            'pre_page' => 'numeric',
        ]);

        $data = $this->postService->list();

        return PostResource::collection($data);
    }

    /**
     * 新增
     *
     * 新增一個Post
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
     * 顯示
     */
    public function show(Post $post)
    {
        $post = $this->postService->show($post);

        $post->load(['user', 'media']);

        return new PostResource($post);
    }

    /**
     * 修改
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        $data = $request->safe()->only([
            'title',
            'description',
        ]);

        $post = DB::transaction(fn () => $this->postService->update($post, $data));

        $post->load(['user', 'media']);

        return new PostResource($post);
    }

    /**
     * 刪除
     */
    public function destroy(Post $post)
    {
        // * 使用交易,自動提交/還原
        DB::transaction(function () use ($post): void {
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

    /**
     * 刪除圖片
     *
     * collection: image
     */
    public function destroyImage(Post $post, int $mediaId)
    {
        DB::transaction(function () use ($post, $mediaId): void {
            $this->postService->deleteImage($post, $mediaId);
        });

        $post->load(['user', 'media']);

        return new PostResource($post);
    }
}
