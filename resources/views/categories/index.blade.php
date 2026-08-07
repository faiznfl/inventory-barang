<x-layouts.app title="Manajemen Kategori - Fixoria Sales">
    <div class="p-4 sm:p-6 lg:p-8 space-y-6">
        <!-- Page Header -->
        <header class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h2 class="font-display-lg text-xl sm:text-display-lg text-on-surface">Manajemen Kategori</h2>
                <nav class="flex text-xs text-secondary items-center gap-2 mt-1">
                    <a class="hover:text-primary transition-colors" href="{{ route('dashboard') }}">Dashboard</a>
                    <span class="material-symbols-outlined text-[14px]">chevron_right</span>
                    <span class="text-on-surface font-semibold">Kategori</span>
                </nav>
            </div>
            <a href="{{ route('categories.create') }}" class="bg-primary-container hover:bg-primary text-white px-4 sm:px-5 py-2.5 rounded-lg flex items-center justify-center gap-2 transition-all font-body-md text-xs sm:text-sm shadow-sm active:scale-95 shrink-0">
                <span class="material-symbols-outlined text-[18px] sm:text-[20px]">add</span>
                <span>Tambah Kategori</span>
            </a>
        </header>

        <!-- Filter & Search Section -->
        <div class="surface-card rounded-xl p-4 border border-border/50">
            <form method="GET" action="{{ route('categories.index') }}" class="flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="flex flex-col sm:flex-row items-center gap-3 w-full grow max-w-2xl">
                    <div class="relative w-full sm:grow sm:min-w-[240px] flex items-center">
                        <span class="material-symbols-outlined absolute left-3 text-outline text-[20px] pointer-events-none">search</span>
                        <input class="w-full h-10 pl-10 pr-4 bg-white border border-border rounded-lg text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all outline-none" name="search" value="{{ request('search') }}" placeholder="Cari nama kategori..." type="text">
                    </div>
                    <div class="flex items-center gap-2 w-full sm:w-auto">
                        <button type="submit" class="h-10 flex-1 sm:flex-none flex items-center justify-center gap-2 px-4 border border-border rounded-lg text-sm font-medium text-on-surface-variant hover:bg-canvas transition-colors shrink-0">
                            <span class="material-symbols-outlined text-[18px]">filter_list</span>
                            <span>Cari</span>
                        </button>
                        @if(request('search'))
                            <a href="{{ route('categories.index') }}" class="h-10 flex items-center justify-center px-3 text-xs text-secondary hover:text-primary transition-colors shrink-0">Reset</a>
                        @endif
                    </div>
                </div>
            </form>
        </div>

        <!-- Data Table Container -->
        <div class="surface-card overflow-hidden border border-border/50 rounded-xl">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse min-w-[700px]">
                    <thead class="bg-surface-container-low border-b border-border">
                        <tr>
                            <th class="px-6 py-4 w-12">
                                <input class="rounded border-border text-primary focus:ring-primary" type="checkbox" id="select-all">
                            </th>
                            <th class="px-6 py-4 text-xs font-semibold text-secondary uppercase tracking-wider whitespace-nowrap">Nama Kategori</th>
                            <th class="px-6 py-4 text-xs font-semibold text-secondary uppercase tracking-wider whitespace-nowrap">Total Produk</th>
                            <th class="px-6 py-4 text-xs font-semibold text-secondary uppercase tracking-wider whitespace-nowrap">Deskripsi</th>
                            <th class="px-6 py-4 text-xs font-semibold text-secondary uppercase tracking-wider whitespace-nowrap">Pembaruan Terakhir</th>
                            <th class="px-6 py-4 text-xs font-semibold text-secondary uppercase tracking-wider text-right whitespace-nowrap">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border">
                        @forelse($categories ?? [] as $category)
                            <tr class="hover:bg-canvas transition-colors">
                                <td class="px-6 py-4">
                                    <input class="rounded border-border text-primary focus:ring-primary row-checkbox" type="checkbox">
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-lg bg-primary/10 text-primary flex items-center justify-center">
                                            <span class="material-symbols-outlined">{{ $category->icon ?? 'category' }}</span>
                                        </div>
                                        <span class="font-semibold text-on-surface">{{ $category->name }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="bg-surface-container-high px-2.5 py-1 rounded-full text-xs font-bold text-on-surface">{{ $category->products_count ?? 0 }} produk</span>
                                </td>
                                <td class="px-6 py-4 text-sm text-secondary max-w-xs truncate">
                                    {{ $category->description ?? '-' }}
                                </td>
                                <td class="px-6 py-4 text-sm text-secondary whitespace-nowrap">
                                    {{ $category->updated_at ? $category->updated_at->format('M d, Y') : '-' }}
                                </td>
                                <td class="px-6 py-4 text-right whitespace-nowrap">
                                    <div class="flex justify-end gap-2">
                                        <a href="{{ route('categories.edit', $category) }}" class="p-2 hover:bg-surface-container rounded-lg text-primary transition-colors inline-flex items-center" title="Edit Kategori">
                                            <span class="material-symbols-outlined text-xl">edit</span>
                                        </a>
                                        <form action="{{ route('categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 hover:bg-error-container rounded-lg text-error transition-colors inline-flex items-center" title="Hapus Kategori">
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
                                            <span class="material-symbols-outlined text-3xl">category</span>
                                        </div>
                                        <div>
                                            <h3 class="font-bold text-on-surface text-base">Belum Ada Data Kategori</h3>
                                            <p class="text-xs text-on-surface-variant mt-1">Daftar kategori produk masih kosong. Klik tombol "Tambah Kategori" untuk membuat kategori baru.</p>
                                        </div>
                                        <a href="{{ route('categories.create') }}" class="bg-primary-container text-white px-4 py-2 rounded-lg text-xs font-semibold flex items-center gap-1.5 transition-all shadow-sm">
                                            <span class="material-symbols-outlined text-sm">add</span>
                                            Tambah Kategori
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination Footer -->
            <div class="px-4 sm:px-6 py-4 bg-surface border-t border-border flex flex-col sm:flex-row items-center justify-between gap-4 text-center sm:text-left">
                <div class="text-xs sm:text-sm text-secondary">
                    Menampilkan <span class="font-semibold text-on-surface">{{ isset($categories) && method_exists($categories, 'firstItem') ? ($categories->firstItem() ?? 0) : 0 }} - {{ isset($categories) && method_exists($categories, 'lastItem') ? ($categories->lastItem() ?? 0) : 0 }}</span> dari <span class="font-semibold text-on-surface">{{ isset($categories) && method_exists($categories, 'total') ? $categories->total() : 0 }}</span> data
                </div>
                @if(isset($categories) && method_exists($categories, 'links'))
                    <div>
                        {{ $categories->links() }}
                    </div>
                @endif
            </div>
        </div>

        <!-- Visual Decoration / Bottom Info -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 pt-2">
            <div class="surface-card p-5 sm:p-6 border-l-4 border-primary">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-xs sm:text-sm text-secondary font-medium">Kategori Terpopuler</p>
                        <h3 class="text-lg sm:text-xl font-bold mt-1">{{ $topCategoryName ?? '-' }}</h3>
                    </div>
                    <div class="p-2 bg-primary/10 rounded-full">
                        <span class="material-symbols-outlined text-primary">trending_up</span>
                    </div>
                </div>
                <p class="text-xs text-secondary mt-4 flex items-center gap-1">
                    <span class="text-emerald-600 font-bold">{{ $topCategoryCount ?? 0 }}</span> produk terdaftar
                </p>
            </div>
            <div class="surface-card p-5 sm:p-6 border-l-4 border-orange-400">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-xs sm:text-sm text-secondary font-medium">Stok Rendah</p>
                        <h3 class="text-lg sm:text-xl font-bold mt-1">{{ $lowStockCategoryName ?? '-' }}</h3>
                    </div>
                    <div class="p-2 bg-orange-100 rounded-full">
                        <span class="material-symbols-outlined text-orange-600">warning</span>
                    </div>
                </div>
                <p class="text-xs text-secondary mt-4 flex items-center gap-1">
                    <span class="text-orange-600 font-bold">{{ $lowStockCategoryCount ?? 0 }} Kategori</span> perlu restock
                </p>
            </div>
            <div class="surface-card p-5 sm:p-6 border-l-4 border-emerald-400 col-span-1 sm:col-span-2 lg:col-span-1">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-xs sm:text-sm text-secondary font-medium">Total Inventaris</p>
                        <h3 class="text-lg sm:text-xl font-bold mt-1">{{ number_format($totalInventoryItems ?? 0) }}</h3>
                    </div>
                    <div class="p-2 bg-emerald-100 rounded-full">
                        <span class="material-symbols-outlined text-emerald-600">inventory</span>
                    </div>
                </div>
                <p class="text-xs text-secondary mt-4 flex items-center gap-1">
                    Status sistem inventaris
                </p>
            </div>
        </div>
    </div>

    <!-- Checkbox Selection Script -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const selectAllHeader = document.getElementById('select-all');
            const rowCheckboxes = document.querySelectorAll('.row-checkbox');

            if (selectAllHeader) {
                selectAllHeader.addEventListener('change', (e) => {
                    rowCheckboxes.forEach(cb => {
                        cb.checked = e.target.checked;
                        if (e.target.checked) {
                            cb.closest('tr')?.classList.add('bg-primary/5');
                        } else {
                            cb.closest('tr')?.classList.remove('bg-primary/5');
                        }
                    });
                });
            }

            rowCheckboxes.forEach(cb => {
                cb.addEventListener('change', () => {
                    if (cb.checked) {
                        cb.closest('tr')?.classList.add('bg-primary/5');
                    } else {
                        cb.closest('tr')?.classList.remove('bg-primary/5');
                    }
                });
            });
        });
    </script>
</x-layouts.app>
