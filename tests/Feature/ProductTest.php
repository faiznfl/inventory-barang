<?php

use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

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
    $response->assertSee('Informasi Dasar');
    $response->assertSee('Foto Produk');
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

test('can store new product with uploaded image', function (): void {
    Storage::fake('public');

    $file = UploadedFile::fake()->image('product.jpg');

    $response = $this->post(route('products.store'), [
        'name' => 'Produk Berfoto',
        'sku' => 'SKU-IMG-001',
        'unit' => 'Pcs',
        'selling_price' => 50000,
        'stock' => 10,
        'image' => $file,
    ]);

    $response->assertRedirect(route('products.index'));

    $product = Product::where('sku', 'SKU-IMG-001')->firstOrFail();
    expect($product->image)->not->toBeNull();

    Storage::disk('public')->assertExists($product->image);
});

test('validation fails when storing product without required fields', function (): void {
    $response = $this->post(route('products.store'), []);

    $response->assertSessionHasErrors(['name', 'sku', 'unit', 'selling_price', 'stock']);
});

test('edit product page loads successfully', function (): void {
    $product = Product::factory()->create();

    $response = $this->get(route('products.edit', $product));

    $response->assertStatus(200);
    $response->assertSee('Edit Produk');
    $response->assertSee($product->name);
});

test('can update existing product in database', function (): void {
    $product = Product::factory()->create([
        'name' => 'Nama Lama',
        'selling_price' => 100000,
    ]);

    $response = $this->put(route('products.update', $product), [
        'name' => 'Nama Baru Dipatenkan',
        'sku' => $product->sku,
        'unit' => $product->unit,
        'selling_price' => 150000,
        'stock' => 20,
    ]);

    $response->assertRedirect(route('products.index'));
    $response->assertSessionHas('success');

    $this->assertDatabaseHas('products', [
        'id' => $product->id,
        'name' => 'Nama Baru Dipatenkan',
        'selling_price' => 150000,
    ]);
});
