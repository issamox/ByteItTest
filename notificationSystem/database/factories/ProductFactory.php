<?php

namespace Database\Factories;

use App\Models\Category;
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
            'name' => $this->faker->name(),
            'quantity_in_stock' => $this->faker->numberBetween(1, 10),
            'minimum_threshold' => $this->faker->numberBetween(1, 10),
            'category_id' => Category::inRandomOrder()->first()->id,
        ];
    }
}
