<?php

namespace App\Services;

use App\Interfaces\PostRepositoryInterface;
use App\Models\Post;

// * 業務邏輯
// * 調用Repository提供的數據操作
// * 數據轉換
// * 權限檢查
// * 觸發事件
// * 發送通知
// * 外部API呼叫

class PostService
{
    private PostRepositoryInterface $postRepositoryInterface;

    public function __construct(PostRepositoryInterface $postRepositoryInterface)
    {
        $this->postRepositoryInterface = $postRepositoryInterface;
    }

    public function list()
    {
        $data = $this->postRepositoryInterface->list();

        return $data;
    }

    public function create(array $data)
    {
        $post = $this->postRepositoryInterface->store($data);

        if (request()->has('cover')) {
            $post->addMediaFromRequest('cover')->toMediaCollection('cover');
        }

        if (request()->has('images')) {
            $post->addMediaFromRequest('images')->toMediaCollection('images');
        }

        return $post;
    }

    public function get(int $id)
    {
        $post = $this->postRepositoryInterface->get($id);

        return $post;
    }

    public function update(Post $post, array $data)
    {
        $this->postRepositoryInterface->update($post, $data);
    }

    public function delete(Post $post)
    {
        $this->postRepositoryInterface->delete($post);
    }
}
