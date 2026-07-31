<x-layouts.app title="Transaksi Mutasi Stok - Fixoria Sales">
    <div class="p-8 space-y-8">
        <!-- Header & Title -->
        <div>
            <h2 class="font-display text-3xl font-bold text-on-surface tracking-tight">Transaksi Mutasi Stok</h2>
            <p class="text-on-surface-variant font-body-md mt-1">Kelola pergerakan stok barang masuk dan keluar gudang secara real-time.</p>
        </div>

        <!-- Tab Navigation -->
        <div class="flex border-b border-border gap-8">
            <button class="pb-4 text-sm font-bold border-b-2 border-primary text-primary transition-all focus:outline-none" id="tab-masuk" onclick="switchTab('masuk')" type="button">
                Input Barang Masuk
            </button>
            <button class="pb-4 text-sm font-semibold border-b-2 border-transparent text-on-surface-variant hover:text-on-surface transition-all focus:outline-none" id="tab-keluar" onclick="switchTab('keluar')" type="button">
                Input Barang Keluar
            </button>
            <button class="pb-4 text-sm font-semibold border-b-2 border-transparent text-on-surface-variant hover:text-on-surface transition-all focus:outline-none" id="tab-riwayat" onclick="switchTab('riwayat')" type="button">
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
                        <form class="grid grid-cols-2 gap-6" onsubmit="event.preventDefault();">
                            <div class="flex flex-col gap-1.5">
                                <label class="text-xs font-bold text-on-surface-variant uppercase tracking-wider">Tanggal Transaksi</label>
                                <input class="h-11 px-4 rounded-lg border border-border focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none text-body-md" type="date" value="{{ date('Y-m-d') }}">
                            </div>
                            <div class="flex flex-col gap-1.5">
                                <label class="text-xs font-bold text-on-surface-variant uppercase tracking-wider">No. Referensi / PO <span class="text-error">*</span></label>
                                <input class="h-11 px-4 rounded-lg border border-border focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none text-body-md" placeholder="EXP: PO-2024-001" required type="text">
                            </div>
                            <div class="flex flex-col gap-1.5 col-span-2">
                                <label class="text-xs font-bold text-on-surface-variant uppercase tracking-wider">Cari Produk (SKU / Nama)</label>
                                <div class="relative">
                                    <span class="absolute left-3 top-1/2 -translate-y-1/2 material-symbols-outlined text-outline">search</span>
                                    <input class="w-full h-11 pl-10 pr-4 rounded-lg border border-border focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none text-body-md" placeholder="Masukkan SKU atau Nama Produk..." type="text">
                                </div>
                            </div>
                            <div class="flex flex-col gap-1.5">
                                <label class="text-xs font-bold text-on-surface-variant uppercase tracking-wider">Jumlah (Qty)</label>
                                <input class="h-11 px-4 rounded-lg border border-border focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none text-body-md" min="1" placeholder="0" type="number">
                            </div>
                            <div class="flex flex-col gap-1.5">
                                <label class="text-xs font-bold text-on-surface-variant uppercase tracking-wider">Satuan</label>
                                <select class="h-11 px-4 rounded-lg border border-border focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none text-body-md bg-white">
                                    <option>PCS</option>
                                    <option>Box</option>
                                    <option>Unit</option>
                                </select>
                            </div>
                            <div class="flex flex-col gap-1.5 col-span-2">
                                <label class="text-xs font-bold text-on-surface-variant uppercase tracking-wider">Catatan / Keterangan</label>
                                <textarea class="p-4 rounded-lg border border-border focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none text-body-md resize-none" placeholder="Tambahkan informasi tambahan jika diperlukan..." rows="3"></textarea>
                            </div>
                            <div class="col-span-2 pt-4">
                                <button class="w-full h-12 bg-primary text-white font-bold rounded-lg hover:bg-primary/90 transition-all flex items-center justify-center gap-2 shadow-md" type="submit">
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
                                    <p class="text-sm font-bold text-on-primary-fixed">Pilih produk untuk melihat detail</p>
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="bg-white/50 p-4 rounded-xl border border-white/40">
                                        <p class="text-[10px] text-on-primary-fixed-variant font-bold uppercase">Stok Saat Ini</p>
                                        <p class="text-lg font-bold text-on-primary-fixed">--</p>
                                    </div>
                                    <div class="bg-white/50 p-4 rounded-xl border border-white/40">
                                        <p class="text-[10px] text-on-primary-fixed-variant font-bold uppercase">Estimasi Akhir</p>
                                        <p class="text-lg font-bold text-on-primary-fixed">--</p>
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
                        <form class="grid grid-cols-2 gap-6" onsubmit="event.preventDefault();">
                            <div class="flex flex-col gap-1.5">
                                <label class="text-xs font-bold text-on-surface-variant uppercase tracking-wider">Tanggal Transaksi</label>
                                <input class="h-11 px-4 rounded-lg border border-border focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none text-body-md" type="date" value="{{ date('Y-m-d') }}">
                            </div>
                            <div class="flex flex-col gap-1.5">
                                <label class="text-xs font-bold text-on-surface-variant uppercase tracking-wider">No. Referensi / DO <span class="text-error">*</span></label>
                                <input class="h-11 px-4 rounded-lg border border-border focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none text-body-md" placeholder="EXP: DO-2024-089" required type="text">
                            </div>
                            <div class="flex flex-col gap-1.5 col-span-2">
                                <label class="text-xs font-bold text-on-surface-variant uppercase tracking-wider">Cari Produk (SKU / Nama)</label>
                                <input class="w-full h-11 px-4 rounded-lg border border-border focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none text-body-md" placeholder="Masukkan SKU atau Nama Produk..." type="text">
                            </div>
                            <div class="flex flex-col gap-1.5">
                                <label class="text-xs font-bold text-on-surface-variant uppercase tracking-wider">Jumlah (Qty)</label>
                                <input class="h-11 px-4 rounded-lg border border-border focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none text-body-md" oninput="checkStock(this.value, 0)" placeholder="0" type="number">
                                <p class="text-[10px] font-bold text-error mt-1 flex items-center gap-1 hidden" id="stock-warning">
                                    <span class="material-symbols-outlined text-xs">warning</span>
                                    Stok tidak mencukupi
                                </p>
                            </div>
                            <div class="flex flex-col gap-1.5">
                                <label class="text-xs font-bold text-on-surface-variant uppercase tracking-wider">Keperluan / Tujuan</label>
                                <select class="h-11 px-4 rounded-lg border border-border focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none text-body-md bg-white">
                                    <option>Penjualan Retail</option>
                                    <option>Retur Supplier</option>
                                    <option>Pemakaian Internal</option>
                                    <option>Kerusakan (Writen Off)</option>
                                </select>
                            </div>
                            <div class="flex flex-col gap-1.5 col-span-2">
                                <label class="text-xs font-bold text-on-surface-variant uppercase tracking-wider">Catatan / Keterangan</label>
                                <textarea class="p-4 rounded-lg border border-border focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none text-body-md resize-none" placeholder="Masukkan informasi catatan tujuan mutasi keluar..." rows="3"></textarea>
                            </div>
                            <div class="col-span-2 pt-4">
                                <button class="w-full h-12 bg-primary text-white font-bold rounded-lg hover:bg-primary/90 transition-all flex items-center justify-center gap-2 shadow-md" type="submit">
                                    <span class="material-symbols-outlined">save</span>
                                    Proses Transaksi Keluar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="space-y-6">
                    <div class="surface-card p-6 bg-surface-container-low border border-border">
                        <h4 class="text-on-surface font-bold text-sm mb-4">Visual Check</h4>
                        <div class="bg-white p-4 rounded-xl mb-4 border border-border">
                            <p class="text-[10px] font-bold text-on-surface-variant uppercase">Produk</p>
                            <p class="text-sm font-bold text-on-surface">Pilih produk untuk memeriksa stok</p>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-white p-4 rounded-xl border border-border">
                                <p class="text-[10px] font-bold text-on-surface-variant uppercase">Stok</p>
                                <p class="text-xl font-bold text-on-surface">0</p>
                            </div>
                            <div class="bg-surface-container p-4 rounded-xl border border-border">
                                <p class="text-[10px] font-bold text-on-surface-variant uppercase">Sisa Stok</p>
                                <p class="text-xl font-bold text-on-surface">0</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tab Content 3: Riwayat Mutasi / Log -->
        <div class="tab-content hidden" id="content-riwayat">
            <div class="surface-card overflow-hidden">
                <div class="p-6 border-b border-border flex justify-between items-center bg-white">
                    <div class="flex items-center gap-4">
                        <h3 class="font-bold text-on-surface">Log Aktivitas Mutasi</h3>
                        <div class="flex bg-canvas p-1 rounded-lg">
                            <button class="px-3 py-1 text-xs font-bold bg-white shadow-sm rounded-md text-primary" type="button">Semua</button>
                            <button class="px-3 py-1 text-xs font-semibold text-on-surface-variant hover:text-on-surface" type="button">Hanya IN</button>
                            <button class="px-3 py-1 text-xs font-semibold text-on-surface-variant hover:text-on-surface" type="button">Hanya OUT</button>
                        </div>
                    </div>
                    <button class="flex items-center gap-2 text-xs font-bold text-primary hover:bg-primary-fixed px-3 py-1.5 rounded-lg transition-colors" type="button">
                        <span class="material-symbols-outlined text-sm">download</span>
                        Export CSV
                    </button>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
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
                            @forelse($transactions ?? [] as $transaction)
                                <tr class="hover:bg-canvas transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap text-on-surface-variant">{{ $transaction->created_at ? $transaction->created_at->format('Y-m-d H:i') : '-' }}</td>
                                    <td class="px-6 py-4 font-semibold">{{ $transaction->user->name ?? '-' }}</td>
                                    <td class="px-6 py-4">
                                        @if(($transaction->type ?? '') === 'in')
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-green-100 text-green-700">IN</span>
                                        @else
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-red-100 text-red-700">OUT</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 max-w-[200px] truncate">{{ $transaction->product->name ?? '-' }}</td>
                                    <td class="px-6 py-4 text-center">{{ $transaction->initial_stock ?? 0 }}</td>
                                    <td class="px-6 py-4 text-center font-bold {{ ($transaction->type ?? '') === 'in' ? 'text-green-600' : 'text-red-600' }}">
                                        {{ ($transaction->type ?? '') === 'in' ? '+' : '-' }}{{ $transaction->qty ?? 0 }}
                                    </td>
                                    <td class="px-6 py-4 text-center font-bold">{{ $transaction->final_stock ?? 0 }}</td>
                                    <td class="px-6 py-4 font-mono text-[11px]">{{ $transaction->reference_no ?? '-' }}</td>
                                    <td class="px-6 py-4 text-xs text-on-surface-variant italic">{{ $transaction->notes ?? '-' }}</td>
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
                    <span class="text-xs text-on-surface-variant">
                        Menampilkan <span class="font-semibold text-on-surface">{{ isset($transactions) && method_exists($transactions, 'count') ? $transactions->count() : 0 }}</span> transaksi
                    </span>
                    <div class="flex gap-2">
                        <button class="p-1 text-on-surface-variant hover:bg-canvas rounded-md disabled:opacity-40" disabled type="button">
                            <span class="material-symbols-outlined">chevron_left</span>
                        </button>
                        <button class="px-3 py-1 text-xs font-bold bg-primary text-white rounded-md" type="button">1</button>
                        <button class="p-1 text-on-surface-variant hover:bg-canvas rounded-md disabled:opacity-40" disabled type="button">
                            <span class="material-symbols-outlined">chevron_right</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tab Switching Script -->
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

        function checkStock(value, max) {
            const warning = document.getElementById('stock-warning');
            const val = parseInt(value) || 0;
            if (warning) {
                if (val > max && max > 0) {
                    warning.classList.remove('hidden');
                } else {
                    warning.classList.add('hidden');
                }
            }
        }
    </script>
</x-layouts.app>
