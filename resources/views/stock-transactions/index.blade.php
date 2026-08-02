<x-layouts.app title="Transaksi Mutasi Stok - Fixoria Sales">
    <div class="p-8 space-y-8">
        <!-- Header & Title -->
        <div>
            <h2 class="font-display text-3xl font-bold text-on-surface tracking-tight">Transaksi Mutasi Stok</h2>
            <p class="text-on-surface-variant font-body-md mt-1">Kelola pergerakan stok barang masuk dan keluar gudang secara real-time.</p>
        </div>

        <!-- Flash Messages -->
        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-xl flex items-center gap-3 shadow-sm">
                <span class="material-symbols-outlined text-green-600">check_circle</span>
                <span class="text-sm font-semibold">{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl flex items-center gap-3 shadow-sm">
                <span class="material-symbols-outlined text-red-600">error</span>
                <span class="text-sm font-semibold">{{ session('error') }}</span>
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl shadow-sm">
                <div class="flex items-center gap-2 mb-1">
                    <span class="material-symbols-outlined text-red-600">warning</span>
                    <span class="text-sm font-bold">Terjadi kesalahan validasi:</span>
                </div>
                <ul class="list-disc pl-8 text-xs space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Tab Navigation -->
        <div class="flex border-b border-border gap-8">
            <button class="pb-4 text-sm font-bold border-b-2 border-primary text-primary transition-all focus:outline-none cursor-pointer" id="tab-masuk" onclick="switchTab('masuk')" type="button">
                Input Barang Masuk
            </button>
            <button class="pb-4 text-sm font-semibold border-b-2 border-transparent text-on-surface-variant hover:text-on-surface transition-all focus:outline-none cursor-pointer" id="tab-keluar" onclick="switchTab('keluar')" type="button">
                Input Barang Keluar
            </button>
            <button class="pb-4 text-sm font-semibold border-b-2 border-transparent text-on-surface-variant hover:text-on-surface transition-all focus:outline-none cursor-pointer" id="tab-riwayat" onclick="switchTab('riwayat')" type="button">
                Riwayat Mutasi / Log
            </button>
        </div>

        <!-- Tab Content 1: Barang Masuk -->
        <div class="tab-content transition-all duration-300" id="content-masuk">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Form Section -->
                <div class="lg:col-span-2 space-y-6">
                    <div class="surface-card p-8">
                        <h3 class="font-display text-xl font-bold mb-6 text-on-surface flex items-center gap-2">
                            <span class="material-symbols-outlined text-green-600">add_circle</span>
                            Pencatatan Barang Masuk
                        </h3>
                        <form action="{{ route('stock-transactions.store') }}" method="POST" class="grid grid-cols-2 gap-6">
                            @csrf
                            <input type="hidden" name="type" value="in">

                            <div class="flex flex-col gap-1.5">
                                <label class="text-xs font-bold text-on-surface-variant uppercase tracking-wider">Tanggal Transaksi</label>
                                <input name="transaction_date" class="h-11 px-4 rounded-lg border border-border focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none text-body-md" type="date" value="{{ old('transaction_date', date('Y-m-d')) }}" required>
                            </div>
                            <div class="flex flex-col gap-1.5">
                                <label class="text-xs font-bold text-on-surface-variant uppercase tracking-wider">No. Referensi / PO <span class="text-error">*</span></label>
                                <input name="reference_no" class="h-11 px-4 rounded-lg border border-border focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none text-body-md" placeholder="EXP: PO-2024-001" value="{{ old('reference_no') }}" required type="text">
                            </div>
                            <div class="flex flex-col gap-1.5 col-span-2">
                                <label class="text-xs font-bold text-on-surface-variant uppercase tracking-wider">Pilih Produk (SKU / Nama) <span class="text-error">*</span></label>
                                <select name="product_id" id="product_id_in" onchange="updateInSummary()" required class="w-full h-11 px-4 rounded-lg border border-border focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none text-body-md bg-white">
                                    <option value="">-- Pilih Produk --</option>
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}" data-stock="{{ $product->stock }}" data-unit="{{ $product->unit }}" data-name="{{ $product->name }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                            {{ $product->sku }} - {{ $product->name }} (Stok saat ini: {{ $product->stock }} {{ $product->unit }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="flex flex-col gap-1.5">
                                <label class="text-xs font-bold text-on-surface-variant uppercase tracking-wider">Jumlah (Qty) <span class="text-error">*</span></label>
                                <input name="quantity" id="qty_in" oninput="updateInSummary()" class="h-11 px-4 rounded-lg border border-border focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none text-body-md" min="1" placeholder="0" value="{{ old('quantity') }}" required type="number">
                            </div>
                            <div class="flex flex-col gap-1.5">
                                <label class="text-xs font-bold text-on-surface-variant uppercase tracking-wider">Satuan</label>
                                <input id="unit_in_display" readonly class="h-11 px-4 rounded-lg border border-border bg-canvas text-on-surface-variant outline-none text-body-md" value="PCS">
                            </div>
                            <div class="flex flex-col gap-1.5 col-span-2">
                                <label class="text-xs font-bold text-on-surface-variant uppercase tracking-wider">Catatan / Keterangan</label>
                                <textarea name="notes" class="p-4 rounded-lg border border-border focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none text-body-md resize-none" placeholder="Tambahkan informasi tambahan jika diperlukan..." rows="3">{{ old('notes') }}</textarea>
                            </div>
                            <div class="col-span-2 pt-4">
                                <button class="w-full h-12 bg-primary text-white font-bold rounded-lg hover:bg-primary/90 transition-all flex items-center justify-center gap-2 shadow-md cursor-pointer" type="submit">
                                    <span class="material-symbols-outlined">save</span>
                                    Proses Transaksi Masuk
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Info/Preview Sidebar -->
                <div class="space-y-6">
                    <div class="surface-card p-6 bg-primary-fixed overflow-hidden relative">
                        <div class="relative z-10">
                            <h4 class="text-on-primary-fixed font-bold text-sm mb-4">Ringkasan Produk Terpilih</h4>
                            <div class="space-y-4">
                                <div class="bg-white/50 p-4 rounded-xl border border-white/40">
                                    <p class="text-[10px] text-on-primary-fixed-variant font-bold uppercase">Produk</p>
                                    <p class="text-sm font-bold text-on-primary-fixed" id="in_preview_name">Pilih produk untuk melihat detail</p>
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="bg-white/50 p-4 rounded-xl border border-white/40">
                                        <p class="text-[10px] text-on-primary-fixed-variant font-bold uppercase">Stok Saat Ini</p>
                                        <p class="text-lg font-bold text-on-primary-fixed" id="in_preview_stock">--</p>
                                    </div>
                                    <div class="bg-white/50 p-4 rounded-xl border border-white/40">
                                        <p class="text-[10px] text-on-primary-fixed-variant font-bold uppercase">Estimasi Akhir</p>
                                        <p class="text-lg font-bold text-green-700" id="in_preview_final">--</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="absolute -right-12 -bottom-12 opacity-10">
                            <span class="material-symbols-outlined text-[160px]">inventory_2</span>
                        </div>
                    </div>
                    <div class="surface-card p-6 border-dashed border-2 border-outline-variant bg-canvas/30">
                        <h4 class="font-bold text-sm text-on-surface mb-3">Panduan Singkat</h4>
                        <ul class="text-xs text-on-surface-variant space-y-3 list-disc pl-4">
                            <li>Pastikan <b>No. Referensi</b> sesuai dengan dokumen PO fisik.</li>
                            <li>Mutasi masuk akan secara otomatis menambah jumlah stok master.</li>
                            <li>Log mutasi tidak dapat dihapus demi integritas data audit.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tab Content 2: Barang Keluar -->
        <div class="tab-content hidden" id="content-keluar">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2 space-y-6">
                    <div class="surface-card p-8">
                        <h3 class="font-display text-xl font-bold mb-6 text-on-surface flex items-center gap-2">
                            <span class="material-symbols-outlined text-error">remove_circle</span>
                            Pencatatan Barang Keluar
                        </h3>
                        <form action="{{ route('stock-transactions.store') }}" method="POST" class="grid grid-cols-2 gap-6">
                            @csrf
                            <input type="hidden" name="type" value="out">

                            <div class="flex flex-col gap-1.5">
                                <label class="text-xs font-bold text-on-surface-variant uppercase tracking-wider">Tanggal Transaksi</label>
                                <input name="transaction_date" class="h-11 px-4 rounded-lg border border-border focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none text-body-md" type="date" value="{{ old('transaction_date', date('Y-m-d')) }}" required>
                            </div>
                            <div class="flex flex-col gap-1.5">
                                <label class="text-xs font-bold text-on-surface-variant uppercase tracking-wider">No. Referensi / DO <span class="text-error">*</span></label>
                                <input name="reference_no" class="h-11 px-4 rounded-lg border border-border focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none text-body-md" placeholder="EXP: DO-2024-089" value="{{ old('reference_no') }}" required type="text">
                            </div>
                            <div class="flex flex-col gap-1.5 col-span-2">
                                <label class="text-xs font-bold text-on-surface-variant uppercase tracking-wider">Pilih Produk (SKU / Nama) <span class="text-error">*</span></label>
                                <select name="product_id" id="product_id_out" onchange="updateOutSummary()" required class="w-full h-11 px-4 rounded-lg border border-border focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none text-body-md bg-white">
                                    <option value="">-- Pilih Produk --</option>
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}" data-stock="{{ $product->stock }}" data-unit="{{ $product->unit }}" data-name="{{ $product->name }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                            {{ $product->sku }} - {{ $product->name }} (Stok saat ini: {{ $product->stock }} {{ $product->unit }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="flex flex-col gap-1.5">
                                <label class="text-xs font-bold text-on-surface-variant uppercase tracking-wider">Jumlah (Qty) <span class="text-error">*</span></label>
                                <input name="quantity" id="qty_out" oninput="updateOutSummary()" class="h-11 px-4 rounded-lg border border-border focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none text-body-md" min="1" placeholder="0" value="{{ old('quantity') }}" required type="number">
                                <p class="text-[10px] font-bold text-error mt-1 flex items-center gap-1 hidden" id="stock-warning">
                                    <span class="material-symbols-outlined text-xs">warning</span>
                                    <span id="stock-warning-text">Stok tidak mencukupi</span>
                                </p>
                            </div>
                            <div class="flex flex-col gap-1.5">
                                <label class="text-xs font-bold text-on-surface-variant uppercase tracking-wider">Satuan</label>
                                <input id="unit_out_display" readonly class="h-11 px-4 rounded-lg border border-border bg-canvas text-on-surface-variant outline-none text-body-md" value="PCS">
                            </div>
                            <div class="flex flex-col gap-1.5 col-span-2">
                                <label class="text-xs font-bold text-on-surface-variant uppercase tracking-wider">Catatan / Keterangan</label>
                                <textarea name="notes" class="p-4 rounded-lg border border-border focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none text-body-md resize-none" placeholder="Masukkan informasi catatan tujuan mutasi keluar..." rows="3">{{ old('notes') }}</textarea>
                            </div>
                            <div class="col-span-2 pt-4">
                                <button class="w-full h-12 bg-primary text-white font-bold rounded-lg hover:bg-primary/90 transition-all flex items-center justify-center gap-2 shadow-md cursor-pointer" type="submit">
                                    <span class="material-symbols-outlined">save</span>
                                    Proses Transaksi Keluar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="space-y-6">
                    <div class="surface-card p-6 bg-primary-fixed overflow-hidden relative">
                        <div class="relative z-10">
                            <h4 class="text-on-primary-fixed font-bold text-sm mb-4">Visual Check / Ringkasan Stok</h4>
                            <div class="space-y-4">
                                <div class="bg-white/50 p-4 rounded-xl border border-white/40">
                                    <p class="text-[10px] text-on-primary-fixed-variant font-bold uppercase">Produk</p>
                                    <p class="text-sm font-bold text-on-primary-fixed" id="out_preview_name">Pilih produk untuk memeriksa stok</p>
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="bg-white/50 p-4 rounded-xl border border-white/40">
                                        <p class="text-[10px] text-on-primary-fixed-variant font-bold uppercase">Stok Saat Ini</p>
                                        <p class="text-lg font-bold text-on-primary-fixed" id="out_preview_stock">--</p>
                                    </div>
                                    <div class="bg-white/50 p-4 rounded-xl border border-white/40">
                                        <p class="text-[10px] text-on-primary-fixed-variant font-bold uppercase">Sisa Stok</p>
                                        <p class="text-lg font-bold text-red-700" id="out_preview_remaining">--</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="absolute -right-12 -bottom-12 opacity-10">
                            <span class="material-symbols-outlined text-[160px]">output</span>
                        </div>
                    </div>
                    <div class="surface-card p-6 border-dashed border-2 border-outline-variant bg-canvas/30">
                        <h4 class="font-bold text-sm text-on-surface mb-3">Panduan Singkat</h4>
                        <ul class="text-xs text-on-surface-variant space-y-3 list-disc pl-4">
                            <li>Pastikan <b>No. Referensi</b> sesuai dengan dokumen DO / Penjualan fisik.</li>
                            <li>Jumlah barang keluar tidak boleh melebihi stok yang tersedia saat ini.</li>
                            <li>Mutasi keluar akan secara otomatis mengurangi jumlah stok master barang.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tab Content 3: Riwayat Mutasi / Log -->
        <div class="tab-content hidden" id="content-riwayat">
            <div class="surface-card overflow-hidden">
                <div class="p-6 border-b border-border flex flex-col md:flex-row md:items-center justify-between gap-4 bg-white">
                    <div class="flex items-center gap-4">
                        <h3 class="font-bold text-on-surface">Log Aktivitas Mutasi</h3>
                        <div class="flex bg-canvas p-1 rounded-lg">
                            <a href="{{ route('stock-transactions.index', array_filter(['tab' => 'riwayat', 'search' => request('search')])) }}" class="px-3 py-1 text-xs font-bold rounded-md transition-colors {{ !request('type') ? 'bg-white shadow-sm text-primary' : 'text-on-surface-variant hover:text-on-surface' }}">Semua</a>
                            <a href="{{ route('stock-transactions.index', array_filter(['tab' => 'riwayat', 'type' => 'in', 'search' => request('search')])) }}" class="px-3 py-1 text-xs font-bold rounded-md transition-colors {{ request('type') === 'in' ? 'bg-white shadow-sm text-primary' : 'text-on-surface-variant hover:text-on-surface' }}">Hanya IN</a>
                            <a href="{{ route('stock-transactions.index', array_filter(['tab' => 'riwayat', 'type' => 'out', 'search' => request('search')])) }}" class="px-3 py-1 text-xs font-bold rounded-md transition-colors {{ request('type') === 'out' ? 'bg-white shadow-sm text-primary' : 'text-on-surface-variant hover:text-on-surface' }}">Hanya OUT</a>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <form action="{{ route('stock-transactions.index') }}" method="GET" class="relative">
                            <input type="hidden" name="tab" value="riwayat">
                            @if(request('type'))
                                <input type="hidden" name="type" value="{{ request('type') }}">
                            @endif
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 material-symbols-outlined text-outline text-sm">search</span>
                            <input name="search" value="{{ request('search') }}" placeholder="Cari ref / produk..." class="pl-9 pr-3 py-1.5 text-xs rounded-lg border border-border focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none">
                        </form>
                        <button onclick="exportCSV()" class="flex items-center gap-2 text-xs font-bold text-primary hover:bg-primary-fixed px-3 py-1.5 rounded-lg transition-colors cursor-pointer" type="button">
                            <span class="material-symbols-outlined text-sm">download</span>
                            Export CSV
                        </button>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse" id="transactions-table">
                        <thead>
                            <tr class="bg-canvas/50 text-[10px] uppercase font-bold text-on-surface-variant tracking-wider">
                                <th class="px-6 py-4 border-b border-border">Waktu/Tanggal</th>
                                <th class="px-6 py-4 border-b border-border">Pengguna</th>
                                <th class="px-6 py-4 border-b border-border">Jenis</th>
                                <th class="px-6 py-4 border-b border-border">Produk</th>
                                <th class="px-6 py-4 border-b border-border text-center">Stok Awal</th>
                                <th class="px-6 py-4 border-b border-border text-center">Qty</th>
                                <th class="px-6 py-4 border-b border-border text-center">Stok Akhir</th>
                                <th class="px-6 py-4 border-b border-border">Ref</th>
                                <th class="px-6 py-4 border-b border-border">Catatan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-border text-sm">
                            @forelse($transactions as $transaction)
                                <tr class="hover:bg-canvas transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap text-on-surface-variant">
                                        {{ $transaction->transaction_date ? \Carbon\Carbon::parse($transaction->transaction_date)->format('Y-m-d H:i') : ($transaction->created_at ? $transaction->created_at->format('Y-m-d H:i') : '-') }}
                                    </td>
                                    <td class="px-6 py-4 font-semibold">{{ $transaction->user->name ?? 'System' }}</td>
                                    <td class="px-6 py-4">
                                        @if($transaction->type === 'in')
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-green-100 text-green-700">IN</span>
                                        @else
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-red-100 text-red-700">OUT</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 max-w-[200px] truncate">
                                        <span class="font-bold text-on-surface">{{ $transaction->product->name ?? '-' }}</span>
                                        @if($transaction->product?->sku)
                                            <span class="text-xs text-on-surface-variant block font-mono">{{ $transaction->product->sku }}</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-center font-mono">{{ $transaction->initial_stock }}</td>
                                    <td class="px-6 py-4 text-center font-bold font-mono {{ $transaction->type === 'in' ? 'text-green-600' : 'text-red-600' }}">
                                        {{ $transaction->type === 'in' ? '+' : '-' }}{{ $transaction->quantity }}
                                    </td>
                                    <td class="px-6 py-4 text-center font-bold font-mono">{{ $transaction->final_stock }}</td>
                                    <td class="px-6 py-4 font-mono text-[11px]">{{ $transaction->reference_no }}</td>
                                    <td class="px-6 py-4 text-xs text-on-surface-variant italic max-w-[150px] truncate">{{ $transaction->notes ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="px-6 py-16 text-center text-on-surface-variant" colspan="9">
                                        <div class="flex flex-col items-center justify-center max-w-sm mx-auto space-y-3">
                                            <div class="w-16 h-16 rounded-full bg-surface-container-low flex items-center justify-center text-outline">
                                                <span class="material-symbols-outlined text-3xl">swap_horiz</span>
                                            </div>
                                            <div>
                                                <h3 class="font-bold text-on-surface text-base">Belum Ada Riwayat Mutasi</h3>
                                                <p class="text-xs text-on-surface-variant mt-1">Belum ada catatan aktivitas transaksi barang masuk atau barang keluar gudang.</p>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="px-6 py-4 bg-white border-t border-border flex items-center justify-between">
                    <div class="text-xs text-on-surface-variant">
                        Menampilkan <span class="font-semibold text-on-surface">{{ $transactions->firstItem() ?? 0 }}</span> - <span class="font-semibold text-on-surface">{{ $transactions->lastItem() ?? 0 }}</span> dari <span class="font-semibold text-on-surface">{{ $transactions->total() }}</span> transaksi
                    </div>
                    <div>
                        {{ $transactions->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripting for Tabs, Live Summaries, and CSV Export -->
    <script>
        function switchTab(tabId) {
            document.querySelectorAll('.tab-content').forEach(el => el.classList.add('hidden'));
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

        function updateInSummary() {
            const select = document.getElementById('product_id_in');
            const qtyInput = document.getElementById('qty_in');
            const selectedOpt = select.options[select.selectedIndex];

            const nameElem = document.getElementById('in_preview_name');
            const stockElem = document.getElementById('in_preview_stock');
            const finalElem = document.getElementById('in_preview_final');
            const unitElem = document.getElementById('unit_in_display');

            if (selectedOpt && selectedOpt.value) {
                const stock = parseInt(selectedOpt.getAttribute('data-stock')) || 0;
                const unit = selectedOpt.getAttribute('data-unit') || 'PCS';
                const name = selectedOpt.getAttribute('data-name') || '';
                const qty = parseInt(qtyInput.value) || 0;

                nameElem.textContent = name;
                stockElem.textContent = stock + ' ' + unit;
                finalElem.textContent = (stock + qty) + ' ' + unit;
                if (unitElem) unitElem.value = unit;
            } else {
                nameElem.textContent = 'Pilih produk untuk melihat detail';
                stockElem.textContent = '--';
                finalElem.textContent = '--';
            }
        }

        function updateOutSummary() {
            const select = document.getElementById('product_id_out');
            const qtyInput = document.getElementById('qty_out');
            const selectedOpt = select.options[select.selectedIndex];

            const nameElem = document.getElementById('out_preview_name');
            const stockElem = document.getElementById('out_preview_stock');
            const remainingElem = document.getElementById('out_preview_remaining');
            const unitElem = document.getElementById('unit_out_display');
            const warningElem = document.getElementById('stock-warning');
            const warningText = document.getElementById('stock-warning-text');

            if (selectedOpt && selectedOpt.value) {
                const stock = parseInt(selectedOpt.getAttribute('data-stock')) || 0;
                const unit = selectedOpt.getAttribute('data-unit') || 'PCS';
                const name = selectedOpt.getAttribute('data-name') || '';
                const qty = parseInt(qtyInput.value) || 0;

                nameElem.textContent = name;
                stockElem.textContent = stock + ' ' + unit;
                const remaining = stock - qty;
                remainingElem.textContent = remaining + ' ' + unit;
                if (unitElem) unitElem.value = unit;

                if (warningElem) {
                    if (qty > stock) {
                        warningText.textContent = `Stok tidak mencukupi (Stok: ${stock})`;
                        warningElem.classList.remove('hidden');
                    } else {
                        warningElem.classList.add('hidden');
                    }
                }
            } else {
                nameElem.textContent = 'Pilih produk untuk memeriksa stok';
                stockElem.textContent = '--';
                remainingElem.textContent = '--';
                if (warningElem) warningElem.classList.add('hidden');
            }
        }

        function exportCSV() {
            const table = document.getElementById('transactions-table');
            let csv = [];
            const rows = table.querySelectorAll('tr');

            for (let i = 0; i < rows.length; i++) {
                let row = [], cols = rows[i].querySelectorAll('td, th');
                for (let j = 0; j < cols.length; j++) {
                    let data = cols[j].innerText.replace(/(\r\n|\n|\r)/gm, ' ').replace(/\s+/g, ' ').trim();
                    data = data.replace(/"/g, '""');
                    row.push('"' + data + '"');
                }
                csv.push(row.join(','));
            }

            const csvFile = new Blob([csv.join('\n')], { type: 'text/csv;charset=utf-8;' });
            const downloadLink = document.createElement('a');
            downloadLink.download = 'riwayat-mutasi-stok.csv';
            downloadLink.href = window.URL.createObjectURL(csvFile);
            downloadLink.style.display = 'none';
            document.body.appendChild(downloadLink);
            downloadLink.click();
            document.body.removeChild(downloadLink);
        }

        // Keep active tab on validation reload or query parameter tab/type/page/search
        document.addEventListener('DOMContentLoaded', () => {
            @if(request('tab') === 'riwayat' || request('type') || request('page') || request('search'))
                switchTab('riwayat');
            @elseif(old('type') === 'out')
                switchTab('keluar');
            @elseif(old('type') === 'in')
                switchTab('masuk');
            @else
                switchTab('masuk');
            @endif
        });
    </script>
</x-layouts.app>
