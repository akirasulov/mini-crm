<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user = User::factory()->create();
        $user->assignRole('back-office');
        $user->givePermissionTo(['create post', 'update post', 'view post', 'create user', 'update user', 'view user', 'leave commemt', 'grant a role', 'create role and permission']);
        return [
            'user_id' => $user,
            'post_id' => Post::factory(),
            'body' => fake()->realText(150),
        ];
    }
}
