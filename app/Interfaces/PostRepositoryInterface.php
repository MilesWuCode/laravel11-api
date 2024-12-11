<?php

namespace App\Interfaces;

use App\Models\Post;

// 接口介面

interface PostRepositoryInterface
{
    public function list();
    public function get($id);
    public function store(array $data): Post;
    public function update(array $data, $id);
    public function delete(Post $post);
}
