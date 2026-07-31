<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $furniture = Category::where('name', 'Furniture')->first();
        $global = Supplier::where('name', 'PT. Global Furniture')->first();

        Product::firstOrCreate(
            ['sku' => 'SKU-2024-001'],
            [
                'name' => 'Ergonomic Office Chair',
                'category_id' => $furniture?->id,
                'supplier_id' => $global?->id,
                'purchase_price' => 1250000,
                'selling_price' => 1850000,
                'stock' => 25,
                'min_stock' => 5,
                'unit' => 'Pcs',
                'description' => 'Kursi kantor ergonomis dengan penopang pinggang dan jaring bernapas.',
                'is_active' => true,
            ]
        );
    }
}
