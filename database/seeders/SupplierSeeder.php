<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $suppliers = [
            [
                'name' => 'PT. Global Furniture',
                'contact_name' => 'Budi Santoso',
                'phone' => '081234567890',
                'email' => 'budi@globalfurniture.co.id',
                'address' => 'Jl. Industri No. 45, Jakarta',
                'is_active' => true,
            ],
            [
                'name' => 'CV. Maju Jaya',
                'contact_name' => 'Siti Rahma',
                'phone' => '082198765432',
                'email' => 'contact@majujaya.com',
                'address' => 'Jl. Raya Surabaya No. 12, Surabaya',
                'is_active' => true,
            ],
        ];

        foreach ($suppliers as $supplier) {
            Supplier::firstOrCreate(['name' => $supplier['name']], $supplier);
        }
    }
}
