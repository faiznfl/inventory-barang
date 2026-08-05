<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Display a listing of users and roles.
     */
    public function index(Request $request): View
    {
        $this->ensureDefaultRolesExist();

        $query = User::with('role')->latest();

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search): void {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('role', 'like', "%{$search}%");
            });
        }

        if ($roleFilter = $request->input('role')) {
            $query->where(function ($q) use ($roleFilter): void {
                $q->where('role', $roleFilter)
                    ->orWhere('role_id', $roleFilter);
            });
        }

        if ($statusFilter = $request->input('status')) {
            if ($statusFilter === 'active') {
                $query->where('is_active', true);
            } elseif ($statusFilter === 'inactive') {
                $query->where('is_active', false);
            }
        }

        $perPage = (int) $request->input('per_page', 10);
        $users = $query->paginate($perPage > 0 ? $perPage : 10)->withQueryString();
        $roles = Role::withCount('users')->get();
        $activeTab = $request->input('tab', 'users');

        return view('users.index', compact('users', 'roles', 'activeTab'));
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(StoreUserRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        if (! empty($validated['role_id'])) {
            $roleModel = Role::find($validated['role_id']);
            if ($roleModel) {
                $validated['role'] = $roleModel->slug;
            }
        }

        $validated['is_active'] = $request->has('is_active') ? $request->boolean('is_active') : ($request->input('status') === 'active' || ! $request->has('status'));

        User::create($validated);

        return redirect()->route('users.index', ['tab' => 'users'])
            ->with('success', 'Pengguna baru berhasil ditambahkan.');
    }

    /**
     * Update the specified user in storage.
     */
    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        $validated = $request->validated();

        if (empty($validated['password'])) {
            unset($validated['password']);
        }

        if (! empty($validated['role_id'])) {
            $roleModel = Role::find($validated['role_id']);
            if ($roleModel) {
                $validated['role'] = $roleModel->slug;
            }
        }

        $validated['is_active'] = $request->has('is_active') ? $request->boolean('is_active') : ($request->input('status') === 'active');

        $user->update($validated);

        return redirect()->route('users.index', ['tab' => 'users'])
            ->with('success', 'Data pengguna berhasil diperbarui.');
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $user): RedirectResponse
    {
        if (auth()->check() && auth()->id() === $user->id) {
            return redirect()->route('users.index', ['tab' => 'users'])
                ->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $user->delete();

        return redirect()->route('users.index', ['tab' => 'users'])
            ->with('success', 'Pengguna berhasil dihapus.');
    }

    /**
     * Reset password for the specified user.
     */
    public function resetPassword(Request $request, User $user): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        $user->update([
            'password' => $request->input('password'),
        ]);

        return redirect()->route('users.index', ['tab' => 'users'])
            ->with('success', "Password pengguna {$user->name} berhasil diperbarui.");
    }

    /**
     * Store a newly created role in storage.
     */
    public function storeRole(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'permissions' => ['nullable', 'array'],
        ]);

        $slug = Str::slug($request->input('name'));

        Role::create([
            'name' => $request->input('name'),
            'slug' => $slug,
            'description' => $request->input('description'),
            'permissions' => $request->input('permissions', []),
        ]);

        return redirect()->route('users.index', ['tab' => 'roles'])
            ->with('success', 'Role baru berhasil ditambahkan.');
    }

    /**
     * Update the specified role in storage.
     */
    public function updateRole(Request $request, Role $role): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'permissions' => ['nullable', 'array'],
        ]);

        $role->update([
            'name' => $request->input('name'),
            'slug' => Str::slug($request->input('name')),
            'description' => $request->input('description'),
            'permissions' => $request->input('permissions', []),
        ]);

        return redirect()->route('users.index', ['tab' => 'roles'])
            ->with('success', 'Data role berhasil diperbarui.');
    }

    /**
     * Remove the specified role from storage.
     */
    public function destroyRole(Role $role): RedirectResponse
    {
        if ($role->users()->count() > 0) {
            return redirect()->route('users.index', ['tab' => 'roles'])
                ->with('error', 'Role tidak dapat dihapus karena masih digunakan oleh pengguna.');
        }

        $role->delete();

        return redirect()->route('users.index', ['tab' => 'roles'])
            ->with('success', 'Role berhasil dihapus.');
    }

    /**
     * Ensure default system roles exist in database.
     */
    private function ensureDefaultRolesExist(): void
    {
        if (Role::count() === 0) {
            Role::create([
                'name' => 'Administrator',
                'slug' => 'admin',
                'description' => 'Akses penuh ke seluruh sistem inventaris, pengaturan pengguna, laporan, dan konfigurasi.',
                'permissions' => ['akses_penuh', 'kelola_pengguna', 'master_produk', 'laporan'],
            ]);

            Role::create([
                'name' => 'Inventory Manager',
                'slug' => 'manager',
                'description' => 'Pengelolaan master produk, kategori, supplier, dan persetujuan mutasi stok.',
                'permissions' => ['master_produk', 'supplier_kategori', 'ekspor_laporan'],
            ]);

            Role::create([
                'name' => 'Staff Gudang',
                'slug' => 'staff',
                'description' => 'Operator lapangan untuk pencatatan barang masuk dan transaksi barang keluar.',
                'permissions' => ['input_barang_masuk', 'input_barang_keluar', 'cek_stok'],
            ]);
        }
    }
}
