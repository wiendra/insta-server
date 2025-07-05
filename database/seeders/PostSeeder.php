<?php

namespace Database\Seeders;

use App\Repositories\Models\User;
use App\Repositories\Models\Post;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        foreach ($users as $user) {
            Post::factory()
                ->count(rand(1, 5))
                ->for($user)
                ->create([
                    'enable_comment' => rand(0, 1),
                    'enable_like' => rand(0, 1),
                    'visibility' => rand(0, 2),
                ]);
        }
    }
}
