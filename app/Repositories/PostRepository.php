<?php

namespace App\Repositories;

use App\Repositories\Models\Post;
use App\Repositories\Models\User;

class PostRepository
{
    public function latest(?array $data = [], ?int $perPage = 5)
    {
        return Post::with(
            'user',
            'images'
        )->when(isset($data['authenticated_user_id']), function($q) use ($data) {
            $q->with('likes', fn($q) => $q->where('user_id', $data['authenticated_user_id']));
        })->when(
            isset($data['visibility']), fn($q) => $q->where('visibility', $data['visibility'])
        )->withCount([
            'likes',
            'comments',
        ])->latest()->paginate($perPage);
    }

    public function find(int $id, array $data = [])
    {
        return Post::with('images')->withCount([
            'likes',
            'comments',
        ])->when(isset($data['authenticated_user_id']), function($q) use ($data) {
            $q->with('likes', fn($q) => $q->where('user_id', $data['authenticated_user_id']));
        })->findOrFail($id);
    }

    public function byUser(int $userId, ?int $perPage = 5)
    {
        return Post::with(['user', 'images'])->withCount([
            'likes',
            'comments',
        ])->where('user_id', $userId)->latest()->paginate($perPage);
    }

    public function create(array $data)
    {
        $post = Post::create($data['post']);
        if (isset($data['images']) && count($data['images']) > 0) {
            $post->images()->createMany($data['images']);
        }
        return $post;
    }

    public function delete(int $id)
    {
        $post = Post::findOrFail($id);
        $post->images()->delete();
        $post->likes()->delete();
        $post->comments()->delete();
        $post->delete();

    }
}