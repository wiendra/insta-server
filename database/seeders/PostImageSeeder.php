<?php

namespace Database\Seeders;

use App\Repositories\Models\Post;
use App\Repositories\Models\PostImage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $posts = Post::all();

        foreach ($posts as $post) {
            $imageCount = rand(1, 4);

            for ($i = 0; $i < $imageCount; $i++) {
                PostImage::create([
                    'post_id' => $post->id,
                    'image' => \Str::random(10) . '.jpg',
                    'order' => $i + 1,
                ]);
            }
        }
    }
}
