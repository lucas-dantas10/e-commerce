<?php

namespace Database\Factories;

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
        return [
            'user_id' => 1,
            'first_name' => fake()->name(),
            'last_name' => fake()->lastName(),
            'phone' => '21995969977',
            'status' => '1',
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => now()
        ];
    }
}
