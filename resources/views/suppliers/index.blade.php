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
            <button class="bg-primary-container text-on-primary px-6 py-2.5 rounded-lg font-label-sm flex items-center gap-2 hover:opacity-90 active:scale-95 transition-all shadow-md" type="button">
                <span class="material-symbols-outlined text-[18px]">add</span>
                Tambah Supplier
            </button>
        </div>

        <!-- Filter Bar Card -->
        <div class="surface-card rounded-xl p-4 flex flex-wrap items-center justify-between gap-4 border border-border/50">
            <div class="flex items-center gap-4 grow max-w-2xl">
                <div class="relative grow">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline">search</span>
                    <input class="w-full pl-10 pr-4 py-2 border border-border rounded-lg text-body-md focus:border-primary-container focus:ring-1 focus:ring-primary-container outline-none" id="supplier-search-input" placeholder="Cari nama supplier atau kontak..." type="text">
                </div>
                <button class="flex items-center gap-2 px-4 py-2 border border-border rounded-lg text-on-surface-variant font-body-md hover:bg-canvas transition-colors" type="button">
                    <span class="material-symbols-outlined text-[20px]">filter_list</span>
                    Filter
                </button>
            </div>
            <div class="flex items-center gap-2 text-on-surface-variant font-body-md text-sm">
                <span>Show</span>
                <select class="border-border rounded-lg py-1 px-3 focus:ring-primary-container focus:border-primary-container outline-none">
                    <option>10</option>
                    <option>25</option>
                    <option>50</option>
                </select>
                <span>Entries</span>
            </div>
        </div>

        <!-- Data Table Card -->
        <div class="surface-card rounded-xl overflow-hidden border border-border/50">
            <table class="w-full text-left border-collapse" id="suppliers-table">
                <thead>
                    <tr class="bg-surface-container-low border-b border-border">
                        <th class="px-6 py-4 w-12">
                            <input class="rounded border-border text-primary-container focus:ring-primary-container" type="checkbox" id="select-all">
                        </th>
                        <th class="px-6 py-4 font-label-sm text-on-surface-variant uppercase tracking-wider text-xs whitespace-nowrap">Nama Supplier</th>
                        <th class="px-6 py-4 font-label-sm text-on-surface-variant uppercase tracking-wider text-xs whitespace-nowrap">Nama Kontak</th>
                        <th class="px-6 py-4 font-label-sm text-on-surface-variant uppercase tracking-wider text-xs whitespace-nowrap">Kategori Produk</th>
                        <th class="px-6 py-4 font-label-sm text-on-surface-variant uppercase tracking-wider text-xs whitespace-nowrap">Telepon / WA</th>
                        <th class="px-6 py-4 font-label-sm text-on-surface-variant uppercase tracking-wider text-xs whitespace-nowrap">Email</th>
                        <th class="px-6 py-4 font-label-sm text-on-surface-variant uppercase tracking-wider text-xs whitespace-nowrap">Status</th>
                        <th class="px-6 py-4 font-label-sm text-on-surface-variant uppercase tracking-wider text-xs text-center whitespace-nowrap">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border">
                    @forelse($suppliers ?? [] as $supplier)
                        <tr class="hover:bg-canvas transition-colors cursor-pointer supplier-row">
                            <td class="px-6 py-4">
                                <input class="rounded border-border text-primary-container focus:ring-primary-container row-checkbox" type="checkbox">
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-lg bg-surface-container-high flex items-center justify-center text-primary">
                                        <span class="material-symbols-outlined">corporate_fare</span>
                                    </div>
                                    <span class="font-body-md text-on-surface font-semibold">{{ $supplier->name }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-body-md text-on-surface-variant">{{ $supplier->contact_name ?? '-' }}</td>
                            <td class="px-6 py-4 text-body-md text-on-surface-variant">{{ $supplier->category ?? '-' }}</td>
                            <td class="px-6 py-4 text-body-md text-on-surface-variant">{{ $supplier->phone ?? '-' }}</td>
                            <td class="px-6 py-4 text-body-md text-on-surface-variant">{{ $supplier->email ?? '-' }}</td>
                            <td class="px-6 py-4">
                                @if($supplier->is_active ?? true)
                                    <span class="px-3 py-1 rounded-full text-[12px] font-semibold bg-green-100 text-green-700">Aktif</span>
                                @else
                                    <span class="px-3 py-1 rounded-full text-[12px] font-semibold bg-gray-100 text-gray-500">Nonaktif</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex justify-center gap-2">
                                    <button class="p-2 hover:bg-surface-container rounded-lg text-primary transition-colors" title="Edit" type="button">
                                        <span class="material-symbols-outlined text-[20px]">edit</span>
                                    </button>
                                    <button class="p-2 hover:bg-error-container rounded-lg text-error transition-colors" title="Hapus" type="button">
                                        <span class="material-symbols-outlined text-[20px]">delete</span>
                                    </button>
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
                                    <button class="bg-primary-container text-on-primary px-4 py-2 rounded-lg text-xs font-semibold flex items-center gap-1.5 transition-all shadow-sm" type="button">
                                        <span class="material-symbols-outlined text-sm">add</span>
                                        Tambah Supplier
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="px-6 py-4 border-t border-border flex justify-between items-center bg-surface">
                <p class="text-body-md text-on-surface-variant text-sm">
                    Menampilkan <span class="font-semibold text-on-surface">{{ isset($suppliers) && method_exists($suppliers, 'firstItem') ? ($suppliers->firstItem() ?? 0) : 0 }} - {{ isset($suppliers) && method_exists($suppliers, 'lastItem') ? ($suppliers->lastItem() ?? 0) : 0 }}</span> dari <span class="font-semibold text-on-surface">{{ isset($suppliers) && method_exists($suppliers, 'total') ? $suppliers->total() : 0 }}</span> entri
                </p>
                <div class="flex items-center gap-1">
                    <button class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-canvas text-on-surface-variant disabled:opacity-40" disabled type="button">
                        <span class="material-symbols-outlined text-[18px]">chevron_left</span>
                    </button>
                    <button class="w-8 h-8 flex items-center justify-center rounded-lg bg-primary-container text-on-primary font-bold text-xs" type="button">1</button>
                    <button class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-canvas text-on-surface-variant disabled:opacity-40" disabled type="button">
                        <span class="material-symbols-outlined text-[18px]">chevron_right</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Summary Cards Footer -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
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
            <div class="surface-card rounded-xl p-6 flex items-center gap-4 border border-border/50">
                <div class="w-12 h-12 rounded-full bg-surface-container-high flex items-center justify-center text-primary">
                    <span class="material-symbols-outlined text-[28px]">category</span>
                </div>
                <div>
                    <p class="text-on-surface-variant font-label-sm text-xs">Kategori Terbanyak</p>
                    <h3 class="text-[20px] font-bold text-on-surface">{{ $topSupplierCategory ?? '-' }}</h3>
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

            // Search filter mock
            const searchInput = document.getElementById('supplier-search-input');
            if (searchInput) {
                searchInput.addEventListener('input', (e) => {
                    const val = e.target.value.toLowerCase();
                    document.querySelectorAll('#suppliers-table tbody tr.supplier-row').forEach(row => {
                        const text = row.innerText.toLowerCase();
                        row.style.display = text.includes(val) ? '' : 'none';
                    });
                });
            }
        });
    </script>
</x-layouts.app>
