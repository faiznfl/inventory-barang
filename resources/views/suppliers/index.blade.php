<x-layouts.app title="Manajemen Supplier - Fixoria Sales">
    <div class="p-8 space-y-6">
        <!-- Header & Title Area -->
        <div class="flex justify-between items-end">
            <div>
                <nav class="flex text-secondary font-label-sm mb-1 items-center gap-2 text-xs">
                    <a class="hover:text-primary transition-colors" href="{{ route('dashboard') }}">Dashboard</a>
                    <span class="material-symbols-outlined text-[14px]">chevron_right</span>
                    <span class="text-on-surface font-semibold">Supplier</span>
                </nav>
                <h2 class="font-display-lg text-display-lg text-on-surface">Manajemen Supplier</h2>
            </div>
            <a href="{{ route('suppliers.create') }}" class="bg-primary-container text-on-primary px-6 py-2.5 rounded-lg font-label-sm flex items-center gap-2 hover:opacity-90 active:scale-95 transition-all shadow-md">
                <span class="material-symbols-outlined text-[18px]">add</span>
                Tambah Supplier
            </a>
        </div>

        @if (session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 p-4 rounded-xl text-sm flex items-center justify-between shadow-xs">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-green-600">check_circle</span>
                    <span>{{ session('success') }}</span>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="text-green-600 hover:text-green-800">
                    <span class="material-symbols-outlined text-sm">close</span>
                </button>
            </div>
        @endif

        <!-- Filter Bar Card -->
        <div class="surface-card rounded-xl p-4 flex flex-wrap items-center justify-between gap-4 border border-border/50">
            <form method="GET" action="{{ route('suppliers.index') }}" class="flex items-center gap-4 grow max-w-2xl">
                <div class="relative grow">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline">search</span>
                    <input class="w-full pl-10 pr-4 py-2 border border-border rounded-lg text-body-md focus:border-primary-container focus:ring-1 focus:ring-primary-container outline-none" name="search" value="{{ request('search') }}" placeholder="Cari nama supplier, kontak, email, atau telepon..." type="text">
                </div>
                <button type="submit" class="flex items-center gap-2 px-4 py-2 border border-border rounded-lg text-on-surface-variant font-body-md hover:bg-canvas transition-colors">
                    <span class="material-symbols-outlined text-[20px]">filter_list</span>
                    Cari
                </button>
                @if(request('search'))
                    <a href="{{ route('suppliers.index') }}" class="px-3 py-2 text-xs text-secondary hover:text-primary transition-colors">Reset</a>
                @endif
            </form>
        </div>

        <!-- Data Table Card -->
        <div class="surface-card rounded-xl overflow-hidden border border-border/50">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse min-w-[900px]" id="suppliers-table">
                    <thead>
                        <tr class="bg-surface-container-low border-b border-border">
                            <th class="px-6 py-4 w-12 text-center">
                                <input class="rounded border-border text-primary-container focus:ring-primary-container" type="checkbox" id="select-all">
                            </th>
                            <th class="px-6 py-4 font-label-sm text-on-surface-variant uppercase tracking-wider text-xs whitespace-nowrap">Nama Supplier</th>
                            <th class="px-6 py-4 font-label-sm text-on-surface-variant uppercase tracking-wider text-xs whitespace-nowrap">Nama Kontak</th>
                            <th class="px-6 py-4 font-label-sm text-on-surface-variant uppercase tracking-wider text-xs whitespace-nowrap">Telepon / WA</th>
                            <th class="px-6 py-4 font-label-sm text-on-surface-variant uppercase tracking-wider text-xs whitespace-nowrap">Email</th>
                            <th class="px-6 py-4 font-label-sm text-on-surface-variant uppercase tracking-wider text-xs whitespace-nowrap">Alamat</th>
                            <th class="px-6 py-4 font-label-sm text-on-surface-variant uppercase tracking-wider text-xs whitespace-nowrap">Status</th>
                            <th class="px-6 py-4 font-label-sm text-on-surface-variant uppercase tracking-wider text-xs text-center whitespace-nowrap w-28">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border">
                        @forelse($suppliers ?? [] as $supplier)
                            <tr class="hover:bg-canvas transition-colors supplier-row">
                                <td class="px-6 py-4 text-center">
                                    <input class="rounded border-border text-primary-container focus:ring-primary-container row-checkbox" type="checkbox">
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-lg bg-surface-container-high flex items-center justify-center text-primary">
                                            <span class="material-symbols-outlined">corporate_fare</span>
                                        </div>
                                        <span class="font-body-md text-on-surface font-semibold">{{ $supplier->name }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-body-md text-on-surface-variant whitespace-nowrap">{{ $supplier->contact_name ?? '-' }}</td>
                                <td class="px-6 py-4 text-body-md text-on-surface-variant whitespace-nowrap">{{ $supplier->phone ?? '-' }}</td>
                                <td class="px-6 py-4 text-body-md text-on-surface-variant whitespace-nowrap">{{ $supplier->email ?? '-' }}</td>
                                <td class="px-6 py-4 text-body-md text-on-surface-variant max-w-xs truncate" title="{{ $supplier->address }}">{{ $supplier->address ?? '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($supplier->is_active ?? true)
                                        <span class="px-3 py-1 rounded-full text-[12px] font-semibold bg-green-100 text-green-700">Aktif</span>
                                    @else
                                        <span class="px-3 py-1 rounded-full text-[12px] font-semibold bg-gray-100 text-gray-500">Nonaktif</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center whitespace-nowrap">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('suppliers.edit', $supplier) }}" class="p-2 hover:bg-surface-container rounded-lg text-primary transition-colors inline-flex items-center" title="Edit Supplier">
                                            <span class="material-symbols-outlined text-xl">edit</span>
                                        </a>
                                        <form action="{{ route('suppliers.destroy', $supplier) }}" method="POST" class="inline-flex" onsubmit="return confirm('Apakah Anda yakin ingin menghapus supplier ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 hover:bg-error-container rounded-lg text-error transition-colors inline-flex items-center" title="Hapus Supplier">
                                                <span class="material-symbols-outlined text-xl">delete</span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="px-6 py-16 text-center text-on-surface-variant" colspan="8">
                                    <div class="flex flex-col items-center justify-center max-w-sm mx-auto space-y-3">
                                        <div class="w-16 h-16 rounded-full bg-surface-container-low flex items-center justify-center text-outline">
                                            <span class="material-symbols-outlined text-3xl">local_shipping</span>
                                        </div>
                                        <div>
                                            <h3 class="font-bold text-on-surface text-base">Belum Ada Data Supplier</h3>
                                            <p class="text-xs text-on-surface-variant mt-1">Daftar mitra supplier masih kosong. Klik tombol "Tambah Supplier" untuk menambahkan data mitra baru.</p>
                                        </div>
                                        <a href="{{ route('suppliers.create') }}" class="bg-primary-container text-on-primary px-4 py-2 rounded-lg text-xs font-semibold flex items-center gap-1.5 transition-all shadow-sm">
                                            <span class="material-symbols-outlined text-sm">add</span>
                                            Tambah Supplier
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if(isset($suppliers) && method_exists($suppliers, 'links'))
                <div class="px-6 py-4 border-t border-border bg-surface">
                    {{ $suppliers->links() }}
                </div>
            @endif
        </div>

        <!-- Summary Cards Footer -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="surface-card rounded-xl p-6 flex items-center gap-4 border border-border/50">
                <div class="w-12 h-12 rounded-full bg-surface-container-high flex items-center justify-center text-primary">
                    <span class="material-symbols-outlined text-[28px]">groups</span>
                </div>
                <div>
                    <p class="text-on-surface-variant font-label-sm text-xs">Total Supplier</p>
                    <h3 class="text-[24px] font-bold text-on-surface">{{ number_format($totalSuppliersCount ?? 0) }}</h3>
                </div>
            </div>
            <div class="surface-card rounded-xl p-6 flex items-center gap-4 border border-border/50">
                <div class="w-12 h-12 rounded-full bg-green-50 flex items-center justify-center text-green-600">
                    <span class="material-symbols-outlined text-[28px]">check_circle</span>
                </div>
                <div>
                    <p class="text-on-surface-variant font-label-sm text-xs">Supplier Aktif</p>
                    <h3 class="text-[24px] font-bold text-on-surface">{{ number_format($activeSuppliersCount ?? 0) }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Micro-interactions Script -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const selectAllHeader = document.getElementById('select-all');
            const rowCheckboxes = document.querySelectorAll('.row-checkbox');

            if (selectAllHeader) {
                selectAllHeader.addEventListener('change', (e) => {
                    rowCheckboxes.forEach(cb => {
                        cb.checked = e.target.checked;
                    });
                });
            }
        });
    </script>
</x-layouts.app>
