<?php

use App\Models\Supplier;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('suppliers page loads successfully with empty state', function (): void {
    $response = $this->get(route('suppliers.index'));

    $response->assertStatus(200);
    $response->assertSee('Manajemen Supplier');
    $response->assertSee('Fixoria Sales');
    $response->assertSee('Belum Ada Data Supplier');
    $response->assertSee('Tambah Supplier');
});

test('create supplier page loads successfully', function (): void {
    $response = $this->get(route('suppliers.create'));

    $response->assertStatus(200);
    $response->assertSee('Tambah Supplier Baru');
    $response->assertSee('Nama Supplier');
});

test('can store new supplier in database', function (): void {
    $response = $this->post(route('suppliers.store'), [
        'name' => 'PT Jaya Abadi',
        'contact_name' => 'Budi Santoso',
        'phone' => '08123456789',
        'email' => 'budi@jayaabadi.com',
        'address' => 'Jl. Merdeka No. 45, Jakarta',
        'is_active' => true,
    ]);

    $response->assertRedirect(route('suppliers.index'));
    $response->assertSessionHas('success');

    $this->assertDatabaseHas('suppliers', [
        'name' => 'PT Jaya Abadi',
        'contact_name' => 'Budi Santoso',
        'phone' => '08123456789',
        'email' => 'budi@jayaabadi.com',
        'is_active' => true,
    ]);
});

test('edit supplier page loads successfully', function (): void {
    $supplier = Supplier::factory()->create();

    $response = $this->get(route('suppliers.edit', $supplier));

    $response->assertStatus(200);
    $response->assertSee('Edit Data Supplier');
    $response->assertSee($supplier->name);
});

test('can update existing supplier in database', function (): void {
    $supplier = Supplier::factory()->create(['name' => 'Supplier Lama']);

    $response = $this->put(route('suppliers.update', $supplier), [
        'name' => 'Supplier Baru Update',
        'contact_name' => 'Ahmad PIC',
        'phone' => '08987654321',
        'email' => 'ahmad@supplierbaru.com',
        'address' => 'Jl. Sudirman No. 10',
        'is_active' => false,
    ]);

    $response->assertRedirect(route('suppliers.index'));
    $response->assertSessionHas('success');

    $this->assertDatabaseHas('suppliers', [
        'id' => $supplier->id,
        'name' => 'Supplier Baru Update',
        'contact_name' => 'Ahmad PIC',
        'is_active' => false,
    ]);
});

test('can delete supplier from database', function (): void {
    $supplier = Supplier::factory()->create();

    $response = $this->delete(route('suppliers.destroy', $supplier));

    $response->assertRedirect(route('suppliers.index'));
    $response->assertSessionHas('success');

    $this->assertDatabaseMissing('suppliers', [
        'id' => $supplier->id,
    ]);
});
