<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
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
            'sku' => 'SKU-'.strtoupper(fake()->bothify('??-###')),
            'name' => fake()->words(3, true),
            'category_id' => Category::factory(),
            'supplier_id' => Supplier::factory(),
            'purchase_price' => fake()->numberBetween(10000, 500000),
            'selling_price' => fake()->numberBetween(60000, 1000000),
            'stock' => fake()->numberBetween(1, 100),
            'min_stock' => 10,
            'unit' => 'Pcs',
            'description' => fake()->sentence(),
            'is_active' => true,
        ];
    }
}
