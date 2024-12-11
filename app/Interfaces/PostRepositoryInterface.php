<?php

namespace App\Interfaces;

interface PostRepositoryInterface
{
    public function index();
    public function get($id);
    public function store(array $data);
    public function update(array $data, $id);
    public function delete($id);
}
