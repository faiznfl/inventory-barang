<?php

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('categories page loads successfully', function (): void {
    $response = $this->get(route('categories.index'));

    $response->assertStatus(200);
    $response->assertSee('Manajemen Kategori');
});

test('create category page loads successfully', function (): void {
    $response = $this->get(route('categories.create'));

    $response->assertStatus(200);
    $response->assertSee('Tambah Kategori Baru');
});

test('can store new category in database', function (): void {
    $response = $this->post(route('categories.store'), [
        'name' => 'Elektronik & Gadget',
        'description' => 'Berbagai peralatan elektronik dan perlengkapan komputer.',
    ]);

    $response->assertRedirect(route('categories.index'));
    $response->assertSessionHas('success');

    $this->assertDatabaseHas('categories', [
        'name' => 'Elektronik & Gadget',
    ]);
});

test('edit category page loads successfully', function (): void {
    $category = Category::factory()->create();

    $response = $this->get(route('categories.edit', $category));

    $response->assertStatus(200);
    $response->assertSee('Edit Kategori');
    $response->assertSee($category->name);
});

test('can update existing category in database', function (): void {
    $category = Category::factory()->create(['name' => 'Nama Kategori Lama']);

    $response = $this->put(route('categories.update', $category), [
        'name' => 'Nama Kategori Baru',
        'description' => 'Deskripsi yang diperbarui.',
    ]);

    $response->assertRedirect(route('categories.index'));
    $response->assertSessionHas('success');

    $this->assertDatabaseHas('categories', [
        'id' => $category->id,
        'name' => 'Nama Kategori Baru',
    ]);
});

test('can delete category from database', function (): void {
    $category = Category::factory()->create();

    $response = $this->delete(route('categories.destroy', $category));

    $response->assertRedirect(route('categories.index'));
    $response->assertSessionHas('success');

    $this->assertDatabaseMissing('categories', [
        'id' => $category->id,
    ]);
});
