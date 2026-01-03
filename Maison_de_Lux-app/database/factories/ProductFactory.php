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
    public function definition()
    {
        return [
            'product_name' => $this->faker->words(3, true),
            'category' => $this->faker->randomElement(['Electronics', 'Clothing', 'Home & Garden', 'Sports', 'Books']),
            'price' => $this->faker->randomFloat(2, 10, 1000),
            'stock_quantity' => $this->faker->numberBetween(1, 100),
            'description' => $this->faker->paragraph(),
            'user_id' => 1, // Assuming admin user with ID 1
            'product_image' => null,
        ];
    }
}
