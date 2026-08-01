<x-layouts.app title="Master Produk - Fixoria Sales">
    <div class="p-6 md:p-8 space-y-6">
        <!-- Top App Bar Content -->
        <header class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="font-display-lg text-display-lg text-on-surface">Data Produk</h2>
                <p class="font-body-md text-body-md text-on-surface-variant">Kelola daftar inventaris barang dan stok di sini.</p>
            </div>
            <a href="{{ route('products.create') }}" class="bg-primary-container hover:bg-primary text-white px-5 py-2.5 rounded-lg flex items-center gap-2 transition-all font-body-md shadow-sm active:scale-95 shrink-0">
                <span class="material-symbols-outlined">add</span>
                Tambah Produk Baru
            </a>
        </header>

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

        <!-- Filter Area -->
        <section class="bg-white p-5 rounded-xl card-shadow border border-border">
            <form action="{{ route('products.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-12 gap-4">
                <div class="relative md:col-span-6">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline">search</span>
                    <input class="w-full pl-10 pr-4 py-2 bg-white border border-border rounded-lg text-body-md focus:ring-2 focus:ring-primary focus:border-primary transition-all outline-none" name="search" value="{{ request('search') }}" placeholder="Cari berdasarkan Nama atau SKU..." type="text">
                </div>
                <div class="md:col-span-3">
                    <select name="category_id" onchange="this.form.submit()" class="w-full px-4 py-2 bg-white border border-border rounded-lg text-body-md focus:ring-2 focus:ring-primary focus:border-primary transition-all outline-none">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="md:col-span-3">
                    <select name="supplier_id" onchange="this.form.submit()" class="w-full px-4 py-2 bg-white border border-border rounded-lg text-body-md focus:ring-2 focus:ring-primary focus:border-primary transition-all outline-none">
                        <option value="">Semua Supplier</option>
                        @foreach($suppliers as $supplier)
                            <option value="{{ $supplier->id }}" {{ request('supplier_id') == $supplier->id ? 'selected' : '' }}>{{ $supplier->name }}</option>
                        @endforeach
                    </select>
                </div>
            </form>
        </section>

        <!-- Data Table Section -->
        <div class="bg-white rounded-xl card-shadow border border-border overflow-hidden">
            <div class="overflow-x-auto custom-scrollbar">
                <table class="w-full text-left border-collapse min-w-[800px]">
                    <thead class="bg-surface-container-low border-b border-border">
                        <tr>
                            <th class="px-6 py-4 font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider whitespace-nowrap">SKU</th>
                            <th class="px-6 py-4 font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider whitespace-nowrap">Foto</th>
                            <th class="px-6 py-4 font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider whitespace-nowrap">Nama Barang</th>
                            <th class="px-6 py-4 font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider whitespace-nowrap">Kategori</th>
                            <th class="px-6 py-4 font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider whitespace-nowrap">Supplier</th>
                            <th class="px-6 py-4 font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider whitespace-nowrap">Harga Beli</th>
                            <th class="px-6 py-4 font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider whitespace-nowrap">Harga Jual</th>
                            <th class="px-6 py-4 font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider whitespace-nowrap">Stok Saat Ini</th>
                            <th class="px-6 py-4 font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider whitespace-nowrap">Satuan</th>
                            <th class="px-6 py-4 font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider whitespace-nowrap">Status</th>
                            <th class="px-6 py-4 font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider text-right whitespace-nowrap">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border">
                        @forelse($products as $product)
                            <tr class="hover:bg-canvas transition-colors">
                                <td class="px-6 py-4 font-body-md text-on-surface font-mono text-xs whitespace-nowrap">{{ $product->sku }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-12 h-12 object-cover rounded-xl border border-border shadow-xs" />
                                    @else
                                        <div class="w-12 h-12 rounded-xl bg-canvas border border-border flex items-center justify-center text-outline">
                                            <span class="material-symbols-outlined text-2xl">inventory_2</span>
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 font-body-md text-on-surface font-semibold whitespace-nowrap">{{ $product->name }}</td>
                                <td class="px-6 py-4 font-body-md text-on-surface-variant whitespace-nowrap">
                                    <span class="px-2 py-0.5 rounded bg-surface-container text-xs font-semibold">
                                        {{ $product->category->name ?? '-' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 font-body-md text-on-surface-variant whitespace-nowrap">{{ $product->supplier->name ?? '-' }}</td>
                                <td class="px-6 py-4 font-body-md text-on-surface whitespace-nowrap">Rp {{ number_format($product->purchase_price, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 font-body-md text-on-surface font-bold text-primary whitespace-nowrap">Rp {{ number_format($product->selling_price, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 font-body-md text-on-surface whitespace-nowrap">
                                    <span class="flex items-center gap-2">
                                        <span class="{{ $product->stock <= $product->min_stock ? 'text-error-text font-bold' : 'text-on-surface font-semibold' }}">
                                            {{ $product->stock }}
                                        </span>
                                        <span class="text-on-surface-variant text-xs">(Min: {{ $product->min_stock }})</span>
                                    </span>
                                </td>
                                <td class="px-6 py-4 font-body-md text-on-surface whitespace-nowrap">{{ $product->unit }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($product->is_active)
                                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-green-100 text-green-700 uppercase">Active</span>
                                    @else
                                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-surface-variant text-on-surface-variant uppercase">Inactive</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right whitespace-nowrap">
                                    <div class="flex items-center justify-end gap-3">
                                        <a href="{{ route('products.edit', $product) }}" class="p-2 hover:bg-surface-container rounded-lg text-primary transition-colors inline-flex items-center" title="Edit Produk">
                                            <span class="material-symbols-outlined text-xl">edit</span>
                                        </a>
                                        <form action="{{ route('products.destroy', $product) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 hover:bg-error-container rounded-lg text-error transition-colors inline-flex items-center" title="Hapus Produk">
                                                <span class="material-symbols-outlined text-xl">delete</span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="px-6 py-16 text-center text-on-surface-variant" colspan="10">
                                    <div class="flex flex-col items-center justify-center max-w-sm mx-auto space-y-3">
                                        <div class="w-16 h-16 rounded-full bg-surface-container-low flex items-center justify-center text-outline">
                                            <span class="material-symbols-outlined text-3xl">inventory_2</span>
                                        </div>
                                        <div>
                                            <h3 class="font-bold text-on-surface text-base">Belum Ada Data Produk</h3>
                                            <p class="text-xs text-on-surface-variant mt-1">Daftar produk inventaris belum ditemukan. Klik tombol "Tambah Produk Baru" untuk menambahkan data.</p>
                                        </div>
                                        <a href="{{ route('products.create') }}" class="bg-primary-container hover:bg-primary text-white px-4 py-2 rounded-lg text-xs font-semibold flex items-center gap-1.5 transition-all shadow-sm">
                                            <span class="material-symbols-outlined text-sm">add</span>
                                            Tambah Produk Baru
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination Footer -->
            <div class="px-6 py-4 bg-white border-t border-border flex flex-col md:flex-row items-center justify-between gap-4">
                <p class="font-body-md text-on-surface-variant text-sm">
                    Menampilkan <span class="font-bold text-on-surface">{{ $products->firstItem() ?? 0 }} - {{ $products->lastItem() ?? 0 }}</span> dari <span class="font-bold text-on-surface">{{ $products->total() }}</span> produk
                </p>
                <div>
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
