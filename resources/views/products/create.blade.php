<x-layouts.app title="Tambah Produk Baru - Fixoria Sales">
    <div class="p-6 md:p-8 space-y-6">
        <!-- Breadcrumb & Header -->
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
            <div>
                <nav class="flex items-center gap-2 text-xs font-semibold text-secondary mb-3">
                    <a href="{{ route('products.index') }}" class="hover:text-primary transition-colors">Master Produk</a>
                    <span class="material-symbols-outlined text-[14px]">chevron_right</span>
                    <span class="text-on-surface-variant">Tambah Produk</span>
                </nav>
                <h2 class="font-display-lg text-display-lg text-on-surface mb-1">Tambah Produk Baru</h2>
                <p class="font-body-md text-body-md text-on-surface-variant">Silahkan lengkapi data produk di bawah ini untuk menambahkan stok baru ke database.</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('products.index') }}" class="px-6 py-2.5 bg-white border border-border text-on-surface rounded-lg font-semibold hover:bg-surface-container transition-all flex items-center gap-2">
                    Batal
                </a>
                <button type="submit" form="create-product-form" class="bg-primary-container hover:bg-primary text-white px-6 py-2.5 rounded-lg font-semibold flex items-center gap-2 shadow-lg shadow-primary/20 transition-all active:scale-95">
                    <span class="material-symbols-outlined text-sm">save</span>
                    Simpan Produk
                </button>
            </div>
        </div>

        @if ($errors->any())
            <div class="bg-error-bg border border-error-text/30 text-error-text p-4 rounded-xl text-sm">
                <div class="font-bold flex items-center gap-2 mb-1">
                    <span class="material-symbols-outlined text-base">error</span>
                    <span>Terdapat kesalahan pada input Anda:</span>
                </div>
                <ul class="list-disc list-inside space-y-0.5 text-xs pl-6">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form & Preview Grid -->
        <form id="create-product-form" action="{{ route('products.store') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                <!-- Left Side: Form (8 cols) -->
                <div class="lg:col-span-8 space-y-6">
                    <!-- Section 1: Informasi Produk -->
                    <section class="bg-white rounded-xl p-6 md:p-8 card-shadow border border-border">
                        <div class="flex items-center gap-3 mb-8 pb-4 border-b border-border">
                            <span class="material-symbols-outlined text-primary">info</span>
                            <h3 class="text-lg font-bold text-on-surface">Informasi Produk</h3>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="md:col-span-2">
                                <label class="block text-xs font-semibold text-label mb-2" for="input_nama">Nama Produk <span class="text-error-text">*</span></label>
                                <input class="w-full h-10 px-3 rounded-lg border border-border text-sm focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 transition-all @error('name') border-error-text @enderror" id="input_nama" name="name" value="{{ old('name') }}" placeholder="Contoh: Ergonomic Office Chair" type="text" required />
                                @error('name')
                                    <span class="text-xs text-error-text mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-label mb-2" for="input_sku">SKU (Stock Keeping Unit) <span class="text-error-text">*</span></label>
                                <input class="w-full h-10 px-3 rounded-lg border border-border text-sm focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 transition-all @error('sku') border-error-text @enderror" id="input_sku" name="sku" value="{{ old('sku') }}" placeholder="Contoh: SKU-2024-001" type="text" required />
                                @error('sku')
                                    <span class="text-xs text-error-text mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-label mb-2" for="input_satuan">Satuan <span class="text-error-text">*</span></label>
                                <select class="w-full h-10 px-3 rounded-lg border border-border text-sm focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 transition-all @error('unit') border-error-text @enderror" id="input_satuan" name="unit" required>
                                    <option value="">Pilih Satuan</option>
                                    <option value="Pcs" {{ old('unit') == 'Pcs' ? 'selected' : '' }}>Pcs</option>
                                    <option value="Box" {{ old('unit') == 'Box' ? 'selected' : '' }}>Box</option>
                                    <option value="Kg" {{ old('unit') == 'Kg' ? 'selected' : '' }}>Kg</option>
                                    <option value="Liter" {{ old('unit') == 'Liter' ? 'selected' : '' }}>Liter</option>
                                </select>
                                @error('unit')
                                    <span class="text-xs text-error-text mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-label mb-2" for="input_kategori">Kategori Produk</label>
                                <select class="w-full h-10 px-3 rounded-lg border border-border text-sm focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 transition-all @error('category_id') border-error-text @enderror" id="input_kategori" name="category_id">
                                    <option value="">Pilih Kategori</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <span class="text-xs text-error-text mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-label mb-2" for="input_supplier">Supplier</label>
                                <select class="w-full h-10 px-3 rounded-lg border border-border text-sm focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 transition-all @error('supplier_id') border-error-text @enderror" id="input_supplier" name="supplier_id">
                                    <option value="">Pilih Supplier</option>
                                    @foreach($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}" {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>{{ $supplier->name }}</option>
                                    @endforeach
                                </select>
                                @error('supplier_id')
                                    <span class="text-xs text-error-text mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-xs font-semibold text-label mb-2" for="input_deskripsi">Deskripsi Produk</label>
                                <textarea class="w-full rounded-lg border border-border p-3 focus:border-primary focus:ring-2 focus:ring-primary/10 text-sm outline-none transition-all @error('description') border-error-text @enderror" id="input_deskripsi" name="description" placeholder="Tuliskan deskripsi lengkap mengenai detail produk, material, dan spesifikasi..." rows="4">{{ old('description') }}</textarea>
                                @error('description')
                                    <span class="text-xs text-error-text mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </section>

                    <!-- Section 2: Harga & Stok -->
                    <section class="bg-white rounded-xl p-6 md:p-8 card-shadow border border-border">
                        <div class="flex items-center gap-3 mb-8 pb-4 border-b border-border">
                            <span class="material-symbols-outlined text-primary">payments</span>
                            <h3 class="text-lg font-bold text-on-surface">Harga & Stok</h3>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-xs font-semibold text-label mb-2" for="input_harga_beli">Harga Beli (Rp)</label>
                                <div class="relative">
                                    <span class="absolute left-3 top-2.5 text-xs font-bold text-on-surface-variant">Rp</span>
                                    <input class="w-full h-10 pl-10 pr-3 rounded-lg border border-border text-sm focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 transition-all @error('purchase_price') border-error-text @enderror" id="input_harga_beli" name="purchase_price" value="{{ old('purchase_price') }}" placeholder="0" type="number" min="0" />
                                </div>
                                @error('purchase_price')
                                    <span class="text-xs text-error-text mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-label mb-2" for="input_harga">Harga Jual (Rp) <span class="text-error-text">*</span></label>
                                <div class="relative">
                                    <span class="absolute left-3 top-2.5 text-xs font-bold text-on-surface-variant">Rp</span>
                                    <input class="w-full h-10 pl-10 pr-3 rounded-lg border border-border text-sm focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 transition-all @error('selling_price') border-error-text @enderror" id="input_harga" name="selling_price" value="{{ old('selling_price') }}" placeholder="0" type="number" min="0" required />
                                </div>
                                @error('selling_price')
                                    <span class="text-xs text-error-text mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="md:col-span-2 pt-2">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label class="block text-xs font-semibold text-label mb-2" for="input_stok">Stok Saat Ini <span class="text-error-text">*</span></label>
                                        <input class="w-full h-10 px-3 rounded-lg border border-border text-sm focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 transition-all @error('stock') border-error-text @enderror" id="input_stok" name="stock" value="{{ old('stock', 0) }}" placeholder="0" type="number" min="0" required />
                                        @error('stock')
                                            <span class="text-xs text-error-text mt-1 block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-label mb-2" for="input_min_stok">Minimum Stok (Safety Stock)</label>
                                        <input class="w-full h-10 px-3 rounded-lg border border-border text-sm focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 transition-all @error('min_stock') border-error-text @enderror" id="input_min_stok" name="min_stock" value="{{ old('min_stock', 10) }}" placeholder="10" type="number" min="0" />
                                        <p class="text-[10px] text-on-surface-variant mt-1.5 italic">Sistem akan memberi notifikasi jika stok di bawah angka ini.</p>
                                        @error('min_stock')
                                            <span class="text-xs text-error-text mt-1 block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>

                <!-- Right Side: Preview & Tips (4 cols) -->
                <div class="lg:col-span-4 space-y-6">
                    <!-- Product Preview Card -->
                    <div class="bg-white rounded-xl card-shadow border border-border overflow-hidden">
                        <div class="bg-surface-container-low px-6 py-4 border-b border-border">
                            <h4 class="font-bold text-sm text-on-surface">Pratinjau Produk</h4>
                        </div>
                        <div class="p-6">
                            <div class="w-full aspect-square rounded-xl bg-canvas mb-6 overflow-hidden flex items-center justify-center relative group">
                                <img class="w-full h-full object-cover" alt="Product Photograph" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBRXEXlJ6NHGD7AkGRt1t2dYxz11_J4H14mboxXFgRluSM0joql2WyLLF8LLUAhcGvmP5qJSHKv3-jHHj_UBTB4bZPcvaH3SLly_qNpDSvjQQPuLMlDqysrLHealKDCKCNAiVfGxMWW9KE00lm9uebh7cZliFoNoTXGn7bCNS6L7LvPdxTBZcM_zbkFHV6xUCrQyhY99n7jKGr7Tqtmim_dfQes-UaoUQ5KsGAtHLVfVJ59N7kep8mE"/>
                                <div class="absolute inset-0 bg-black/5 group-hover:bg-black/0 transition-colors"></div>
                            </div>
                            <div class="space-y-4">
                                <div>
                                    <span class="px-2 py-1 bg-secondary-container text-secondary text-[10px] font-bold rounded uppercase tracking-wider" id="preview_kategori">Kategori</span>
                                    <h5 class="text-xl font-bold mt-2 text-on-surface" id="preview_nama">Nama Produk Baru</h5>
                                </div>
                                <div class="flex justify-between items-end border-t border-border pt-4">
                                    <div>
                                        <p class="text-[10px] text-on-surface-variant font-semibold uppercase">Harga Jual</p>
                                        <p class="text-2xl font-extrabold text-primary" id="preview_harga">Rp 0</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-[10px] text-on-surface-variant font-semibold uppercase">Status Stok</p>
                                        <span class="text-xs font-bold text-error-text" id="preview_stok_status">Belum Ada Stok</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tips Card -->
                    <div class="bg-primary-fixed/30 rounded-xl p-6 border border-primary/10">
                        <div class="flex items-center gap-2 mb-4">
                            <span class="material-symbols-outlined text-primary">lightbulb</span>
                            <h4 class="font-bold text-sm text-on-surface">Tips Pengisian</h4>
                        </div>
                        <ul class="space-y-4">
                            <li class="flex gap-3">
                                <div class="mt-1 w-1.5 h-1.5 rounded-full bg-primary shrink-0"></div>
                                <p class="text-xs leading-relaxed text-on-surface-variant"><span class="font-bold text-on-surface">Penamaan SKU:</span> Gunakan format yang konsisten seperti [KAT]-[THN]-[URUT] untuk memudahkan pencarian di gudang.</p>
                            </li>
                            <li class="flex gap-3">
                                <div class="mt-1 w-1.5 h-1.5 rounded-full bg-primary shrink-0"></div>
                                <p class="text-xs leading-relaxed text-on-surface-variant"><span class="font-bold text-on-surface">Safety Stock:</span> Atur minimal 15-20% dari rata-rata penjualan bulanan agar stok tidak benar-benar habis.</p>
                            </li>
                            <li class="flex gap-3">
                                <div class="mt-1 w-1.5 h-1.5 rounded-full bg-primary shrink-0"></div>
                                <p class="text-xs leading-relaxed text-on-surface-variant"><span class="font-bold text-on-surface">Foto Produk:</span> Gunakan latar belakang polos agar tampilan katalog dashboard tetap bersih dan profesional.</p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const inputNama = document.getElementById('input_nama');
            const inputKategori = document.getElementById('input_kategori');
            const inputHarga = document.getElementById('input_harga');
            const inputStok = document.getElementById('input_stok');
            
            const previewNama = document.getElementById('preview_nama');
            const previewKategori = document.getElementById('preview_kategori');
            const previewHarga = document.getElementById('preview_harga');
            const previewStokStatus = document.getElementById('preview_stok_status');

            const updatePreview = () => {
                if (inputNama && previewNama) {
                    previewNama.textContent = inputNama.value.trim() || 'Nama Produk Baru';
                }

                if (inputKategori && previewKategori) {
                    const selectedOption = inputKategori.options[inputKategori.selectedIndex];
                    const selectedText = selectedOption ? selectedOption.text : 'Kategori';
                    previewKategori.textContent = (inputKategori.value && selectedText !== 'Pilih Kategori') ? selectedText : 'Kategori';
                }

                if (inputHarga && previewHarga) {
                    const val = inputHarga.value;
                    if (val && val > 0) {
                        const formatted = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 }).format(val);
                        previewHarga.textContent = formatted;
                    } else {
                        previewHarga.textContent = 'Rp 0';
                    }
                }

                if (inputStok && previewStokStatus) {
                    const val = parseInt(inputStok.value, 10);
                    if (isNaN(val) || val <= 0) {
                        previewStokStatus.textContent = 'Belum Ada Stok';
                        previewStokStatus.className = 'text-xs font-bold text-error-text';
                    } else {
                        previewStokStatus.textContent = val + ' Pcs Tersedia';
                        previewStokStatus.className = 'text-xs font-bold text-emerald-600';
                    }
                }
            };

            if (inputNama) inputNama.addEventListener('input', updatePreview);
            if (inputKategori) inputKategori.addEventListener('change', updatePreview);
            if (inputHarga) inputHarga.addEventListener('input', updatePreview);
            if (inputStok) inputStok.addEventListener('input', updatePreview);

            // Initial trigger
            updatePreview();
        });
    </script>
</x-layouts.app>
