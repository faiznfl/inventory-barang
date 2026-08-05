<?php

use App\Models\Category;
use App\Models\Product;
use App\Models\StockTransaction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('reports page loads successfully with empty state', function () {
    $response = $this->get('/reports');

    $response->assertSuccessful();
    $response->assertSee('Laporan & Ekspor Data');
    $response->assertSee('Ekspor PDF');
    $response->assertSee('CSV / Excel');
    $response->assertSee('Belum Ada Data Laporan');
});

test('reports page displays transactions and total summary correctly', function () {
    $category = Category::factory()->create(['name' => 'Elektronik']);
    $product = Product::factory()->create(['category_id' => $category->id, 'name' => 'Laptop Gaming', 'sku' => 'SKU-LAP-01']);
    $user = User::factory()->create(['name' => 'Budi Operator']);

    StockTransaction::factory()->create([
        'product_id' => $product->id,
        'user_id' => $user->id,
        'type' => 'in',
        'quantity' => 25,
        'notes' => 'Restok laptop',
        'transaction_date' => '2026-08-01 10:00:00',
    ]);

    StockTransaction::factory()->create([
        'product_id' => $product->id,
        'user_id' => $user->id,
        'type' => 'out',
        'quantity' => 10,
        'notes' => 'Penjualan laptop',
        'transaction_date' => '2026-08-02 14:00:00',
    ]);

    $response = $this->get('/reports');

    $response->assertSuccessful();
    $response->assertSee('Laptop Gaming');
    $response->assertSee('SKU-LAP-01');
    $response->assertSee('Elektronik');
    $response->assertSee('Budi Operator');
    $response->assertSee('Restok laptop');
    $response->assertSee('Penjualan laptop');
    $response->assertSee('25');
    $response->assertSee('10');
});

test('reports page filters by transaction type and category', function () {
    $cat1 = Category::factory()->create(['name' => 'Makanan']);
    $cat2 = Category::factory()->create(['name' => 'Pakaian']);

    $prod1 = Product::factory()->create(['category_id' => $cat1->id, 'name' => 'Roti Tawar']);
    $prod2 = Product::factory()->create(['category_id' => $cat2->id, 'name' => 'Kemeja Polos']);

    StockTransaction::factory()->create(['product_id' => $prod1->id, 'type' => 'in', 'quantity' => 50]);
    StockTransaction::factory()->create(['product_id' => $prod2->id, 'type' => 'out', 'quantity' => 15]);

    $responseTypeIn = $this->get('/reports?type=in');
    $responseTypeIn->assertSuccessful();
    $responseTypeIn->assertSee('Roti Tawar');
    $responseTypeIn->assertDontSee('Kemeja Polos');

    $responseCat2 = $this->get('/reports?category_id='.$cat2->id);
    $responseCat2->assertSuccessful();
    $responseCat2->assertSee('Kemeja Polos');
    $responseCat2->assertDontSee('Roti Tawar');
});

test('reports page filters by date range', function () {
    $product = Product::factory()->create(['name' => 'Barang Tanggal']);

    StockTransaction::factory()->create([
        'product_id' => $product->id,
        'type' => 'in',
        'quantity' => 5,
        'notes' => 'Mutasi Lama',
        'transaction_date' => '2026-01-10',
    ]);

    StockTransaction::factory()->create([
        'product_id' => $product->id,
        'type' => 'in',
        'quantity' => 8,
        'notes' => 'Mutasi Baru',
        'transaction_date' => '2026-08-05',
    ]);

    $responseDate = $this->get('/reports?start_date=2026-08-01&end_date=2026-08-10');
    $responseDate->assertSuccessful();
    $responseDate->assertSee('Mutasi Baru');
    $responseDate->assertDontSee('Mutasi Lama');
});

test('can download csv report', function () {
    $product = Product::factory()->create(['name' => 'Produk CSV', 'sku' => 'SKU-CSV-123']);
    StockTransaction::factory()->create(['product_id' => $product->id, 'type' => 'in', 'quantity' => 30, 'notes' => 'Ekspor CSV Test']);

    $response = $this->get('/reports/export/csv');

    $response->assertSuccessful();
    $response->assertHeader('content-type', 'text/csv; charset=UTF-8');
    expect($response->headers->get('content-disposition'))->toContain('laporan_mutasi_stok_');
});

test('can view printable pdf report layout', function () {
    $product = Product::factory()->create(['name' => 'Produk PDF']);
    StockTransaction::factory()->create(['product_id' => $product->id, 'type' => 'out', 'quantity' => 12]);

    $response = $this->get('/reports/export/pdf');

    $response->assertSuccessful();
    $response->assertSee('Laporan Rekapitulasi Mutasi Stok');
    $response->assertSee('Produk PDF');
    $response->assertSee('Cetak / Simpan PDF');
});
