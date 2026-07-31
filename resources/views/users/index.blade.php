<x-layouts.app title="Manajemen Pengguna & Role - Fixoria Sales">
    <div class="p-8 space-y-8">
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
            <button class="pb-4 text-sm font-bold border-b-2 border-primary text-primary transition-all focus:outline-none flex items-center gap-2" id="tab-users" onclick="switchUserTab('users')" type="button">
                <span class="material-symbols-outlined text-[18px]">group</span>
                Daftar Pengguna
            </button>
            <button class="pb-4 text-sm font-semibold border-b-2 border-transparent text-on-surface-variant hover:text-on-surface transition-all focus:outline-none flex items-center gap-2" id="tab-roles" onclick="switchUserTab('roles')" type="button">
                <span class="material-symbols-outlined text-[18px]">shield</span>
                Peran & Hak Akses (Roles)
            </button>
        </div>

        <!-- Tab Content 1: Daftar Pengguna -->
        <div class="tab-user-content space-y-6" id="content-users">
            <!-- Filter Bar -->
            <div class="surface-card p-4 flex flex-col md:flex-row gap-4 items-center justify-between border border-border/50">
                <div class="flex flex-wrap items-center gap-4 w-full md:w-auto grow max-w-2xl">
                    <div class="relative grow min-w-[240px]">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline">search</span>
                        <input class="w-full pl-10 pr-4 py-2 bg-white border border-border rounded-lg text-sm focus:ring-2 focus:ring-primary focus:border-primary transition-all outline-none" id="user-search-input" placeholder="Cari nama, email, atau role..." type="text">
                    </div>
                    <div class="min-w-[160px]">
                        <select class="w-full bg-white border border-border rounded-lg py-2 px-3 text-sm focus:ring-primary focus:border-primary outline-none">
                            <option value="">Semua Role</option>
                            <option value="admin">Administrator</option>
                            <option value="manager">Inventory Manager</option>
                            <option value="staff">Staff Gudang</option>
                        </select>
                    </div>
                    <div class="min-w-[140px]">
                        <select class="w-full bg-white border border-border rounded-lg py-2 px-3 text-sm focus:ring-primary focus:border-primary outline-none">
                            <option value="">Semua Status</option>
                            <option value="active">Aktif</option>
                            <option value="inactive">Nonaktif</option>
                        </select>
                    </div>
                </div>
                <div class="flex items-center gap-2 text-sm text-secondary">
                    <span>Show</span>
                    <select class="bg-white border border-border rounded-lg py-1 px-3 text-sm outline-none">
                        <option>10</option>
                        <option>25</option>
                        <option>50</option>
                    </select>
                    <span>Entries</span>
                </div>
            </div>

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
                                            {{ $user->role->name ?? $user->role ?? 'User' }}
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
                                    <td class="px-6 py-4 text-right">
                                        <div class="flex justify-end gap-2">
                                            <button class="p-2 text-secondary hover:text-primary hover:bg-primary/5 rounded-lg transition-all" title="Edit User" type="button">
                                                <span class="material-symbols-outlined text-xl">edit</span>
                                            </button>
                                            <button class="p-2 text-secondary hover:text-amber-600 hover:bg-amber-50 rounded-lg transition-all" title="Reset Password" type="button">
                                                <span class="material-symbols-outlined text-xl">lock_reset</span>
                                            </button>
                                            <button class="p-2 text-secondary hover:text-error-text hover:bg-error-bg rounded-lg transition-all" title="Hapus User" type="button">
                                                <span class="material-symbols-outlined text-xl">delete</span>
                                            </button>
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
                <div class="px-6 py-4 bg-surface border-t border-border flex items-center justify-between">
                    <p class="text-sm text-secondary">
                        Menampilkan <span class="font-semibold text-on-surface">{{ isset($users) && method_exists($users, 'firstItem') ? ($users->firstItem() ?? 0) : 0 }} - {{ isset($users) && method_exists($users, 'lastItem') ? ($users->lastItem() ?? 0) : 0 }}</span> dari <span class="font-semibold text-on-surface">{{ isset($users) && method_exists($users, 'total') ? $users->total() : 0 }}</span> pengguna
                    </p>
                    <div class="flex items-center gap-2">
                        <button class="p-2 border border-border rounded-lg text-secondary hover:bg-canvas disabled:opacity-50 disabled:cursor-not-allowed transition-colors" disabled type="button">
                            <span class="material-symbols-outlined">chevron_left</span>
                        </button>
                        <button class="w-8 h-8 flex items-center justify-center rounded-lg bg-primary-container text-white font-bold text-xs" type="button">1</button>
                        <button class="p-2 border border-border rounded-lg text-secondary hover:bg-canvas disabled:opacity-50 disabled:cursor-not-allowed transition-colors" disabled type="button">
                            <span class="material-symbols-outlined">chevron_right</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tab Content 2: Peran & Hak Akses (Roles) -->
        <div class="tab-user-content hidden space-y-6" id="content-roles">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Role Card 1: Administrator -->
                <div class="surface-card p-6 border-t-4 border-t-primary flex flex-col justify-between space-y-4">
                    <div>
                        <div class="flex justify-between items-start">
                            <div class="w-12 h-12 rounded-xl bg-primary/10 text-primary flex items-center justify-center">
                                <span class="material-symbols-outlined text-2xl">admin_panel_settings</span>
                            </div>
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-primary/10 text-primary uppercase">Super Admin</span>
                        </div>
                        <h3 class="font-bold text-lg text-on-surface mt-4">Administrator</h3>
                        <p class="text-xs text-on-surface-variant mt-1">Akses penuh ke seluruh sistem inventaris, pengaturan pengguna, laporan, dan konfigurasi.</p>
                    </div>
                    <div class="space-y-3 pt-2 border-t border-border">
                        <p class="text-xs font-bold text-on-surface-variant uppercase">Hak Akses Utama:</p>
                        <div class="flex flex-wrap gap-1.5">
                            <span class="px-2 py-0.5 bg-surface-container rounded text-[11px] text-on-surface">Akses Penuh</span>
                            <span class="px-2 py-0.5 bg-surface-container rounded text-[11px] text-on-surface">Kelola Pengguna</span>
                            <span class="px-2 py-0.5 bg-surface-container rounded text-[11px] text-on-surface">Master Produk</span>
                            <span class="px-2 py-0.5 bg-surface-container rounded text-[11px] text-on-surface">Laporan</span>
                        </div>
                    </div>
                    <div class="flex justify-end gap-2 pt-2">
                        <button class="px-3 py-1.5 text-xs font-semibold text-primary hover:bg-primary/10 rounded-lg transition-colors" type="button">Edit Role</button>
                    </div>
                </div>

                <!-- Role Card 2: Inventory Manager -->
                <div class="surface-card p-6 border-t-4 border-t-blue-500 flex flex-col justify-between space-y-4">
                    <div>
                        <div class="flex justify-between items-start">
                            <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                                <span class="material-symbols-outlined text-2xl">inventory</span>
                            </div>
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-blue-50 text-blue-600 uppercase">Manajer</span>
                        </div>
                        <h3 class="font-bold text-lg text-on-surface mt-4">Inventory Manager</h3>
                        <p class="text-xs text-on-surface-variant mt-1">Pengelolaan master produk, kategori, supplier, dan persetujuan mutasi stok.</p>
                    </div>
                    <div class="space-y-3 pt-2 border-t border-border">
                        <p class="text-xs font-bold text-on-surface-variant uppercase">Hak Akses Utama:</p>
                        <div class="flex flex-wrap gap-1.5">
                            <span class="px-2 py-0.5 bg-surface-container rounded text-[11px] text-on-surface">Master Produk</span>
                            <span class="px-2 py-0.5 bg-surface-container rounded text-[11px] text-on-surface">Supplier & Kategori</span>
                            <span class="px-2 py-0.5 bg-surface-container rounded text-[11px] text-on-surface">Ekspor Laporan</span>
                        </div>
                    </div>
                    <div class="flex justify-end gap-2 pt-2">
                        <button class="px-3 py-1.5 text-xs font-semibold text-primary hover:bg-primary/10 rounded-lg transition-colors" type="button">Edit Role</button>
                    </div>
                </div>

                <!-- Role Card 3: Staff Gudang -->
                <div class="surface-card p-6 border-t-4 border-t-emerald-500 flex flex-col justify-between space-y-4">
                    <div>
                        <div class="flex justify-between items-start">
                            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                                <span class="material-symbols-outlined text-2xl">warehouse</span>
                            </div>
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-600 uppercase">Staff</span>
                        </div>
                        <h3 class="font-bold text-lg text-on-surface mt-4">Staff Gudang</h3>
                        <p class="text-xs text-on-surface-variant mt-1">Operator lapangan untuk pencatatan barang masuk dan transaksi barang keluar.</p>
                    </div>
                    <div class="space-y-3 pt-2 border-t border-border">
                        <p class="text-xs font-bold text-on-surface-variant uppercase">Hak Akses Utama:</p>
                        <div class="flex flex-wrap gap-1.5">
                            <span class="px-2 py-0.5 bg-surface-container rounded text-[11px] text-on-surface">Input Barang Masuk</span>
                            <span class="px-2 py-0.5 bg-surface-container rounded text-[11px] text-on-surface">Input Barang Keluar</span>
                            <span class="px-2 py-0.5 bg-surface-container rounded text-[11px] text-on-surface">Cek Stok</span>
                        </div>
                    </div>
                    <div class="flex justify-end gap-2 pt-2">
                        <button class="px-3 py-1.5 text-xs font-semibold text-primary hover:bg-primary/10 rounded-lg transition-colors" type="button">Edit Role</button>
                    </div>
                </div>
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
                <form class="p-6 space-y-4" onsubmit="event.preventDefault(); document.getElementById('modal-add-user').classList.add('hidden');">
                    <div>
                        <label class="block font-label-sm text-label-sm text-on-surface-variant mb-1">Nama Lengkap <span class="text-error">*</span></label>
                        <input class="w-full px-4 py-2 border border-border rounded-lg text-body-md focus:ring-2 focus:ring-primary focus:border-primary transition-all outline-none" placeholder="Masukkan nama lengkap" type="text" required>
                    </div>
                    <div>
                        <label class="block font-label-sm text-label-sm text-on-surface-variant mb-1">Alamat Email <span class="text-error">*</span></label>
                        <input class="w-full px-4 py-2 border border-border rounded-lg text-body-md focus:ring-2 focus:ring-primary focus:border-primary transition-all outline-none" placeholder="user@fixoria.com" type="email" required>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block font-label-sm text-label-sm text-on-surface-variant mb-1">Password <span class="text-error">*</span></label>
                            <input class="w-full px-4 py-2 border border-border rounded-lg text-body-md focus:ring-2 focus:ring-primary focus:border-primary transition-all outline-none" placeholder="••••••••" type="password" required>
                        </div>
                        <div>
                            <label class="block font-label-sm text-label-sm text-on-surface-variant mb-1">Konfirmasi Password</label>
                            <input class="w-full px-4 py-2 border border-border rounded-lg text-body-md focus:ring-2 focus:ring-primary focus:border-primary transition-all outline-none" placeholder="••••••••" type="password" required>
                        </div>
                    </div>
                    <div>
                        <label class="block font-label-sm text-label-sm text-on-surface-variant mb-1">Role / Peran <span class="text-error">*</span></label>
                        <select class="w-full px-4 py-2 border border-border rounded-lg text-body-md focus:ring-2 focus:ring-primary focus:border-primary transition-all outline-none bg-white">
                            <option value="admin">Administrator</option>
                            <option value="manager">Inventory Manager</option>
                            <option value="staff">Staff Gudang</option>
                        </select>
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

    <!-- Modal Overlay 2: Tambah Role Baru -->
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
                <form class="p-6 space-y-4" onsubmit="event.preventDefault(); document.getElementById('modal-add-role').classList.add('hidden');">
                    <div>
                        <label class="block font-label-sm text-label-sm text-on-surface-variant mb-1">Nama Role <span class="text-error">*</span></label>
                        <input class="w-full px-4 py-2 border border-border rounded-lg text-body-md focus:ring-2 focus:ring-primary focus:border-primary transition-all outline-none" placeholder="Contoh: Supervisor Gudang" type="text" required>
                    </div>
                    <div>
                        <label class="block font-label-sm text-label-sm text-on-surface-variant mb-1">Deskripsi Role</label>
                        <textarea class="w-full p-3 border border-border rounded-lg text-body-md focus:ring-2 focus:ring-primary focus:border-primary transition-all outline-none resize-none" placeholder="Jelaskan peran dan tanggung jawab role ini..." rows="3"></textarea>
                    </div>
                    <div>
                        <label class="block font-label-sm text-label-sm text-on-surface-variant mb-2">Hak Akses (Permissions)</label>
                        <div class="space-y-2 max-h-48 overflow-y-auto p-3 border border-border rounded-lg bg-canvas/30">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input class="text-primary rounded border-border focus:ring-primary" type="checkbox" checked>
                                <span class="text-xs font-semibold text-on-surface">Master Produk (Lihat / Edit)</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input class="text-primary rounded border-border focus:ring-primary" type="checkbox" checked>
                                <span class="text-xs font-semibold text-on-surface">Input Transaksi Stok</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input class="text-primary rounded border-border focus:ring-primary" type="checkbox">
                                <span class="text-xs font-semibold text-on-surface">Manajemen Kategori & Supplier</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input class="text-primary rounded border-border focus:ring-primary" type="checkbox">
                                <span class="text-xs font-semibold text-on-surface">Ekspor & Lihat Laporan</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input class="text-primary rounded border-border focus:ring-primary" type="checkbox">
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

    <!-- Script Tab Switching & Modal ESC -->
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

        window.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                const userModal = document.getElementById('modal-add-user');
                const roleModal = document.getElementById('modal-add-role');
                if (userModal) userModal.classList.add('hidden');
                if (roleModal) roleModal.classList.add('hidden');
            }
        });

        // Search Filter Mock
        const userSearch = document.getElementById('user-search-input');
        if (userSearch) {
            userSearch.addEventListener('input', (e) => {
                const val = e.target.value.toLowerCase();
                document.querySelectorAll('#users-table tbody tr.user-row').forEach(row => {
                    const text = row.innerText.toLowerCase();
                    row.style.display = text.includes(val) ? '' : 'none';
                });
            });
        }
    </script>
</x-layouts.app>
