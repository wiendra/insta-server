<?php

namespace Database\Seeders;

use App\Repositories\Models\User;
use App\Repositories\Models\Post;
use App\Repositories\Models\PostComment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostCommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $posts = Post::where('enable_comment', true)->get();
        $users = User::all();

        foreach ($posts as $post) {
            $commentCount = rand(0, 10);

            for ($i = 0; $i < $commentCount; $i++) {
                PostComment::create([
                    'user_id' => $users->random()->id,
                    'post_id' => $post->id,
                    'comment' => $this->randomComment(),
                ]);
            }
        }
    }

    private function randomComment()
    {
        $comments = [
            'bagus!',
            'hi',
            'halo',
            'hehehe',
            'wkwkwkk',
            'yuhu',
            'keren',
            'asdfasdf',
            'wwwwww',
            'ehm',
        ];

        return $comments[array_rand($comments)];
    }
}
