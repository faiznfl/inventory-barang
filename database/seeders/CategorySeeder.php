<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Furniture', 'description' => 'Meja, kursi, lemari, dan perabotan kantor/rumah.'],
            ['name' => 'Elektronik', 'description' => 'Perangkat elektronik dan gadget pendukung.'],
            ['name' => 'Alat Kantor', 'description' => 'Peralatan tulis, kertas, dan perlengkapan kantor.'],
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(['name' => $category['name']], $category);
        }
    }
}
