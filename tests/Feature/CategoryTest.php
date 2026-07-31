<?php

test('categories page loads successfully with empty state', function () {
    $response = $this->get('/categories');

    $response->assertStatus(200);
    $response->assertSee('Manajemen Kategori');
    $response->assertSee('Fixoria Sales');
    $response->assertSee('Belum Ada Data Kategori');
    $response->assertSee('Tambah Kategori');
});
