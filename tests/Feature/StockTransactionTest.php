<?php

use App\Models\Product;
use App\Models\StockTransaction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('stock transactions page loads successfully and displays products list', function () {
    $product = Product::factory()->create(['name' => 'Kopi Robusta', 'stock' => 50]);

    $response = $this->get('/stock-transactions');

    $response->assertStatus(200);
    $response->assertSee('Transaksi Mutasi Stok');
    $response->assertSee('Input Barang Masuk');
    $response->assertSee('Input Barang Keluar');
    $response->assertSee('Riwayat Mutasi / Log');
    $response->assertSee('Kopi Robusta');
});

test('can process stock in transaction successfully and redirects to riwayat tab', function () {
    $product = Product::factory()->create(['stock' => 20]);
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post('/stock-transactions', [
        'type' => 'in',
        'product_id' => $product->id,
        'quantity' => 15,
        'reference_no' => 'PO-2026-001',
        'notes' => 'Penerimaan stok baru dari supplier',
        'transaction_date' => '2026-08-02',
    ]);

    $response->assertRedirect(route('stock-transactions.index', ['tab' => 'riwayat']));
    $response->assertSessionHas('success', 'Transaksi barang masuk berhasil diproses.');

    $product->refresh();
    expect($product->stock)->toBe(35);

    $this->assertDatabaseHas('stock_transactions', [
        'product_id' => $product->id,
        'user_id' => $user->id,
        'type' => 'in',
        'quantity' => 15,
        'initial_stock' => 20,
        'final_stock' => 35,
        'reference_no' => 'PO-2026-001',
    ]);
});

test('can process stock out transaction successfully and redirects to riwayat tab', function () {
    $product = Product::factory()->create(['stock' => 50]);
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post('/stock-transactions', [
        'type' => 'out',
        'product_id' => $product->id,
        'quantity' => 10,
        'reference_no' => 'DO-2026-089',
        'notes' => 'Penjualan retail',
        'transaction_date' => '2026-08-02',
    ]);

    $response->assertRedirect(route('stock-transactions.index', ['tab' => 'riwayat']));
    $response->assertSessionHas('success', 'Transaksi barang keluar berhasil diproses.');

    $product->refresh();
    expect($product->stock)->toBe(40);

    $this->assertDatabaseHas('stock_transactions', [
        'product_id' => $product->id,
        'user_id' => $user->id,
        'type' => 'out',
        'quantity' => 10,
        'initial_stock' => 50,
        'final_stock' => 40,
        'reference_no' => 'DO-2026-089',
    ]);
});

test('prevents stock out transaction when stock is insufficient', function () {
    $product = Product::factory()->create(['stock' => 5]);

    $response = $this->post('/stock-transactions', [
        'type' => 'out',
        'product_id' => $product->id,
        'quantity' => 10,
        'reference_no' => 'DO-2026-090',
    ]);

    $response->assertRedirect();
    $response->assertSessionHas('error');

    $product->refresh();
    expect($product->stock)->toBe(5);

    $this->assertDatabaseMissing('stock_transactions', [
        'reference_no' => 'DO-2026-090',
    ]);
});

test('validates required fields for stock transaction', function () {
    $response = $this->post('/stock-transactions', []);

    $response->assertSessionHasErrors(['product_id', 'type', 'quantity', 'reference_no']);
});

test('can filter stock transactions history by type and retain riwayat tab', function () {
    $product = Product::factory()->create();
    StockTransaction::factory()->create(['product_id' => $product->id, 'type' => 'in', 'reference_no' => 'REF-IN-111']);
    StockTransaction::factory()->create(['product_id' => $product->id, 'type' => 'out', 'reference_no' => 'REF-OUT-222']);

    $responseAll = $this->get('/stock-transactions?tab=riwayat');
    $responseAll->assertStatus(200);
    $responseAll->assertSee("switchTab('riwayat')", false);
    $responseAll->assertSee('REF-IN-111');
    $responseAll->assertSee('REF-OUT-222');

    $responseIn = $this->get('/stock-transactions?tab=riwayat&type=in');
    $responseIn->assertSee('REF-IN-111');
    $responseIn->assertDontSee('REF-OUT-222');

    $responseOut = $this->get('/stock-transactions?tab=riwayat&type=out');
    $responseOut->assertSee('REF-OUT-222');
    $responseOut->assertDontSee('REF-IN-111');
});
