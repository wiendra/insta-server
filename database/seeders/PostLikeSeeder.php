<?php

namespace Database\Seeders;

use App\Repositories\Models\User;
use App\Repositories\Models\Post;
use App\Repositories\Models\PostLike;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostLikeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $posts = Post::where('enable_like', true)->get();
        $users = User::all();

        foreach ($posts as $post) {
            $likeCount = rand(0, 60);
            $likedUsers = $users->random(min($likeCount, $users->count()));

            foreach ($likedUsers as $user) {
                PostLike::firstOrCreate([
                    'user_id' => $user->id,
                    'post_id' => $post->id,
                ]);
            }
        }
    }
}
