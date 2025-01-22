<?php

namespace App\Repositories;

use App\Interfaces\PostRepositoryInterface;
use App\Models\Post;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * 資料邏輯
 *
 * 負責與數據層（數據庫、ORM）交互
 * 封裝 Eloquent 模型操作
 * 提供基本的 CRUD 方法和複雜的查詢邏輯
 */
class PostRepository implements PostRepositoryInterface
{
    public function __construct()
    {
        //
    }

    public function list()
    {
        $data = QueryBuilder::for(Post::class)
            ->allowedFields(['description', 'publicshed_at'])
            ->allowedFilters(['title'])
            ->defaultSort(['-id'])
            ->allowedIncludes(['user'])
            ->paginate(request()->query('pre_page', 15))
            ->appends(request()->query());

        return $data;
    }

    public function get($id)
    {
        return Post::findOrFail($id);
    }

    public function store(array $data): Post
    {
        $post = new Post($data);

        $post->user()->associate(auth()->user())->save();

        return $post;
    }

    public function update(Post $post, array $data)
    {
        $post->update($data);
    }

    public function delete(Post $post)
    {
        // Post::destroy($id);

        $post->delete();
    }

    public function deleteImage(Post $post, int $mediaId)
    {
        $post
            ->getMedia('images')
            ->findOrFail($mediaId)->delete();
    }
}
