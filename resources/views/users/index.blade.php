<x-layouts.app title="Manajemen Pengguna & Role - Fixoria Sales">
    <div class="p-8 space-y-8">
        <!-- Flash Messages -->
        @if(session('success'))
            <div class="p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl flex items-center gap-3 text-sm font-semibold shadow-sm">
                <span class="material-symbols-outlined text-green-600">check_circle</span>
                <span>{{ session('success') }}</span>
            </div>
        @endif
        @if(session('error'))
            <div class="p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl flex items-center gap-3 text-sm font-semibold shadow-sm">
                <span class="material-symbols-outlined text-red-600">error</span>
                <span>{{ session('error') }}</span>
            </div>
        @endif
        @if($errors->any())
            <div class="p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl text-sm font-semibold shadow-sm space-y-1">
                <div class="flex items-center gap-2 font-bold">
                    <span class="material-symbols-outlined text-red-600">warning</span>
                    <span>Terdapat kesalahan pada masukan data:</span>
                </div>
                <ul class="list-disc pl-8 text-xs font-normal space-y-0.5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Page Header -->
        <header class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="font-display-lg text-display-lg text-on-surface">Manajemen Pengguna & Role</h1>
                <p class="text-on-surface-variant font-body-md text-body-md mt-1">Kelola akun pengguna sistem, peran (role), dan hak akses inventaris.</p>
            </div>
            <div class="flex items-center gap-3">
                <button class="bg-white border border-border text-on-surface hover:bg-surface-container-low px-4 py-2.5 rounded-lg flex items-center gap-2 transition-all font-body-md shadow-sm" onclick="document.getElementById('modal-add-role').classList.remove('hidden')" type="button">
                    <span class="material-symbols-outlined text-[20px]">admin_panel_settings</span>
                    Tambah Role Baru
                </button>
                <button class="bg-primary-container hover:bg-primary text-white px-5 py-2.5 rounded-lg flex items-center gap-2 transition-all font-body-md shadow-sm" onclick="document.getElementById('modal-add-user').classList.remove('hidden')" type="button">
                    <span class="material-symbols-outlined text-[20px]">person_add</span>
                    Tambah User Baru
                </button>
            </div>
        </header>

        <!-- Tab Navigation -->
        <div class="flex border-b border-border gap-8">
            <button class="pb-4 text-sm {{ ($activeTab ?? 'users') === 'users' ? 'font-bold border-b-2 border-primary text-primary' : 'font-semibold border-b-2 border-transparent text-on-surface-variant hover:text-on-surface' }} transition-all focus:outline-none flex items-center gap-2" id="tab-users" onclick="switchUserTab('users')" type="button">
                <span class="material-symbols-outlined text-[18px]">group</span>
                Daftar Pengguna
            </button>
            <button class="pb-4 text-sm {{ ($activeTab ?? '') === 'roles' ? 'font-bold border-b-2 border-primary text-primary' : 'font-semibold border-b-2 border-transparent text-on-surface-variant hover:text-on-surface' }} transition-all focus:outline-none flex items-center gap-2" id="tab-roles" onclick="switchUserTab('roles')" type="button">
                <span class="material-symbols-outlined text-[18px]">shield</span>
                Peran & Hak Akses (Roles)
            </button>
        </div>

        <!-- Tab Content 1: Daftar Pengguna -->
        <div class="tab-user-content {{ ($activeTab ?? 'users') === 'roles' ? 'hidden' : '' }} space-y-6" id="content-users">
            <!-- Filter Bar -->
            <form method="GET" action="{{ route('users.index') }}" id="user-filter-form">
                <input type="hidden" name="tab" value="users">
                <div class="surface-card p-4 flex flex-col md:flex-row gap-4 items-center justify-between border border-border/50">
                    <div class="flex flex-wrap items-center gap-4 w-full md:w-auto grow max-w-2xl">
                        <div class="relative grow min-w-[240px]">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline">search</span>
                            <input class="w-full pl-10 pr-4 py-2 bg-white border border-border rounded-lg text-sm focus:ring-2 focus:ring-primary focus:border-primary transition-all outline-none" id="user-search-input" name="search" value="{{ request('search') }}" placeholder="Cari nama, email, atau role..." type="text">
                        </div>
                        <div class="min-w-[160px]">
                            <select name="role" onchange="this.form.submit()" class="w-full bg-white border border-border rounded-lg py-2 px-3 text-sm focus:ring-primary focus:border-primary outline-none">
                                <option value="">Semua Role</option>
                                @foreach($roles ?? [] as $r)
                                    <option value="{{ $r->slug }}" {{ request('role') == $r->slug ? 'selected' : '' }}>{{ $r->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="min-w-[140px]">
                            <select name="status" onchange="this.form.submit()" class="w-full bg-white border border-border rounded-lg py-2 px-3 text-sm focus:ring-primary focus:border-primary outline-none">
                                <option value="">Semua Status</option>
                                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Aktif</option>
                                <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                            </select>
                        </div>
                        <button type="submit" class="h-9 px-4 bg-primary text-white rounded-lg text-xs font-semibold hover:bg-surface-tint transition-all">Filter</button>
                        @if(request()->hasAny(['search', 'role', 'status', 'per_page']))
                            <a href="{{ route('users.index') }}" class="h-9 px-3 border border-border text-on-surface-variant rounded-lg text-xs font-semibold hover:bg-surface-container-low transition-all flex items-center" title="Reset Filter">
                                <span class="material-symbols-outlined text-[16px]">restart_alt</span>
                            </a>
                        @endif
                    </div>
                    <div class="flex items-center gap-2 text-sm text-secondary">
                        <span>Show</span>
                        <select name="per_page" onchange="this.form.submit()" class="bg-white border border-border rounded-lg py-1 px-3 text-sm outline-none">
                            <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10</option>
                            <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                            <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                        </select>
                        <span>Entries</span>
                    </div>
                </div>
            </form>

            <!-- User Data Table Container -->
            <div class="surface-card overflow-hidden border border-border/50">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse" id="users-table">
                        <thead class="bg-surface-container-low border-b border-border">
                            <tr>
                                <th class="px-6 py-4 font-label-sm text-xs font-semibold text-secondary uppercase tracking-wider">Pengguna</th>
                                <th class="px-6 py-4 font-label-sm text-xs font-semibold text-secondary uppercase tracking-wider">Email</th>
                                <th class="px-6 py-4 font-label-sm text-xs font-semibold text-secondary uppercase tracking-wider">Role / Peran</th>
                                <th class="px-6 py-4 font-label-sm text-xs font-semibold text-secondary uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 font-label-sm text-xs font-semibold text-secondary uppercase tracking-wider">Tanggal Dibuat</th>
                                <th class="px-6 py-4 font-label-sm text-xs font-semibold text-secondary uppercase tracking-wider text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-border">
                            @forelse($users ?? [] as $user)
                                <tr class="hover:bg-canvas transition-colors user-row">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-full bg-primary-container text-white font-bold flex items-center justify-center text-sm shrink-0">
                                                {{ strtoupper(substr($user->name ?? 'U', 0, 2)) }}
                                            </div>
                                            <div>
                                                <p class="font-semibold text-on-surface text-sm">{{ $user->name }}</p>
                                                <p class="text-xs text-secondary">ID: USR-{{ str_pad($user->id ?? 1, 4, '0', STR_PAD_LEFT) }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-on-surface-variant">{{ $user->email }}</td>
                                    <td class="px-6 py-4">
                                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-primary/10 text-primary uppercase">
                                            {{ $user->role->name ?? ucfirst($user->role ?? 'User') }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($user->is_active ?? true)
                                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-green-100 text-green-700 uppercase">Aktif</span>
                                        @else
                                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-gray-100 text-gray-500 uppercase">Nonaktif</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-sm text-secondary">
                                        {{ $user->created_at ? $user->created_at->format('d M Y') : '-' }}
                                    </td>
                                    <td class="px-6 py-4 text-right whitespace-nowrap">
                                        <div class="flex justify-end gap-2">
                                            <button class="p-2 hover:bg-surface-container rounded-lg text-primary transition-colors inline-flex items-center" title="Edit User" onclick="openEditUserModal({{ json_encode([
                                                'id' => $user->id,
                                                'name' => $user->name,
                                                'email' => $user->email,
                                                'role_id' => $user->role_id,
                                                'role' => $user->role,
                                                'is_active' => $user->is_active
                                            ]) }})" type="button">
                                                <span class="material-symbols-outlined text-xl">edit</span>
                                            </button>
                                            <button class="p-2 hover:bg-surface-container rounded-lg text-secondary transition-colors inline-flex items-center" title="Reset Password" onclick="openResetPasswordModal('{{ $user->id }}', '{{ e($user->name) }}')" type="button">
                                                <span class="material-symbols-outlined text-xl">lock_reset</span>
                                            </button>
                                            <form method="POST" action="{{ route('users.destroy', $user->id) }}" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna {{ $user->name }}?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="p-2 hover:bg-error-container rounded-lg text-error transition-colors inline-flex items-center" title="Hapus User" type="submit">
                                                    <span class="material-symbols-outlined text-xl">delete</span>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="px-6 py-16 text-center text-on-surface-variant" colspan="6">
                                        <div class="flex flex-col items-center justify-center max-w-sm mx-auto space-y-3">
                                            <div class="w-16 h-16 rounded-full bg-surface-container-low flex items-center justify-center text-outline">
                                                <span class="material-symbols-outlined text-3xl">manage_accounts</span>
                                            </div>
                                            <div>
                                                <h3 class="font-bold text-on-surface text-base">Belum Ada Data Pengguna</h3>
                                                <p class="text-xs text-on-surface-variant mt-1">Daftar pengguna sistem masih kosong. Klik "Tambah User Baru" untuk membuat akun pengguna.</p>
                                            </div>
                                            <button class="bg-primary-container hover:bg-primary text-white px-4 py-2 rounded-lg text-xs font-semibold flex items-center gap-1.5 transition-all shadow-sm" onclick="document.getElementById('modal-add-user').classList.remove('hidden')" type="button">
                                                <span class="material-symbols-outlined text-sm">person_add</span>
                                                Tambah User Baru
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination Footer -->
                @if(isset($users) && method_exists($users, 'links'))
                    <div class="px-6 py-4 bg-surface border-t border-border flex items-center justify-between">
                        <p class="text-sm text-secondary">
                            Menampilkan <span class="font-semibold text-on-surface">{{ $users->firstItem() ?? 0 }} - {{ $users->lastItem() ?? 0 }}</span> dari <span class="font-semibold text-on-surface">{{ $users->total() }}</span> pengguna
                        </p>
                        <div>
                            {{ $users->links() }}
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Tab Content 2: Peran & Hak Akses (Roles) -->
        <div class="tab-user-content {{ ($activeTab ?? '') === 'roles' ? '' : 'hidden' }} space-y-6" id="content-roles">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @forelse($roles ?? [] as $roleItem)
                    @php
                        $borderColors = ['admin' => 'border-t-primary', 'manager' => 'border-t-blue-500', 'staff' => 'border-t-emerald-500'];
                        $borderColor = $borderColors[$roleItem->slug] ?? 'border-t-primary';
                        $iconNames = ['admin' => 'admin_panel_settings', 'manager' => 'inventory', 'staff' => 'warehouse'];
                        $iconName = $iconNames[$roleItem->slug] ?? 'shield';
                        $badgeTexts = ['admin' => 'Super Admin', 'manager' => 'Manajer', 'staff' => 'Staff'];
                        $badgeText = $badgeTexts[$roleItem->slug] ?? ucfirst($roleItem->slug);
                    @endphp
                    <div class="surface-card p-6 border-t-4 {{ $borderColor }} flex flex-col justify-between space-y-4">
                        <div>
                            <div class="flex justify-between items-start">
                                <div class="w-12 h-12 rounded-xl bg-primary/10 text-primary flex items-center justify-center">
                                    <span class="material-symbols-outlined text-2xl">{{ $iconName }}</span>
                                </div>
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-primary/10 text-primary uppercase">{{ $badgeText }}</span>
                            </div>
                            <h3 class="font-bold text-lg text-on-surface mt-4">{{ $roleItem->name }}</h3>
                            <p class="text-xs text-on-surface-variant mt-1">{{ $roleItem->description ?? 'Tidak ada deskripsi role.' }}</p>
                        </div>
                        <div class="space-y-3 pt-2 border-t border-border">
                            <p class="text-xs font-bold text-on-surface-variant uppercase">Hak Akses Utama:</p>
                            <div class="flex flex-wrap gap-1.5">
                                @forelse($roleItem->permissions ?? [] as $perm)
                                    <span class="px-2 py-0.5 bg-surface-container rounded text-[11px] text-on-surface">{{ ucwords(str_replace('_', ' ', $perm)) }}</span>
                                @empty
                                    <span class="px-2 py-0.5 bg-surface-container rounded text-[11px] text-on-surface-variant">Akses Standar</span>
                                @endforelse
                            </div>
                        </div>
                        <div class="flex justify-between items-center pt-2">
                            <span class="text-xs text-secondary">{{ $roleItem->users_count ?? 0 }} Pengguna</span>
                            <div class="flex gap-2">
                                <button class="px-3 py-1.5 text-xs font-semibold text-primary hover:bg-primary/10 rounded-lg transition-colors" onclick="openEditRoleModal({{ json_encode([
                                    'id' => $roleItem->id,
                                    'name' => $roleItem->name,
                                    'description' => $roleItem->description,
                                    'permissions' => $roleItem->permissions ?? []
                                ]) }})" type="button">Edit Role</button>
                                @if(!in_array($roleItem->slug, ['admin', 'manager', 'staff']))
                                    <form method="POST" action="{{ route('roles.destroy', $roleItem->id) }}" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus role {{ $roleItem->name }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="px-2 py-1.5 text-xs font-semibold text-error hover:bg-error-container rounded-lg transition-colors" type="submit">Hapus</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-3 text-center py-12 text-on-surface-variant">
                        Belum ada data role. Klik "Tambah Role Baru" untuk menambahkan role.
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Modal Overlay 1: Tambah User Baru -->
    <div aria-labelledby="modal-user-title" aria-modal="true" class="hidden fixed inset-0 z-50 overflow-y-auto" id="modal-add-user" role="dialog">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div aria-hidden="true" class="fixed inset-0 transition-opacity bg-on-background/50 backdrop-blur-sm" onclick="document.getElementById('modal-add-user').classList.add('hidden')"></div>
            <span aria-hidden="true" class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>
            <div class="inline-block align-bottom bg-white rounded-xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-border">
                <div class="px-6 py-4 border-b border-border flex items-center justify-between">
                    <h3 class="font-display-lg text-display-lg text-on-surface" id="modal-user-title">Tambah User Baru</h3>
                    <button class="text-outline hover:text-on-surface transition-colors" onclick="document.getElementById('modal-add-user').classList.add('hidden')" type="button">
                        <span class="material-symbols-outlined">close</span>
                    </button>
                </div>
                <form method="POST" action="{{ route('users.store') }}" class="p-6 space-y-4">
                    @csrf
                    <div>
                        <label class="block font-label-sm text-label-sm text-on-surface-variant mb-1">Nama Lengkap <span class="text-error">*</span></label>
                        <input name="name" class="w-full px-4 py-2 border border-border rounded-lg text-body-md focus:ring-2 focus:ring-primary focus:border-primary transition-all outline-none" placeholder="Masukkan nama lengkap" type="text" required>
                    </div>
                    <div>
                        <label class="block font-label-sm text-label-sm text-on-surface-variant mb-1">Alamat Email <span class="text-error">*</span></label>
                        <input name="email" class="w-full px-4 py-2 border border-border rounded-lg text-body-md focus:ring-2 focus:ring-primary focus:border-primary transition-all outline-none" placeholder="user@fixoria.com" type="email" required>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block font-label-sm text-label-sm text-on-surface-variant mb-1">Password <span class="text-error">*</span></label>
                            <input name="password" class="w-full px-4 py-2 border border-border rounded-lg text-body-md focus:ring-2 focus:ring-primary focus:border-primary transition-all outline-none" placeholder="••••••••" type="password" required>
                        </div>
                        <div>
                            <label class="block font-label-sm text-label-sm text-on-surface-variant mb-1">Konfirmasi Password</label>
                            <input name="password_confirmation" class="w-full px-4 py-2 border border-border rounded-lg text-body-md focus:ring-2 focus:ring-primary focus:border-primary transition-all outline-none" placeholder="••••••••" type="password" required>
                        </div>
                    </div>
                    <div>
                        <label class="block font-label-sm text-label-sm text-on-surface-variant mb-1">Role / Peran <span class="text-error">*</span></label>
                        <select name="role_id" class="w-full px-4 py-2 border border-border rounded-lg text-body-md focus:ring-2 focus:ring-primary focus:border-primary transition-all outline-none bg-white">
                            @foreach($roles ?? [] as $roleOpt)
                                <option value="{{ $roleOpt->id }}">{{ $roleOpt->name }}</option>
                            @endforeach
                        </select>
                        <input type="hidden" name="role" value="staff">
                    </div>
                    <div>
                        <label class="block font-label-sm text-label-sm text-on-surface-variant mb-1">Status Akun</label>
                        <div class="flex gap-6 mt-2">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input class="text-primary focus:ring-primary h-4 w-4" name="status" type="radio" value="active" checked>
                                <span class="text-body-md">Aktif</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input class="text-primary focus:ring-primary h-4 w-4" name="status" type="radio" value="inactive">
                                <span class="text-body-md">Nonaktif</span>
                            </label>
                        </div>
                    </div>
                    <div class="mt-6 pt-4 border-t border-border flex justify-end gap-3">
                        <button class="px-5 py-2 border border-border rounded-lg text-on-surface hover:bg-surface-container transition-all font-body-md" onclick="document.getElementById('modal-add-user').classList.add('hidden')" type="button">
                            Batal
                        </button>
                        <button class="px-5 py-2 bg-primary-container hover:bg-primary text-white rounded-lg transition-all font-body-md shadow-sm" type="submit">
                            Simpan User
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Overlay 2: Edit User -->
    <div aria-labelledby="modal-edit-user-title" aria-modal="true" class="hidden fixed inset-0 z-50 overflow-y-auto" id="modal-edit-user" role="dialog">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div aria-hidden="true" class="fixed inset-0 transition-opacity bg-on-background/50 backdrop-blur-sm" onclick="document.getElementById('modal-edit-user').classList.add('hidden')"></div>
            <span aria-hidden="true" class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>
            <div class="inline-block align-bottom bg-white rounded-xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-border">
                <div class="px-6 py-4 border-b border-border flex items-center justify-between">
                    <h3 class="font-display-lg text-display-lg text-on-surface" id="modal-edit-user-title">Edit Data User</h3>
                    <button class="text-outline hover:text-on-surface transition-colors" onclick="document.getElementById('modal-edit-user').classList.add('hidden')" type="button">
                        <span class="material-symbols-outlined">close</span>
                    </button>
                </div>
                <form id="form-edit-user" method="POST" action="" class="p-6 space-y-4">
                    @csrf
                    @method('PUT')
                    <div>
                        <label class="block font-label-sm text-label-sm text-on-surface-variant mb-1">Nama Lengkap <span class="text-error">*</span></label>
                        <input id="edit-user-name" name="name" class="w-full px-4 py-2 border border-border rounded-lg text-body-md focus:ring-2 focus:ring-primary focus:border-primary transition-all outline-none" type="text" required>
                    </div>
                    <div>
                        <label class="block font-label-sm text-label-sm text-on-surface-variant mb-1">Alamat Email <span class="text-error">*</span></label>
                        <input id="edit-user-email" name="email" class="w-full px-4 py-2 border border-border rounded-lg text-body-md focus:ring-2 focus:ring-primary focus:border-primary transition-all outline-none" type="email" required>
                    </div>
                    <div>
                        <label class="block font-label-sm text-label-sm text-on-surface-variant mb-1">Role / Peran <span class="text-error">*</span></label>
                        <select id="edit-user-role-id" name="role_id" class="w-full px-4 py-2 border border-border rounded-lg text-body-md focus:ring-2 focus:ring-primary focus:border-primary transition-all outline-none bg-white">
                            @foreach($roles ?? [] as $roleOpt)
                                <option value="{{ $roleOpt->id }}">{{ $roleOpt->name }}</option>
                            @endforeach
                        </select>
                        <input type="hidden" name="role" id="edit-user-role-slug" value="staff">
                    </div>
                    <div>
                        <label class="block font-label-sm text-label-sm text-on-surface-variant mb-1">Status Akun</label>
                        <div class="flex gap-6 mt-2">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input id="edit-user-status-active" class="text-primary focus:ring-primary h-4 w-4" name="status" type="radio" value="active">
                                <span class="text-body-md">Aktif</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input id="edit-user-status-inactive" class="text-primary focus:ring-primary h-4 w-4" name="status" type="radio" value="inactive">
                                <span class="text-body-md">Nonaktif</span>
                            </label>
                        </div>
                    </div>
                    <div class="mt-6 pt-4 border-t border-border flex justify-end gap-3">
                        <button class="px-5 py-2 border border-border rounded-lg text-on-surface hover:bg-surface-container transition-all font-body-md" onclick="document.getElementById('modal-edit-user').classList.add('hidden')" type="button">
                            Batal
                        </button>
                        <button class="px-5 py-2 bg-primary-container hover:bg-primary text-white rounded-lg transition-all font-body-md shadow-sm" type="submit">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Overlay 3: Reset Password User -->
    <div aria-labelledby="modal-reset-title" aria-modal="true" class="hidden fixed inset-0 z-50 overflow-y-auto" id="modal-reset-password" role="dialog">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div aria-hidden="true" class="fixed inset-0 transition-opacity bg-on-background/50 backdrop-blur-sm" onclick="document.getElementById('modal-reset-password').classList.add('hidden')"></div>
            <span aria-hidden="true" class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>
            <div class="inline-block align-bottom bg-white rounded-xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md sm:w-full border border-border">
                <div class="px-6 py-4 border-b border-border flex items-center justify-between">
                    <h3 class="font-display-lg text-display-lg text-on-surface" id="modal-reset-title">Reset Password</h3>
                    <button class="text-outline hover:text-on-surface transition-colors" onclick="document.getElementById('modal-reset-password').classList.add('hidden')" type="button">
                        <span class="material-symbols-outlined">close</span>
                    </button>
                </div>
                <form id="form-reset-password" method="POST" action="" class="p-6 space-y-4">
                    @csrf
                    <p class="text-sm text-on-surface-variant">Reset password untuk pengguna <strong id="reset-user-name" class="text-on-surface"></strong>:</p>
                    <div>
                        <label class="block font-label-sm text-label-sm text-on-surface-variant mb-1">Password Baru <span class="text-error">*</span></label>
                        <input name="password" class="w-full px-4 py-2 border border-border rounded-lg text-body-md focus:ring-2 focus:ring-primary focus:border-primary transition-all outline-none" placeholder="••••••••" type="password" required>
                    </div>
                    <div>
                        <label class="block font-label-sm text-label-sm text-on-surface-variant mb-1">Konfirmasi Password Baru <span class="text-error">*</span></label>
                        <input name="password_confirmation" class="w-full px-4 py-2 border border-border rounded-lg text-body-md focus:ring-2 focus:ring-primary focus:border-primary transition-all outline-none" placeholder="••••••••" type="password" required>
                    </div>
                    <div class="mt-6 pt-4 border-t border-border flex justify-end gap-3">
                        <button class="px-5 py-2 border border-border rounded-lg text-on-surface hover:bg-surface-container transition-all font-body-md" onclick="document.getElementById('modal-reset-password').classList.add('hidden')" type="button">
                            Batal
                        </button>
                        <button class="px-5 py-2 bg-primary-container hover:bg-primary text-white rounded-lg transition-all font-body-md shadow-sm" type="submit">
                            Simpan Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Overlay 4: Tambah Role Baru -->
    <div aria-labelledby="modal-role-title" aria-modal="true" class="hidden fixed inset-0 z-50 overflow-y-auto" id="modal-add-role" role="dialog">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div aria-hidden="true" class="fixed inset-0 transition-opacity bg-on-background/50 backdrop-blur-sm" onclick="document.getElementById('modal-add-role').classList.add('hidden')"></div>
            <span aria-hidden="true" class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>
            <div class="inline-block align-bottom bg-white rounded-xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md sm:w-full border border-border">
                <div class="px-6 py-4 border-b border-border flex items-center justify-between">
                    <h3 class="font-display-lg text-display-lg text-on-surface" id="modal-role-title">Tambah Role Baru</h3>
                    <button class="text-outline hover:text-on-surface transition-colors" onclick="document.getElementById('modal-add-role').classList.add('hidden')" type="button">
                        <span class="material-symbols-outlined">close</span>
                    </button>
                </div>
                <form method="POST" action="{{ route('roles.store') }}" class="p-6 space-y-4">
                    @csrf
                    <div>
                        <label class="block font-label-sm text-label-sm text-on-surface-variant mb-1">Nama Role <span class="text-error">*</span></label>
                        <input name="name" class="w-full px-4 py-2 border border-border rounded-lg text-body-md focus:ring-2 focus:ring-primary focus:border-primary transition-all outline-none" placeholder="Contoh: Supervisor Gudang" type="text" required>
                    </div>
                    <div>
                        <label class="block font-label-sm text-label-sm text-on-surface-variant mb-1">Deskripsi Role</label>
                        <textarea name="description" class="w-full p-3 border border-border rounded-lg text-body-md focus:ring-2 focus:ring-primary focus:border-primary transition-all outline-none resize-none" placeholder="Jelaskan peran dan tanggung jawab role ini..." rows="3"></textarea>
                    </div>
                    <div>
                        <label class="block font-label-sm text-label-sm text-on-surface-variant mb-2">Hak Akses (Permissions)</label>
                        <div class="space-y-2 max-h-48 overflow-y-auto p-3 border border-border rounded-lg bg-canvas/30">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input name="permissions[]" value="master_produk" class="text-primary rounded border-border focus:ring-primary" type="checkbox" checked>
                                <span class="text-xs font-semibold text-on-surface">Master Produk (Lihat / Edit)</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input name="permissions[]" value="input_transaksi_stok" class="text-primary rounded border-border focus:ring-primary" type="checkbox" checked>
                                <span class="text-xs font-semibold text-on-surface">Input Transaksi Stok</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input name="permissions[]" value="supplier_kategori" class="text-primary rounded border-border focus:ring-primary" type="checkbox">
                                <span class="text-xs font-semibold text-on-surface">Manajemen Kategori & Supplier</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input name="permissions[]" value="ekspor_laporan" class="text-primary rounded border-border focus:ring-primary" type="checkbox">
                                <span class="text-xs font-semibold text-on-surface">Ekspor & Lihat Laporan</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input name="permissions[]" value="kelola_pengguna" class="text-primary rounded border-border focus:ring-primary" type="checkbox">
                                <span class="text-xs font-semibold text-on-surface">Manajemen Pengguna & Role</span>
                            </label>
                        </div>
                    </div>
                    <div class="mt-6 pt-4 border-t border-border flex justify-end gap-3">
                        <button class="px-5 py-2 border border-border rounded-lg text-on-surface hover:bg-surface-container transition-all font-body-md" onclick="document.getElementById('modal-add-role').classList.add('hidden')" type="button">
                            Batal
                        </button>
                        <button class="px-5 py-2 bg-primary-container hover:bg-primary text-white rounded-lg transition-all font-body-md shadow-sm" type="submit">
                            Simpan Role
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Overlay 5: Edit Role -->
    <div aria-labelledby="modal-edit-role-title" aria-modal="true" class="hidden fixed inset-0 z-50 overflow-y-auto" id="modal-edit-role" role="dialog">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div aria-hidden="true" class="fixed inset-0 transition-opacity bg-on-background/50 backdrop-blur-sm" onclick="document.getElementById('modal-edit-role').classList.add('hidden')"></div>
            <span aria-hidden="true" class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>
            <div class="inline-block align-bottom bg-white rounded-xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md sm:w-full border border-border">
                <div class="px-6 py-4 border-b border-border flex items-center justify-between">
                    <h3 class="font-display-lg text-display-lg text-on-surface" id="modal-edit-role-title">Edit Data Role</h3>
                    <button class="text-outline hover:text-on-surface transition-colors" onclick="document.getElementById('modal-edit-role').classList.add('hidden')" type="button">
                        <span class="material-symbols-outlined">close</span>
                    </button>
                </div>
                <form id="form-edit-role" method="POST" action="" class="p-6 space-y-4">
                    @csrf
                    @method('PUT')
                    <div>
                        <label class="block font-label-sm text-label-sm text-on-surface-variant mb-1">Nama Role <span class="text-error">*</span></label>
                        <input id="edit-role-name" name="name" class="w-full px-4 py-2 border border-border rounded-lg text-body-md focus:ring-2 focus:ring-primary focus:border-primary transition-all outline-none" type="text" required>
                    </div>
                    <div>
                        <label class="block font-label-sm text-label-sm text-on-surface-variant mb-1">Deskripsi Role</label>
                        <textarea id="edit-role-description" name="description" class="w-full p-3 border border-border rounded-lg text-body-md focus:ring-2 focus:ring-primary focus:border-primary transition-all outline-none resize-none" rows="3"></textarea>
                    </div>
                    <div>
                        <label class="block font-label-sm text-label-sm text-on-surface-variant mb-2">Hak Akses (Permissions)</label>
                        <div class="space-y-2 max-h-48 overflow-y-auto p-3 border border-border rounded-lg bg-canvas/30" id="edit-role-permissions-container">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input name="permissions[]" value="master_produk" class="edit-perm-check text-primary rounded border-border focus:ring-primary" type="checkbox">
                                <span class="text-xs font-semibold text-on-surface">Master Produk (Lihat / Edit)</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input name="permissions[]" value="input_transaksi_stok" class="edit-perm-check text-primary rounded border-border focus:ring-primary" type="checkbox">
                                <span class="text-xs font-semibold text-on-surface">Input Transaksi Stok</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input name="permissions[]" value="supplier_kategori" class="edit-perm-check text-primary rounded border-border focus:ring-primary" type="checkbox">
                                <span class="text-xs font-semibold text-on-surface">Manajemen Kategori & Supplier</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input name="permissions[]" value="ekspor_laporan" class="edit-perm-check text-primary rounded border-border focus:ring-primary" type="checkbox">
                                <span class="text-xs font-semibold text-on-surface">Ekspor & Lihat Laporan</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input name="permissions[]" value="kelola_pengguna" class="edit-perm-check text-primary rounded border-border focus:ring-primary" type="checkbox">
                                <span class="text-xs font-semibold text-on-surface">Manajemen Pengguna & Role</span>
                            </label>
                        </div>
                    </div>
                    <div class="mt-6 pt-4 border-t border-border flex justify-end gap-3">
                        <button class="px-5 py-2 border border-border rounded-lg text-on-surface hover:bg-surface-container transition-all font-body-md" onclick="document.getElementById('modal-edit-role').classList.add('hidden')" type="button">
                            Batal
                        </button>
                        <button class="px-5 py-2 bg-primary-container hover:bg-primary text-white rounded-lg transition-all font-body-md shadow-sm" type="submit">
                            Simpan Role
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Script Tab Switching & Modals -->
    <script>
        function switchUserTab(tabId) {
            document.querySelectorAll('.tab-user-content').forEach(el => el.classList.add('hidden'));
            document.querySelectorAll('button[id^="tab-"]').forEach(el => {
                el.classList.remove('border-primary', 'text-primary', 'font-bold');
                el.classList.add('border-transparent', 'text-on-surface-variant', 'font-semibold');
            });

            const content = document.getElementById('content-' + tabId);
            const activeTab = document.getElementById('tab-' + tabId);
            if (content) content.classList.remove('hidden');
            if (activeTab) {
                activeTab.classList.add('border-primary', 'text-primary', 'font-bold');
                activeTab.classList.remove('border-transparent', 'text-on-surface-variant', 'font-semibold');
            }
        }

        function openEditUserModal(user) {
            const form = document.getElementById('form-edit-user');
            form.action = '/users/' + user.id;
            document.getElementById('edit-user-name').value = user.name || '';
            document.getElementById('edit-user-email').value = user.email || '';
            if (user.role_id) {
                document.getElementById('edit-user-role-id').value = user.role_id;
            }
            if (user.is_active) {
                document.getElementById('edit-user-status-active').checked = true;
            } else {
                document.getElementById('edit-user-status-inactive').checked = true;
            }
            document.getElementById('modal-edit-user').classList.remove('hidden');
        }

        function openResetPasswordModal(id, name) {
            const form = document.getElementById('form-reset-password');
            form.action = '/users/' + id + '/reset-password';
            document.getElementById('reset-user-name').innerText = name;
            document.getElementById('modal-reset-password').classList.remove('hidden');
        }

        function openEditRoleModal(role) {
            const form = document.getElementById('form-edit-role');
            form.action = '/roles/' + role.id;
            document.getElementById('edit-role-name').value = role.name || '';
            document.getElementById('edit-role-description').value = role.description || '';
            const perms = role.permissions || [];
            document.querySelectorAll('.edit-perm-check').forEach(chk => {
                chk.checked = perms.includes(chk.value);
            });
            document.getElementById('modal-edit-role').classList.remove('hidden');
        }

        window.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                document.querySelectorAll('[id^="modal-"]').forEach(modal => modal.classList.add('hidden'));
            }
        });
    </script>
</x-layouts.app>
