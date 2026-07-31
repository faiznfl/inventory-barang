<?php

test('suppliers page loads successfully with empty state', function () {
    $response = $this->get('/suppliers');

    $response->assertStatus(200);
    $response->assertSee('Manajemen Supplier');
    $response->assertSee('Fixoria Sales');
    $response->assertSee('Belum Ada Data Supplier');
    $response->assertSee('Tambah Supplier');
});
