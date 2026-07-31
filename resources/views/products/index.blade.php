<x-layouts.app title="Master Produk - Fixoria Sales">
    <div class="p-6 md:p-8 space-y-6">
        <!-- Top App Bar Content -->
        <header class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="font-display-lg text-display-lg text-on-surface">Data Produk</h2>
                <p class="font-body-md text-body-md text-on-surface-variant">Kelola daftar inventaris barang dan stok di sini.</p>
            </div>
            <button class="bg-primary-container hover:bg-primary text-white px-5 py-2.5 rounded-lg flex items-center gap-2 transition-all font-body-md shadow-sm" onclick="document.getElementById('modal-add-product').classList.remove('hidden')" type="button">
                <span class="material-symbols-outlined">add</span>
                Tambah Produk Baru
            </button>
        </header>

        <!-- Filter Area -->
        <section class="bg-white p-5 rounded-xl card-shadow border border-border">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="relative md:col-span-2">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline">search</span>
                    <input class="w-full pl-10 pr-4 py-2 bg-white border border-border rounded-lg text-body-md focus:ring-2 focus:ring-primary focus:border-primary transition-all outline-none" placeholder="Cari berdasarkan Nama atau SKU..." type="text">
                </div>
                <div>
                    <select class="w-full px-4 py-2 bg-white border border-border rounded-lg text-body-md focus:ring-2 focus:ring-primary focus:border-primary transition-all outline-none">
                        <option value="">Semua Kategori</option>
                        @foreach($categories ?? [] as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <select class="w-full px-4 py-2 bg-white border border-border rounded-lg text-body-md focus:ring-2 focus:ring-primary focus:border-primary transition-all outline-none">
                        <option value="">Semua Supplier</option>
                        @foreach($suppliers ?? [] as $supplier)
                            <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </section>

        <!-- Data Table Section -->
        <div class="bg-white rounded-xl card-shadow border border-border overflow-hidden">
            <div class="overflow-x-auto custom-scrollbar">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-surface-container-low border-b border-border">
                        <tr>
                            <th class="px-6 py-4 font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">SKU</th>
                            <th class="px-6 py-4 font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Nama Barang</th>
                            <th class="px-6 py-4 font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Kategori</th>
                            <th class="px-6 py-4 font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Supplier</th>
                            <th class="px-6 py-4 font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Harga Beli</th>
                            <th class="px-6 py-4 font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Harga Jual</th>
                            <th class="px-6 py-4 font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Stok Saat Ini</th>
                            <th class="px-6 py-4 font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Satuan</th>
                            <th class="px-6 py-4 font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border">
                        @forelse($products ?? [] as $product)
                            <tr class="hover:bg-canvas transition-colors">
                                <td class="px-6 py-4 font-body-md text-on-surface">{{ $product->sku }}</td>
                                <td class="px-6 py-4 font-body-md text-on-surface font-semibold">{{ $product->name }}</td>
                                <td class="px-6 py-4 font-body-md text-on-surface-variant">{{ $product->category->name ?? '-' }}</td>
                                <td class="px-6 py-4 font-body-md text-on-surface-variant">{{ $product->supplier->name ?? '-' }}</td>
                                <td class="px-6 py-4 font-body-md text-on-surface">Rp {{ number_format($product->purchase_price ?? 0, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 font-body-md text-on-surface">Rp {{ number_format($product->selling_price ?? 0, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 font-body-md text-on-surface">
                                    <span class="flex items-center gap-2">{{ $product->stock }} <span class="text-on-surface-variant text-xs">(Min: {{ $product->min_stock }})</span></span>
                                </td>
                                <td class="px-6 py-4 font-body-md text-on-surface">{{ $product->unit }}</td>
                                <td class="px-6 py-4">
                                    @if($product->is_active)
                                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-green-100 text-green-700 uppercase">Active</span>
                                    @else
                                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-surface-variant text-on-surface-variant uppercase">Inactive</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-3">
                                        <button class="text-outline hover:text-primary transition-colors" type="button"><span class="material-symbols-outlined text-xl">edit</span></button>
                                        <button class="text-outline hover:text-error transition-colors" type="button"><span class="material-symbols-outlined text-xl">delete</span></button>
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
                                            <p class="text-xs text-on-surface-variant mt-1">Daftar produk inventaris masih kosong. Klik tombol "Tambah Produk Baru" untuk menambahkan data.</p>
                                        </div>
                                        <button class="bg-primary-container hover:bg-primary text-white px-4 py-2 rounded-lg text-xs font-semibold flex items-center gap-1.5 transition-all shadow-sm" onclick="document.getElementById('modal-add-product').classList.remove('hidden')" type="button">
                                            <span class="material-symbols-outlined text-sm">add</span>
                                            Tambah Produk Baru
                                        </button>
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
                    Menampilkan <span class="font-bold text-on-surface">{{ isset($products) && method_exists($products, 'firstItem') ? ($products->firstItem() ?? 0) : 0 }} - {{ isset($products) && method_exists($products, 'lastItem') ? ($products->lastItem() ?? 0) : 0 }}</span> dari <span class="font-bold text-on-surface">{{ isset($products) && method_exists($products, 'total') ? $products->total() : 0 }}</span> produk
                </p>
                <nav class="flex items-center gap-2">
                    <button class="w-8 h-8 flex items-center justify-center rounded border border-border text-on-surface hover:bg-surface-container transition-colors disabled:opacity-40" disabled type="button">
                        <span class="material-symbols-outlined text-lg">chevron_left</span>
                    </button>
                    <button class="w-8 h-8 flex items-center justify-center rounded bg-primary text-white font-bold text-xs" type="button">1</button>
                    <button class="w-8 h-8 flex items-center justify-center rounded border border-border text-on-surface hover:bg-surface-container transition-colors disabled:opacity-40" disabled type="button">
                        <span class="material-symbols-outlined text-lg">chevron_right</span>
                    </button>
                </nav>
            </div>
        </div>
    </div>

    <!-- Modal Overlay: Tambah Produk Baru -->
    <div aria-labelledby="modal-title" aria-modal="true" class="hidden fixed inset-0 z-50 overflow-y-auto" id="modal-add-product" role="dialog">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div aria-hidden="true" class="fixed inset-0 transition-opacity bg-on-background/50 backdrop-blur-sm" onclick="document.getElementById('modal-add-product').classList.add('hidden')"></div>
            <span aria-hidden="true" class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>
            <div class="inline-block align-bottom bg-white rounded-xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full border border-border">
                <div class="px-6 py-4 border-b border-border flex items-center justify-between">
                    <h3 class="font-display-lg text-display-lg text-on-surface" id="modal-title">Tambah Produk Baru</h3>
                    <button class="text-outline hover:text-on-surface transition-colors" onclick="document.getElementById('modal-add-product').classList.add('hidden')" type="button">
                        <span class="material-symbols-outlined">close</span>
                    </button>
                </div>
                <form class="p-6" onsubmit="event.preventDefault(); document.getElementById('modal-add-product').classList.add('hidden');">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Left Column -->
                        <div class="space-y-4">
                            <div>
                                <label class="block font-label-sm text-label-sm text-on-surface-variant mb-1">SKU Produk</label>
                                <input class="w-full px-4 py-2 border border-border rounded-lg text-body-md focus:ring-2 focus:ring-primary focus:border-primary transition-all outline-none" placeholder="Contoh: SKU-001" type="text" required>
                            </div>
                            <div>
                                <label class="block font-label-sm text-label-sm text-on-surface-variant mb-1">Nama Barang</label>
                                <input class="w-full px-4 py-2 border border-border rounded-lg text-body-md focus:ring-2 focus:ring-primary focus:border-primary transition-all outline-none" placeholder="Masukkan nama barang" type="text" required>
                            </div>
                            <div>
                                <label class="block font-label-sm text-label-sm text-on-surface-variant mb-1">Kategori</label>
                                <select class="w-full px-4 py-2 border border-border rounded-lg text-body-md focus:ring-2 focus:ring-primary focus:border-primary transition-all outline-none">
                                    <option value="">Pilih Kategori</option>
                                    @foreach($categories ?? [] as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block font-label-sm text-label-sm text-on-surface-variant mb-1">Supplier</label>
                                <select class="w-full px-4 py-2 border border-border rounded-lg text-body-md focus:ring-2 focus:ring-primary focus:border-primary transition-all outline-none">
                                    <option value="">Pilih Supplier</option>
                                    @foreach($suppliers ?? [] as $supplier)
                                        <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <!-- Right Column -->
                        <div class="space-y-4">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block font-label-sm text-label-sm text-on-surface-variant mb-1">Harga Beli</label>
                                    <input class="w-full px-4 py-2 border border-border rounded-lg text-body-md focus:ring-2 focus:ring-primary focus:border-primary transition-all outline-none" placeholder="0" type="number">
                                </div>
                                <div>
                                    <label class="block font-label-sm text-label-sm text-on-surface-variant mb-1">Harga Jual</label>
                                    <input class="w-full px-4 py-2 border border-border rounded-lg text-body-md focus:ring-2 focus:ring-primary focus:border-primary transition-all outline-none" placeholder="0" type="number">
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block font-label-sm text-label-sm text-on-surface-variant mb-1">Stok Awal</label>
                                    <input class="w-full px-4 py-2 border border-border rounded-lg text-body-md focus:ring-2 focus:ring-primary focus:border-primary transition-all outline-none" placeholder="0" type="number">
                                </div>
                                <div>
                                    <label class="block font-label-sm text-label-sm text-on-surface-variant mb-1">Stok Minimum</label>
                                    <input class="w-full px-4 py-2 border border-border rounded-lg text-body-md focus:ring-2 focus:ring-primary focus:border-primary transition-all outline-none" placeholder="0" type="number">
                                </div>
                            </div>
                            <div>
                                <label class="block font-label-sm text-label-sm text-on-surface-variant mb-1">Satuan</label>
                                <div class="flex gap-4 mt-2">
                                    <label class="flex items-center gap-2 cursor-pointer">
                                        <input class="text-primary focus:ring-primary h-4 w-4" name="satuan" type="radio" value="pcs" checked>
                                        <span class="text-body-md">Pcs</span>
                                    </label>
                                    <label class="flex items-center gap-2 cursor-pointer">
                                        <input class="text-primary focus:ring-primary h-4 w-4" name="satuan" type="radio" value="box">
                                        <span class="text-body-md">Box</span>
                                    </label>
                                    <label class="flex items-center gap-2 cursor-pointer">
                                        <input class="text-primary focus:ring-primary h-4 w-4" name="satuan" type="radio" value="kg">
                                        <span class="text-body-md">Kg</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-6 pt-4 border-t border-border flex justify-end gap-3">
                        <button class="px-6 py-2 border border-border rounded-lg text-on-surface hover:bg-surface-container transition-all font-body-md" onclick="document.getElementById('modal-add-product').classList.add('hidden')" type="button">
                            Batal
                        </button>
                        <button class="px-6 py-2 bg-primary-container hover:bg-primary text-white rounded-lg transition-all font-body-md shadow-sm" type="submit">
                            Simpan Produk
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- ESC Key Listener -->
    <script>
        window.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                const modal = document.getElementById('modal-add-product');
                if (modal) modal.classList.add('hidden');
            }
        });
    </script>
</x-layouts.app>
