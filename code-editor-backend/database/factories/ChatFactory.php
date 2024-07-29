<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Chat>
 */
class ChatFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user1 = User::inRandomOrder()->first();
        $user2 = User::where('id', '!=', $user1->id)->inRandomOrder()->first();

        return [
            'user1' => $user1->id,
            'user2' => $user2->id,
        ];
    }
}
