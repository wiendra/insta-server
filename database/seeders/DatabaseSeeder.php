<?php

namespace Database\Seeders;

use App\Repositories\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            PostSeeder::class,
            PostImageSeeder::class,
            PostCommentSeeder::class,
            PostLikeSeeder::class,
            FollowerSeeder::class,
        ]);
    }
}
