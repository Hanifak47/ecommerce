<?php

namespace Database\Factories;

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
        // field slug sudah dihandel oleh model product 
        return [
            //
            'title' => fake()->text(),
            'image' => fake()->imageUrl(),
            'description' => fake()->realText(2090),
            'price' => $this->faker->numberBetween(1, 10000) * 100,
            'created_at' => now(),
            'updated_at' => now(),
            'created_by' => 1,
            'updated_by' => 1,
        ];
    }
}
