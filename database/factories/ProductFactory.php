<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->text(),
            'image' => fake()->imageUrl(),
            'description' => fake()->realText(2000),
            'price' => fake()->randomFloat(2, 2, 5),
            'created_at' => now(),
            'updated_at' => now(),
            'created_by' => User::factory(),
            'updated_by' => User::factory(),
        ];
    }
}
