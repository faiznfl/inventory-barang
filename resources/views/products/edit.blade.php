<x-layouts.app title="Edit Produk - Fixoria Sales">
    <div class="p-6 md:p-8 space-y-6 max-w-7xl mx-auto">
        <!-- Breadcrumb & Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 bg-white p-6 rounded-2xl border border-border shadow-sm">
            <div>
                <nav class="flex items-center gap-2 text-xs font-semibold text-secondary mb-2">
                    <a href="{{ route('products.index') }}" class="hover:text-primary transition-colors flex items-center gap-1">
                        <span class="material-symbols-outlined text-sm">inventory_2</span>
                        <span>Master Produk</span>
                    </a>
                    <span class="material-symbols-outlined text-[14px]">chevron_right</span>
                    <span class="text-on-surface font-bold">Edit Produk</span>
                </nav>
                <h2 class="font-display-lg text-display-lg text-on-surface tracking-tight">Edit Produk</h2>
                <p class="font-body-md text-sm text-on-surface-variant mt-0.5">Silahkan perbarui data, foto, serta pengaturan stok barang di bawah ini.</p>
            </div>
            <div class="flex items-center gap-3 shrink-0">
                <a href="{{ route('products.index') }}" class="px-5 py-2.5 bg-white border border-border text-on-surface rounded-xl font-semibold hover:bg-canvas transition-all flex items-center gap-2 text-sm shadow-xs">
                    <span class="material-symbols-outlined text-sm">arrow_back</span>
                    Batal
                </a>
                <button type="submit" form="edit-product-form" class="bg-primary hover:bg-primary/90 text-white px-6 py-2.5 rounded-xl font-semibold flex items-center gap-2 shadow-lg shadow-primary/25 transition-all active:scale-95 text-sm">
                    <span class="material-symbols-outlined text-sm">save</span>
                    Simpan Perubahan
                </button>
            </div>
        </div>

        @if ($errors->any())
            <div class="bg-error-bg border border-error-text/30 text-error-text p-4 rounded-2xl text-sm shadow-xs animate-fade-in">
                <div class="font-bold flex items-center gap-2 mb-1">
                    <span class="material-symbols-outlined text-base">error</span>
                    <span>Terdapat beberapa kendala pengisian:</span>
                </div>
                <ul class="list-disc list-inside space-y-0.5 text-xs pl-6">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form & Preview Grid -->
        <form id="edit-product-form" action="{{ route('products.update', $product) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                <!-- Left Side: Form Controls (8 cols) -->
                <div class="lg:col-span-8 space-y-6">
                    
                    <!-- Section 1: Informasi Dasar & Foto Produk -->
                    <section class="bg-white rounded-2xl p-6 md:p-8 border border-border shadow-xs space-y-6">
                        <div class="flex items-center justify-between pb-4 border-b border-border">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-primary/10 text-primary flex items-center justify-center shrink-0">
                                    <span class="material-symbols-outlined">edit_square</span>
                                </div>
                                <div>
                                    <h3 class="text-base font-bold text-on-surface">Informasi Dasar & Foto</h3>
                                    <p class="text-xs text-on-surface-variant">Identitas utama barang dan foto tampilan produk.</p>
                                </div>
                            </div>
                            <span class="text-[11px] font-bold px-2.5 py-1 bg-surface-container-low text-secondary rounded-full uppercase">Perbarui Data</span>
                        </div>

                        <!-- Grid Form Inputs + Dropzone Side-by-side -->
                        <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
                            
                            <!-- Left: Text Inputs (7 cols) -->
                            <div class="md:col-span-7 space-y-4">
                                <div>
                                    <label class="block text-xs font-bold text-on-surface mb-1.5" for="input_nama">
                                        Nama Produk <span class="text-error-text">*</span>
                                    </label>
                                    <input class="w-full h-10 px-3.5 rounded-xl border border-border bg-surface-container-lowest text-sm focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all @error('name') border-error-text @enderror" id="input_nama" name="name" value="{{ old('name', $product->name) }}" placeholder="Contoh: Ergonomic Office Chair" type="text" required />
                                    @error('name')
                                        <span class="text-xs text-error-text mt-1 block">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-xs font-bold text-on-surface mb-1.5" for="input_sku">
                                            Kode SKU <span class="text-error-text">*</span>
                                        </label>
                                        <input class="w-full h-10 px-3.5 rounded-xl border border-border bg-surface-container-lowest text-sm font-mono focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all @error('sku') border-error-text @enderror" id="input_sku" name="sku" value="{{ old('sku', $product->sku) }}" placeholder="SKU-2024-001" type="text" required />
                                        @error('sku')
                                            <span class="text-xs text-error-text mt-1 block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-on-surface mb-1.5" for="input_satuan">
                                            Satuan <span class="text-error-text">*</span>
                                        </label>
                                        <select class="w-full h-10 px-3.5 rounded-xl border border-border bg-surface-container-lowest text-sm focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all @error('unit') border-error-text @enderror" id="input_satuan" name="unit" required>
                                            <option value="">Pilih Satuan</option>
                                            <option value="Pcs" {{ old('unit', $product->unit) == 'Pcs' ? 'selected' : '' }}>Pcs (Pcs)</option>
                                            <option value="Box" {{ old('unit', $product->unit) == 'Box' ? 'selected' : '' }}>Box (Dus)</option>
                                            <option value="Kg" {{ old('unit', $product->unit) == 'Kg' ? 'selected' : '' }}>Kg (Kilogram)</option>
                                            <option value="Liter" {{ old('unit', $product->unit) == 'Liter' ? 'selected' : '' }}>Liter (Liter)</option>
                                        </select>
                                        @error('unit')
                                            <span class="text-xs text-error-text mt-1 block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-xs font-bold text-on-surface mb-1.5" for="input_kategori">Kategori</label>
                                        <select class="w-full h-10 px-3.5 rounded-xl border border-border bg-surface-container-lowest text-sm focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all @error('category_id') border-error-text @enderror" id="input_kategori" name="category_id">
                                            <option value="">Pilih Kategori</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('category_id')
                                            <span class="text-xs text-error-text mt-1 block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-on-surface mb-1.5" for="input_supplier">Supplier</label>
                                        <select class="w-full h-10 px-3.5 rounded-xl border border-border bg-surface-container-lowest text-sm focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all @error('supplier_id') border-error-text @enderror" id="input_supplier" name="supplier_id">
                                            <option value="">Pilih Supplier</option>
                                            @foreach($suppliers as $supplier)
                                                <option value="{{ $supplier->id }}" {{ old('supplier_id', $product->supplier_id) == $supplier->id ? 'selected' : '' }}>{{ $supplier->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('supplier_id')
                                            <span class="text-xs text-error-text mt-1 block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Right: Foto Upload Dropzone (5 cols) -->
                            <div class="md:col-span-5 flex flex-col">
                                <label class="block text-xs font-bold text-on-surface mb-1.5">Foto Produk</label>
                                <div id="dropzone" class="flex-1 border-2 border-dashed border-border hover:border-primary rounded-xl p-5 text-center cursor-pointer transition-all bg-canvas/30 hover:bg-primary/5 flex flex-col items-center justify-center min-h-[210px] group relative">
                                    <input type="file" id="input_image" name="image" accept="image/*" class="hidden" />
                                    
                                    <div id="dropzone_prompt" class="{{ $product->image ? 'hidden' : '' }} space-y-2">
                                        <div class="w-12 h-12 rounded-xl bg-primary/10 text-primary flex items-center justify-center mx-auto group-hover:scale-110 transition-transform">
                                            <span class="material-symbols-outlined text-2xl">add_a_photo</span>
                                        </div>
                                        <div>
                                            <p class="text-xs font-bold text-on-surface">Ganti Foto Produk</p>
                                            <p class="text-[11px] text-on-surface-variant mt-0.5">Tarik & lepas file atau <span class="text-primary font-semibold">Pilih File</span></p>
                                            <p class="text-[10px] text-outline mt-1">PNG, JPG, WEBP (Maks 2MB)</p>
                                        </div>
                                    </div>

                                    <!-- Uploaded Thumbnail Box -->
                                    <div id="dropzone_preview" class="{{ $product->image ? '' : 'hidden' }} w-full space-y-3">
                                        <div class="relative aspect-video w-full rounded-lg overflow-hidden border border-border bg-white shadow-xs">
                                            <img id="upload_thumb" src="{{ $product->image ? asset('storage/' . $product->image) : '' }}" alt="Thumbnail" class="w-full h-full object-cover" />
                                        </div>
                                        <div class="flex items-center justify-between text-left px-1">
                                            <div class="truncate max-w-[130px]">
                                                <p id="upload_filename" class="text-xs font-bold text-on-surface truncate">{{ $product->image ? basename($product->image) : 'foto-produk.jpg' }}</p>
                                                <p id="upload_filesize" class="text-[10px] text-on-surface-variant">Foto Saat Ini</p>
                                            </div>
                                            <button type="button" id="btn_remove_image" class="px-2.5 py-1 bg-error-bg text-error-text hover:bg-error-text hover:text-white rounded-lg text-xs font-bold transition-colors flex items-center gap-1">
                                                <span class="material-symbols-outlined text-sm">delete</span>
                                                <span>Ganti</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                @error('image')
                                    <span class="text-xs text-error-text mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Full Width: Deskripsi Produk -->
                            <div class="md:col-span-12 pt-2">
                                <label class="block text-xs font-bold text-on-surface mb-1.5" for="input_deskripsi">Deskripsi Produk</label>
                                <textarea class="w-full rounded-xl border border-border p-3.5 bg-surface-container-lowest text-sm focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all @error('description') border-error-text @enderror" id="input_deskripsi" name="description" placeholder="Tuliskan detail deskripsi barang, spesifikasi material, garansi, atau catatan penting..." rows="3">{{ old('description', $product->description) }}</textarea>
                                @error('description')
                                    <span class="text-xs text-error-text mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </section>

                    <!-- Section 2: Harga & Manajemen Stok -->
                    <section class="bg-white rounded-2xl p-6 md:p-8 border border-border shadow-xs space-y-6">
                        <div class="flex items-center justify-between pb-4 border-b border-border">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                                    <span class="material-symbols-outlined">payments</span>
                                </div>
                                <div>
                                    <h3 class="text-base font-bold text-on-surface">Harga & Inventaris Stok</h3>
                                    <p class="text-xs text-on-surface-variant">Penetapan harga beli, harga jual, dan batas aman stok.</p>
                                </div>
                            </div>
                            <span class="text-[11px] font-bold px-2.5 py-1 bg-surface-container-low text-secondary rounded-full uppercase">Harga & Stok</span>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-xs font-bold text-on-surface mb-1.5" for="input_harga_beli">Harga Beli (Modal)</label>
                                <div class="relative">
                                    <span class="absolute left-3.5 top-2.5 text-xs font-bold text-on-surface-variant">Rp</span>
                                    <input class="w-full h-10 pl-10 pr-3.5 rounded-xl border border-border bg-surface-container-lowest text-sm focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all @error('purchase_price') border-error-text @enderror" id="input_harga_beli" name="purchase_price" value="{{ old('purchase_price', (int)$product->purchase_price) }}" placeholder="0" type="number" min="0" />
                                </div>
                                @error('purchase_price')
                                    <span class="text-xs text-error-text mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-on-surface mb-1.5" for="input_harga">
                                    Harga Jual <span class="text-error-text">*</span>
                                </label>
                                <div class="relative">
                                    <span class="absolute left-3.5 top-2.5 text-xs font-bold text-on-surface-variant">Rp</span>
                                    <input class="w-full h-10 pl-10 pr-3.5 rounded-xl border border-border bg-surface-container-lowest text-sm font-semibold text-primary focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all @error('selling_price') border-error-text @enderror" id="input_harga" name="selling_price" value="{{ old('selling_price', (int)$product->selling_price) }}" placeholder="0" type="number" min="0" required />
                                </div>
                                @error('selling_price')
                                    <span class="text-xs text-error-text mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-on-surface mb-1.5" for="input_stok">
                                    Stok Saat Ini <span class="text-error-text">*</span>
                                </label>
                                <input class="w-full h-10 px-3.5 rounded-xl border border-border bg-surface-container-lowest text-sm focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all @error('stock') border-error-text @enderror" id="input_stok" name="stock" value="{{ old('stock', $product->stock) }}" placeholder="0" type="number" min="0" required />
                                @error('stock')
                                    <span class="text-xs text-error-text mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-on-surface mb-1.5" for="input_min_stok">Minimum Stok (Safety Stock)</label>
                                <input class="w-full h-10 px-3.5 rounded-xl border border-border bg-surface-container-lowest text-sm focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all @error('min_stock') border-error-text @enderror" id="input_min_stok" name="min_stock" value="{{ old('min_stock', $product->min_stock) }}" placeholder="10" type="number" min="0" />
                                <p class="text-[10px] text-on-surface-variant mt-1 italic">Notifikasi otomatis aktif jika stok menyentuh angka ini.</p>
                                @error('min_stock')
                                    <span class="text-xs text-error-text mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </section>
                </div>

                <!-- Right Side: Live Card Preview & Guides (4 cols) -->
                <div class="lg:col-span-4 space-y-6">
                    
                    <!-- Product Preview Card -->
                    <div class="bg-white rounded-2xl border border-border shadow-sm overflow-hidden">
                        <div class="bg-surface-container-low px-5 py-3.5 border-b border-border flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-primary text-base">visibility</span>
                                <h4 class="font-bold text-xs text-on-surface uppercase tracking-wider">Pratinjau Kartu Produk</h4>
                            </div>
                            <span class="text-[10px] uppercase font-bold bg-primary text-white px-2 py-0.5 rounded-full tracking-wider">Live</span>
                        </div>
                        <div class="p-6">
                            <!-- Image Display Container -->
                            <div class="w-full aspect-square rounded-xl bg-canvas mb-5 overflow-hidden flex items-center justify-center relative group border border-border/80 shadow-inner">
                                <img id="preview_image" class="w-full h-full object-cover transition-all duration-300" alt="Product Photograph" src="{{ $product->image ? asset('storage/' . $product->image) : 'https://lh3.googleusercontent.com/aida-public/AB6AXuBRXEXlJ6NHGD7AkGRt1t2dYxz11_J4H14mboxXFgRluSM0joql2WyLLF8LLUAhcGvmP5qJSHKv3-jHHj_UBTB4bZPcvaH3SLly_qNpDSvjQQPuLMlDqysrLHealKDCKCNAiVfGxMWW9KE00lm9uebh7cZliFoNoTXGn7bCNS6L7LvPdxTBZcM_zbkFHV6xUCrQyhY99n7jKGr7Tqtmim_dfQes-UaoUQ5KsGAtHLVfVJ59N7kep8mE' }}"/>
                                <div class="absolute inset-0 bg-black/5 group-hover:bg-transparent transition-colors"></div>
                            </div>
                            
                            <div class="space-y-4">
                                <div>
                                    <span class="px-2.5 py-1 bg-primary/10 text-primary text-[10px] font-extrabold rounded-md uppercase tracking-wider inline-block" id="preview_kategori">
                                        {{ $product->category->name ?? 'Kategori' }}
                                    </span>
                                    <h5 class="text-lg font-bold mt-2 text-on-surface line-clamp-2 leading-snug" id="preview_nama">{{ $product->name }}</h5>
                                </div>
                                
                                <div class="flex items-end justify-between border-t border-border pt-4">
                                    <div>
                                        <p class="text-[10px] text-on-surface-variant font-bold uppercase tracking-wider">Harga Jual</p>
                                        <p class="text-xl font-extrabold text-primary" id="preview_harga">Rp {{ number_format($product->selling_price, 0, ',', '.') }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-[10px] text-on-surface-variant font-bold uppercase tracking-wider mb-0.5">Status Stok</p>
                                        @if($product->stock <= 0)
                                            <span class="text-xs font-bold text-error-text" id="preview_stok_status">Belum Ada Stok</span>
                                        @else
                                            <span class="text-xs font-bold text-emerald-600" id="preview_stok_status">{{ $product->stock }} Pcs Tersedia</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Petunjuk Pengisian Card -->
                    <div class="bg-surface-container-low/70 rounded-2xl p-6 border border-border space-y-3">
                        <div class="flex items-center gap-2 text-primary font-bold text-xs uppercase tracking-wider">
                            <span class="material-symbols-outlined text-base">lightbulb</span>
                            <span>Tips Kelengkapan Data</span>
                        </div>
                        <ul class="space-y-3 text-xs text-on-surface-variant leading-relaxed">
                            <li class="flex items-start gap-2.5">
                                <span class="w-1.5 h-1.5 rounded-full bg-primary shrink-0 mt-1.5"></span>
                                <span><strong class="text-on-surface">Perubahan Foto:</strong> Mengunggah foto baru secara otomatis akan menggantikan foto produk lama.</span>
                            </li>
                            <li class="flex items-start gap-2.5">
                                <span class="w-1.5 h-1.5 rounded-full bg-primary shrink-0 mt-1.5"></span>
                                <span><strong class="text-on-surface">Perubahan SKU:</strong> Pastikan kode SKU yang diperbarui tidak bentrok dengan barang lain.</span>
                            </li>
                        </ul>
                    </div>

                </div>
            </div>
        </form>
    </div>

    <!-- Live Preview & Image Dropzone Controller JS -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const initialImage = "{{ $product->image ? asset('storage/' . $product->image) : 'https://lh3.googleusercontent.com/aida-public/AB6AXuBRXEXlJ6NHGD7AkGRt1t2dYxz11_J4H14mboxXFgRluSM0joql2WyLLF8LLUAhcGvmP5qJSHKv3-jHHj_UBTB4bZPcvaH3SLly_qNpDSvjQQPuLMlDqysrLHealKDCKCNAiVfGxMWW9KE00lm9uebh7cZliFoNoTXGn7bCNS6L7LvPdxTBZcM_zbkFHV6xUCrQyhY99n7jKGr7Tqtmim_dfQes-UaoUQ5KsGAtHLVfVJ59N7kep8mE' }}";

            const inputNama = document.getElementById('input_nama');
            const inputKategori = document.getElementById('input_kategori');
            const inputHarga = document.getElementById('input_harga');
            const inputStok = document.getElementById('input_stok');
            const inputImage = document.getElementById('input_image');
            const dropzone = document.getElementById('dropzone');
            const dropzonePrompt = document.getElementById('dropzone_prompt');
            const dropzonePreview = document.getElementById('dropzone_preview');
            const uploadThumb = document.getElementById('upload_thumb');
            const uploadFilename = document.getElementById('upload_filename');
            const uploadFilesize = document.getElementById('upload_filesize');
            const btnRemoveImage = document.getElementById('btn_remove_image');
            
            const previewNama = document.getElementById('preview_nama');
            const previewKategori = document.getElementById('preview_kategori');
            const previewHarga = document.getElementById('preview_harga');
            const previewStokStatus = document.getElementById('preview_stok_status');
            const previewImage = document.getElementById('preview_image');

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

            const handleFileSelected = (file) => {
                if (!file) return;

                const objectUrl = URL.createObjectURL(file);
                uploadThumb.src = objectUrl;
                previewImage.src = objectUrl;
                uploadFilename.textContent = file.name;
                uploadFilesize.textContent = (file.size / 1024).toFixed(1) + ' KB';

                dropzonePrompt.classList.add('hidden');
                dropzonePreview.classList.remove('hidden');
            };

            const clearFile = () => {
                inputImage.value = '';
                uploadThumb.src = initialImage;
                previewImage.src = initialImage;
                dropzonePrompt.classList.remove('hidden');
                dropzonePreview.classList.add('hidden');
            };

            // Event Listeners
            dropzone.addEventListener('click', (e) => {
                if (!e.target.closest('#btn_remove_image')) {
                    inputImage.click();
                }
            });

            inputImage.addEventListener('change', (e) => {
                if (e.target.files && e.target.files[0]) {
                    handleFileSelected(e.target.files[0]);
                }
            });

            btnRemoveImage.addEventListener('click', (e) => {
                e.stopPropagation();
                inputImage.click();
            });

            // Drag and Drop
            ['dragenter', 'dragover'].forEach(eventName => {
                dropzone.addEventListener(eventName, (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    dropzone.classList.add('border-primary', 'bg-primary/5');
                });
            });

            ['dragleave', 'drop'].forEach(eventName => {
                dropzone.addEventListener(eventName, (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    dropzone.classList.remove('border-primary', 'bg-primary/5');
                });
            });

            dropzone.addEventListener('drop', (e) => {
                const dt = e.dataTransfer;
                if (dt.files && dt.files[0]) {
                    inputImage.files = dt.files;
                    handleFileSelected(dt.files[0]);
                }
            });

            if (inputNama) inputNama.addEventListener('input', updatePreview);
            if (inputKategori) inputKategori.addEventListener('change', updatePreview);
            if (inputHarga) inputHarga.addEventListener('input', updatePreview);
            if (inputStok) inputStok.addEventListener('input', updatePreview);

            // Initial trigger
            updatePreview();
        });
    </script>
</x-layouts.app>
