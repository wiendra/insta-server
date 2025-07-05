<?php

namespace Database\Seeders;

use App\Repositories\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FollowerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        foreach ($users as $user) {
            $followCount = rand(1, 5);
            $followedUsers = $users->where('id', '!=', $user->id)
                                  ->random($followCount);

            foreach ($followedUsers as $followedUser) {
                $user->following()->attach($followedUser);
            }
        }
    }
}
