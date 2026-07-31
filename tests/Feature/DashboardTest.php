<?php

test('dashboard page loads successfully', function () {
    $response = $this->get('/dashboard');

    $response->assertStatus(200);
    $response->assertSee('Dashboard Overview');
    $response->assertSee('Fixoria Sales');
    $response->assertSee('Total Produk');
    $response->assertSee('Total Nilai Inventaris');
    $response->assertSee('Stok Menipis');
    $response->assertSee('Andi Wijaya');
});
