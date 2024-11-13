<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name,
            'description' => fake()->paragraph(1),
            'price' => fake()->numberBetween(1,1000),
            'category_id' => Category::inRandomOrder()->first()->id,
           // 'image' => fake()->imageUrl('400','400','products', true),

        ];
    }
}
