<?php

namespace App\Repositories;

use App\Repositories\Models\PostComment;

class PostCommentRepository
{
    public function get(int $postId)
    {
        return PostComment::with(['user'])->where('post_id', $postId)->get();
    }

    public function store(array $data)
    {
        return PostComment::create($data);
    }
}