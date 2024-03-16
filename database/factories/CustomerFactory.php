<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user = User::factory();

        return [
            'user_id' => $user,
            'first_name' => fake()->name(),
            'last_name' => fake()->lastName(),
            'phone' => '21995969977',
            'status' => '1',
            'created_by' => $user,
            'updated_by' => $user,
            'created_at' => now(),
        ];
    }
}
