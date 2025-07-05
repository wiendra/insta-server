<?php

namespace Database\Factories;

use App\Repositories\Models\User;
use App\Repositories\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Model>
 */
class PostFactory extends Factory
{
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'caption' => $this->faker->sentence(),
            'enable_comment' => true,
            'enable_like' => true,
            'visibility' => rand(0, 2),
        ];
    }
}
