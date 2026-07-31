<?php

test('stock transactions page loads successfully', function () {
    $response = $this->get('/stock-transactions');

    $response->assertStatus(200);
    $response->assertSee('Transaksi Mutasi Stok');
    $response->assertSee('Input Barang Masuk');
    $response->assertSee('Input Barang Keluar');
    $response->assertSee('Riwayat Mutasi / Log');
    $response->assertSee('Pencatatan Barang Masuk');
});
