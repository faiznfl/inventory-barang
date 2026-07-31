<?php

test('products page loads successfully with empty state', function () {
    $response = $this->get('/products');

    $response->assertStatus(200);
    $response->assertSee('Data Produk');
    $response->assertSee('Master Produk');
    $response->assertSee('Belum Ada Data Produk');
    $response->assertSee('Tambah Produk Baru');
});
