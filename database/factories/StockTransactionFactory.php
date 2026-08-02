<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\StockTransaction;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<StockTransaction>
 */
class StockTransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $type = fake()->randomElement(['in', 'out']);
        $initial = fake()->numberBetween(10, 100);
        $qty = fake()->numberBetween(1, 10);
        $final = $type === 'in' ? $initial + $qty : $initial - $qty;

        return [
            'product_id' => Product::factory(),
            'user_id' => User::factory(),
            'type' => $type,
            'quantity' => $qty,
            'initial_stock' => $initial,
            'final_stock' => $final,
            'reference_no' => 'REF-'.fake()->unique()->numerify('#####'),
            'notes' => fake()->sentence(),
            'transaction_date' => now(),
        ];
    }
}
