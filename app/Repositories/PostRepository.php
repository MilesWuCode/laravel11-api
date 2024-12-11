<?php

namespace App\Repositories;

use App\Interfaces\PostRepositoryInterface;
use App\Models\Post;
use Spatie\QueryBuilder\QueryBuilder;

// * 資料邏輯
// * 負責與數據層（數據庫、ORM）交互
// * 封裝 Eloquent 模型操作
// * 提供基本的 CRUD 方法和複雜的查詢邏輯

class PostRepository implements PostRepositoryInterface
{
    public function __construct()
    {
        //
    }

    public function list()
    {
        $data = QueryBuilder::for(Post::class)
            ->allowedFilters(['title'])
            ->allowedFields(['description', 'published_at'])
            ->allowedIncludes(['user'])
            ->select(['id', 'title', 'created_at', 'updated_at', 'user_id'])
            ->paginate(5);

        return $data;
    }

    public function get($id)
    {
        return Post::findOrFail($id);
    }

    public function store(array $data)
    {
        return Post::create($data);
    }

    public function update(array $data, $id)
    {
        return Post::whereId($id)->update($data);
    }

    public function delete(Post $post)
    {
        // Post::destroy($id);
        $post->delete();
    }
}
