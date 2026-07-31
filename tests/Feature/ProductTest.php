<?php

use App\Models\Category;
use App\Models\Supplier;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('products page loads successfully', function (): void {
    $response = $this->get(route('products.index'));

    $response->assertStatus(200);
    $response->assertSee('Data Produk');
});

test('create product page loads successfully', function (): void {
    $response = $this->get(route('products.create'));

    $response->assertStatus(200);
    $response->assertSee('Tambah Produk Baru');
    $response->assertSee('Informasi Produk');
});

test('can store new product in database', function (): void {
    $category = Category::factory()->create(['name' => 'Furniture']);
    $supplier = Supplier::factory()->create(['name' => 'PT. Global Furniture']);

    $response = $this->post(route('products.store'), [
        'name' => 'Meja Kerja Minimalis',
        'sku' => 'SKU-FURN-001',
        'category_id' => $category->id,
        'supplier_id' => $supplier->id,
        'unit' => 'Pcs',
        'purchase_price' => 750000,
        'selling_price' => 1200000,
        'stock' => 15,
        'min_stock' => 3,
        'description' => 'Meja kerja kayu jati solid.',
    ]);

    $response->assertRedirect(route('products.index'));
    $response->assertSessionHas('success');

    $this->assertDatabaseHas('products', [
        'sku' => 'SKU-FURN-001',
        'name' => 'Meja Kerja Minimalis',
        'stock' => 15,
    ]);
});

test('validation fails when storing product without required fields', function (): void {
    $response = $this->post(route('products.store'), []);

    $response->assertSessionHasErrors(['name', 'sku', 'unit', 'selling_price', 'stock']);
});
