<?php

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('user management page loads successfully and creates default roles', function () {
    $response = $this->get('/users');

    $response->assertSuccessful();
    $response->assertSee('Manajemen Pengguna & Role');
    $response->assertSee('Daftar Pengguna');
    $response->assertSee('Tambah User Baru');
    $response->assertSee('Tambah Role Baru');
    $response->assertSee('Administrator');
    $response->assertSee('Inventory Manager');
    $response->assertSee('Staff Gudang');

    expect(Role::count())->toBeGreaterThanOrEqual(3);
});

test('can create a new user successfully', function () {
    $role = Role::create([
        'name' => 'Supervisor',
        'slug' => 'supervisor',
    ]);

    $response = $this->post('/users', [
        'name' => 'Doni Pratama',
        'email' => 'doni@fixoria.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
        'role_id' => $role->id,
        'role' => 'supervisor',
        'status' => 'active',
    ]);

    $response->assertRedirect(route('users.index', ['tab' => 'users']));
    $response->assertSessionHas('success', 'Pengguna baru berhasil ditambahkan.');

    $this->assertDatabaseHas('users', [
        'name' => 'Doni Pratama',
        'email' => 'doni@fixoria.com',
        'role_id' => $role->id,
        'is_active' => true,
    ]);
});

test('can filter users list by search query and active status', function () {
    $userActive = User::factory()->create([
        'name' => 'Siti Rahma',
        'email' => 'siti@fixoria.com',
        'is_active' => true,
    ]);

    $userInactive = User::factory()->create([
        'name' => 'Bambang Tri',
        'email' => 'bambang@fixoria.com',
        'is_active' => false,
    ]);

    $responseSearch = $this->get('/users?search=Siti');
    $responseSearch->assertSuccessful();
    $responseSearch->assertSee('Siti Rahma');
    $responseSearch->assertDontSee('Bambang Tri');

    $responseStatus = $this->get('/users?status=inactive');
    $responseStatus->assertSuccessful();
    $responseStatus->assertSee('Bambang Tri');
    $responseStatus->assertDontSee('Siti Rahma');
});

test('can update an existing user', function () {
    $user = User::factory()->create(['name' => 'Old Name', 'email' => 'old@fixoria.com']);
    $role = Role::create(['name' => 'Manager Custom', 'slug' => 'manager-custom']);

    $response = $this->put("/users/{$user->id}", [
        'name' => 'New Name Updated',
        'email' => 'new@fixoria.com',
        'role_id' => $role->id,
        'role' => 'manager-custom',
        'status' => 'active',
    ]);

    $response->assertRedirect(route('users.index', ['tab' => 'users']));
    $response->assertSessionHas('success', 'Data pengguna berhasil diperbarui.');

    $this->assertDatabaseHas('users', [
        'id' => $user->id,
        'name' => 'New Name Updated',
        'email' => 'new@fixoria.com',
        'role_id' => $role->id,
    ]);
});

test('can reset user password', function () {
    $user = User::factory()->create();

    $response = $this->post("/users/{$user->id}/reset-password", [
        'password' => 'newsecretpass',
        'password_confirmation' => 'newsecretpass',
    ]);

    $response->assertRedirect(route('users.index', ['tab' => 'users']));
    $response->assertSessionHas('success');
});

test('can delete a user', function () {
    $user = User::factory()->create();

    $response = $this->delete("/users/{$user->id}");

    $response->assertRedirect(route('users.index', ['tab' => 'users']));
    $response->assertSessionHas('success', 'Pengguna berhasil dihapus.');

    $this->assertDatabaseMissing('users', [
        'id' => $user->id,
    ]);
});

test('can create a new role and edit it', function () {
    $responseCreate = $this->post('/roles', [
        'name' => 'Auditor Internal',
        'description' => 'Role untuk pemeriksa persediaan',
        'permissions' => ['ekspor_laporan', 'cek_stok'],
    ]);

    $responseCreate->assertRedirect(route('users.index', ['tab' => 'roles']));
    $responseCreate->assertSessionHas('success', 'Role baru berhasil ditambahkan.');

    $role = Role::where('slug', 'auditor-internal')->firstOrFail();
    expect($role->name)->toBe('Auditor Internal');
    expect($role->permissions)->toContain('ekspor_laporan');

    $responseUpdate = $this->put("/roles/{$role->id}", [
        'name' => 'Auditor Senior',
        'description' => 'Role updated',
        'permissions' => ['ekspor_laporan'],
    ]);

    $responseUpdate->assertRedirect(route('users.index', ['tab' => 'roles']));
    $responseUpdate->assertSessionHas('success', 'Data role berhasil diperbarui.');

    $role->refresh();
    expect($role->name)->toBe('Auditor Senior');
});
