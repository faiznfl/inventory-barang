<?php

test('reports page loads successfully with empty state', function () {
    $response = $this->get('/reports');

    $response->assertStatus(200);
    $response->assertSee('Laporan & Ekspor Data');
    $response->assertSee('Ekspor PDF');
    $response->assertSee('CSV / Excel');
    $response->assertSee('Belum Ada Data Laporan');
});
