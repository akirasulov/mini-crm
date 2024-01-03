<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user = User::factory()->create();
        $user->assignRole('client');
        $user->givePermissionTo(['create post']);

        $operator = User::factory()->create();
        $operator->assignRole('operator');
        $operator->givePermissionTo(['create post', 'update post', 'view post', 'view user']);
        return [
            'uuid' => fake()->uuid(),
            'user_id' => $user,
            'operator_id' => $operator,
            'title' => str(fake()->sentence)->beforeLast('.')->title(),
            'body' => fake()->realText(100),
            'msisdn' => fake()->phoneNumber(),
            'status' => fake()->numberBetween(1, 2),
            'fullname' => fake()->name(),
        ];
    }
}
