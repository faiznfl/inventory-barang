<?php

test('user management page loads successfully', function () {
    $response = $this->get('/users');

    $response->assertStatus(200);
    $response->assertSee('Manajemen Pengguna');
    $response->assertSee('Daftar Pengguna');
    $response->assertSee('Tambah User Baru');
    $response->assertSee('Tambah Role Baru');
});
