<x-layouts.app title="Manajemen Kategori - Fixoria Sales">
    <div class="p-6 md:p-8 space-y-6">
        <!-- Page Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="font-display-lg text-display-lg text-on-surface">Manajemen Kategori</h2>
                <nav class="flex text-xs text-secondary gap-2 mt-1">
                    <a class="hover:text-primary transition-colors" href="{{ route('dashboard') }}">Dashboard</a>
                    <span>/</span>
                    <span class="text-on-surface font-semibold">Kategori</span>
                </nav>
            </div>
            <a href="{{ route('categories.create') }}" class="bg-primary hover:bg-primary/90 text-white px-5 py-2.5 rounded-xl font-semibold flex items-center gap-2 transition-all shadow-md active:scale-95 text-sm shrink-0">
                <span class="material-symbols-outlined text-xl">add</span>
                <span>Tambah Kategori Baru</span>
            </a>
        </div>

        <!-- Notification Alert -->
        @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 p-4 rounded-xl text-sm flex items-center justify-between shadow-xs">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-emerald-600">check_circle</span>
                    <span class="font-semibold">{{ session('success') }}</span>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="text-emerald-600 hover:text-emerald-900">
                    <span class="material-symbols-outlined text-sm">close</span>
                </button>
            </div>
        @endif

        <!-- Filter & Search Section -->
        <div class="surface-card p-4 flex flex-col md:flex-row gap-4 items-center justify-between border border-border/50">
            <form action="{{ route('categories.index') }}" method="GET" class="w-full md:w-auto flex-1">
                <div class="relative w-full md:w-96">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-secondary text-lg">search</span>
                    <input name="search" value="{{ request('search') }}" class="w-full h-10 pl-10 pr-4 bg-white border border-border rounded-lg text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all outline-none" placeholder="Cari nama kategori..." type="text">
                </div>
            </form>
        </div>

        <!-- Data Table Container -->
        <div class="surface-card overflow-hidden border border-border/50">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-surface-container-low border-b border-border">
                        <tr>
                            <th class="px-6 py-4 text-xs font-semibold text-secondary uppercase tracking-wider whitespace-nowrap">Nama Kategori</th>
                            <th class="px-6 py-4 text-xs font-semibold text-secondary uppercase tracking-wider whitespace-nowrap">Total Produk</th>
                            <th class="px-6 py-4 text-xs font-semibold text-secondary uppercase tracking-wider whitespace-nowrap">Deskripsi</th>
                            <th class="px-6 py-4 text-xs font-semibold text-secondary uppercase tracking-wider whitespace-nowrap">Pembaruan Terakhir</th>
                            <th class="px-6 py-4 text-xs font-semibold text-secondary uppercase tracking-wider text-right whitespace-nowrap">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border">
                        @forelse($categories as $category)
                            <tr class="hover:bg-canvas transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-lg bg-primary/10 text-primary flex items-center justify-center shrink-0">
                                            <span class="material-symbols-outlined">category</span>
                                        </div>
                                        <span class="font-semibold text-on-surface">{{ $category->name }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="bg-surface-container-high px-3 py-1 rounded-full text-xs font-bold text-on-surface">
                                        {{ $category->products_count }} produk
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-secondary max-w-xs truncate">
                                    {{ $category->description ?? '-' }}
                                </td>
                                <td class="px-6 py-4 text-sm text-secondary whitespace-nowrap">
                                    {{ $category->updated_at ? $category->updated_at->format('M d, Y') : '-' }}
                                </td>
                                <td class="px-6 py-4 text-right whitespace-nowrap">
                                    <div class="flex justify-end gap-2">
                                        <a href="{{ route('categories.edit', $category) }}" class="p-2 text-secondary hover:text-primary hover:bg-primary/5 rounded-lg transition-all" title="Edit Kategori">
                                            <span class="material-symbols-outlined text-xl">edit_square</span>
                                        </a>
                                        <form action="{{ route('categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 text-secondary hover:text-error-text hover:bg-error-bg rounded-lg transition-all" title="Hapus Kategori">
                                                <span class="material-symbols-outlined text-xl">delete</span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="px-6 py-16 text-center text-on-surface-variant" colspan="5">
                                    <div class="flex flex-col items-center justify-center max-w-sm mx-auto space-y-3">
                                        <div class="w-16 h-16 rounded-full bg-surface-container-low flex items-center justify-center text-outline">
                                            <span class="material-symbols-outlined text-3xl">category</span>
                                        </div>
                                        <div>
                                            <h3 class="font-bold text-on-surface text-base">Belum Ada Data Kategori</h3>
                                            <p class="text-xs text-on-surface-variant mt-1">Daftar kategori produk masih kosong. Klik tombol "Tambah Kategori Baru" untuk membuat kategori.</p>
                                        </div>
                                        <a href="{{ route('categories.create') }}" class="bg-primary hover:bg-primary/90 text-white px-4 py-2 rounded-lg text-xs font-semibold flex items-center gap-1.5 transition-all shadow-sm">
                                            <span class="material-symbols-outlined text-sm">add</span>
                                            Tambah Kategori Baru
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination Footer -->
            <div class="px-6 py-4 bg-surface border-t border-border flex flex-col md:flex-row items-center justify-between gap-4">
                <p class="font-body-md text-on-surface-variant text-sm">
                    Menampilkan <span class="font-bold text-on-surface">{{ $categories->firstItem() ?? 0 }} - {{ $categories->lastItem() ?? 0 }}</span> dari <span class="font-bold text-on-surface">{{ $categories->total() }}</span> kategori
                </p>
                <div>
                    {{ $categories->links() }}
                </div>
            </div>
        </div>

        <!-- Visual Decoration / Bottom Info -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-2">
            <div class="surface-card p-6 border-l-4 border-primary">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm text-secondary font-medium">Kategori Terpopuler</p>
                        <h3 class="text-xl font-bold mt-1">{{ $topCategoryName }}</h3>
                    </div>
                    <div class="p-2 bg-primary/10 rounded-full">
                        <span class="material-symbols-outlined text-primary">trending_up</span>
                    </div>
                </div>
                <p class="text-xs text-secondary mt-4 flex items-center gap-1">
                    <span class="text-emerald-600 font-bold">{{ $topCategoryCount }}</span> produk terdaftar
                </p>
            </div>
            <div class="surface-card p-6 border-l-4 border-emerald-400">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm text-secondary font-medium">Total Barang Terdaftar</p>
                        <h3 class="text-xl font-bold mt-1">{{ number_format($totalInventoryItems) }}</h3>
                    </div>
                    <div class="p-2 bg-emerald-100 rounded-full">
                        <span class="material-symbols-outlined text-emerald-600">inventory</span>
                    </div>
                </div>
                <p class="text-xs text-secondary mt-4 flex items-center gap-1">
                    Total fisik unit produk di seluruh kategori
                </p>
            </div>
        </div>
    </div>
</x-layouts.app>
