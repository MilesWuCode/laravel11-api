<?php

namespace App\Services;

use App\Interfaces\PostRepositoryInterface;
use App\Models\Post;
use Illuminate\Support\Facades\Gate;

// * 業務邏輯
// * 調用Repository提供的數據操作
// * 數據轉換
// * 權限檢查
// * 觸發事件
// * 發送通知
// * 外部API呼叫

class PostService
{
    public function __construct(private readonly PostRepositoryInterface $postRepositoryInterface)
    {
    }

    public function list()
    {
        Gate::authorize('viewAny', Post::class);

        $data = $this->postRepositoryInterface->list();

        return $data;
    }

    public function create(array $data)
    {
        Gate::authorize('create', Post::class);

        $post = $this->postRepositoryInterface->store($data);

        if (request()->hasFile('cover')) {
            $post->addMediaFromRequest('cover')
                ->toMediaCollection('cover');
        }

        if (request()->hasFile('images')) {
            $mediaItems = $post->addMultipleMediaFromRequest(['images']);
            foreach ($mediaItems as $fileAdder) {
                $fileAdder->toMediaCollection('images');
            }
        }

        return $post;
    }

    public function show(Post $post)
    {
        Gate::authorize('view', $post);

        // * 用到DB操作才會使用repository
        // $post = $this->postRepositoryInterface->get($post->id);

        return $post;
    }

    public function update(Post $post, array $data)
    {
        Gate::authorize('update', $post);

        $this->postRepositoryInterface->update($post, $data);

        if (request()->hasFile('cover')) {
            $post->addMediaFromRequest('cover')
                ->toMediaCollection('cover');
        }

        if (request()->hasFile('images')) {
            $mediaItems = $post->addMultipleMediaFromRequest(['images']);
            foreach ($mediaItems as $fileAdder) {
                $fileAdder->toMediaCollection('images');
            }
        }
    }

    public function delete(Post $post)
    {
        Gate::authorize('delete', $post);

        $this->postRepositoryInterface->delete($post);
    }

    public function deleteImage(Post $post, int $mediaId)
    {
        Gate::authorize('update', $post);

        $this->postRepositoryInterface->deleteImage($post, $mediaId);
    }
}
