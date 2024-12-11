<?php

namespace App\Repositories;

use App\Interfaces\PostRepositoryInterface;
use App\Models\Post;
use Spatie\QueryBuilder\QueryBuilder;

class PostRepository implements PostRepositoryInterface
{
    public function __construct()
    {
        //
    }

    public function index()
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

    public function delete($id)
    {
        Post::destroy($id);
    }
}
