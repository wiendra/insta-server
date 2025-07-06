<?php

namespace App\Repositories;

use App\Repositories\Models\PostLike;

class PostLikeRepository
{
    public function store(array $data)
    {
        return PostLike::create([
            'user_id' => $data['user_id'],
            'post_id' => $data['post_id'],
        ]);
    }

    public function delete(int $postId, int $userId)
    {
        return PostLike::where('post_id', $postId)
            ->where('user_id', $userId)
            ->delete();
    }
}