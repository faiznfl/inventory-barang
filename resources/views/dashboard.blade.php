<x-layouts.app title="Fixoria Sales - Analytics Dashboard">
    <!-- Dashboard Content -->
    <div class="p-8 space-y-8">
        <!-- Header Section -->
        <div class="flex items-end justify-between">
            <div>
                <h2 class="font-display-lg text-display-lg text-on-surface">Dashboard Overview</h2>
                <p class="text-secondary mt-1">Status inventaris terkini per {{ date('d M Y') }}</p>
            </div>
            <div class="flex gap-3">
                <a class="bg-white text-on-surface border border-border px-4 py-2 rounded-lg text-sm font-semibold hover:bg-surface-container-low transition-all flex items-center gap-2" href="{{ route('reports.index') }}">
                    <span class="material-symbols-outlined text-[20px]">download</span> Export Laporan
                </a>
                <a class="bg-primary text-white px-4 py-2 rounded-lg text-sm font-semibold hover:opacity-90 transition-all flex items-center gap-2 shadow-sm" href="{{ route('products.index') }}">
                    <span class="material-symbols-outlined text-[20px]">add</span> Tambah Produk
                </a>
            </div>
        </div>

        <!-- Summary Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-grid-gutter">
            <!-- Card 1: Total Produk -->
            <div class="surface-card p-6 flex flex-col justify-between">
                <div class="flex items-center justify-between">
                    <span class="text-secondary font-semibold text-sm">Total Produk</span>
                    <div class="w-10 h-10 bg-primary-container/10 rounded-lg flex items-center justify-center text-primary">
                        <span class="material-symbols-outlined">inventory_2</span>
                    </div>
                </div>
                <div class="mt-4">
                    <h3 class="text-3xl font-bold text-on-surface">{{ number_format($totalProducts ?? 0) }}</h3>
                    <p class="text-xs text-secondary mt-1 font-semibold">Total unit terdaftar</p>
                </div>
            </div>

            <!-- Card 2: Total Nilai Inventaris -->
            <div class="surface-card p-6 flex flex-col justify-between">
                <div class="flex items-center justify-between">
                    <span class="text-secondary font-semibold text-sm">Total Nilai Inventaris</span>
                    <div class="w-10 h-10 bg-tertiary-fixed/40 rounded-lg flex items-center justify-center text-tertiary">
                        <span class="material-symbols-outlined">payments</span>
                    </div>
                </div>
                <div class="mt-4">
                    <h3 class="text-3xl font-bold text-on-surface">Rp {{ number_format($totalInventoryValue ?? 0, 0, ',', '.') }}</h3>
                    <p class="text-xs text-secondary mt-1 font-semibold">Total aset terdaftar</p>
                </div>
            </div>

            <!-- Card 3: Stok Menipis -->
            <div class="surface-card p-6 border-l-4 border-l-amber-500">
                <div class="flex items-center justify-between">
                    <span class="text-secondary font-semibold text-sm">Stok Menipis</span>
                    <div class="w-10 h-10 bg-amber-50 rounded-lg flex items-center justify-center text-amber-600">
                        <span class="material-symbols-outlined">warning</span>
                    </div>
                </div>
                <div class="mt-4">
                    <h3 class="text-3xl font-bold text-amber-600">{{ number_format($lowStockCount ?? 0) }}</h3>
                    <p class="text-xs text-secondary mt-1 font-semibold">Perlu restock segera</p>
                </div>
            </div>

            <!-- Card 4: Transaksi Hari Ini -->
            <div class="surface-card p-6">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-secondary font-semibold text-sm">Transaksi Hari Ini</span>
                    <div class="w-10 h-10 bg-surface-container rounded-lg flex items-center justify-center text-secondary">
                        <span class="material-symbols-outlined">history</span>
                    </div>
                </div>
                <div class="space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-xs font-semibold text-secondary">Barang Masuk</span>
                        <span class="text-sm font-bold text-emerald-600">{{ $todayInCount ?? 0 }} Unit</span>
                    </div>
                    <div class="w-full bg-canvas h-1.5 rounded-full">
                        <div class="bg-emerald-500 h-1.5 rounded-full" style="width: {{ min(100, ($todayInCount ?? 0) * 5) }}%"></div>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-xs font-semibold text-secondary">Barang Keluar</span>
                        <span class="text-sm font-bold text-primary">{{ $todayOutCount ?? 0 }} Unit</span>
                    </div>
                    <div class="w-full bg-canvas h-1.5 rounded-full">
                        <div class="bg-primary h-1.5 rounded-full" style="width: {{ min(100, ($todayOutCount ?? 0) * 5) }}%"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts & Widget Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-grid-gutter pb-12">
            <!-- Stock Trend Chart (2 Columns Wide) -->
            <div class="lg:col-span-2 surface-card p-6 flex flex-col">
                <div class="flex items-center justify-between mb-8">
                    <div>
                        <h4 class="font-bold text-lg text-on-surface">Tren Transaksi Mutasi Stok</h4>
                        <p class="text-xs text-secondary">Pergerakan unit masuk vs keluar</p>
                    </div>
                    <select class="text-sm font-semibold border-border rounded-lg bg-white focus:ring-primary focus:border-primary px-3 py-1.5 outline-none">
                        <option>7 Hari Terakhir</option>
                        <option>30 Hari Terakhir</option>
                        <option>90 Hari Terakhir</option>
                    </select>
                </div>

                <!-- Visual Representation of Mutasi Stok Chart -->
                <div class="flex-1 relative h-64 w-full flex items-end gap-2 px-2">
                    <div class="absolute inset-0 flex flex-col justify-between opacity-5 pointer-events-none">
                        <div class="border-b border-on-surface h-px w-full"></div>
                        <div class="border-b border-on-surface h-px w-full"></div>
                        <div class="border-b border-on-surface h-px w-full"></div>
                        <div class="border-b border-on-surface h-px w-full"></div>
                        <div class="border-b border-on-surface h-px w-full"></div>
                    </div>
                    @forelse($chartDays ?? [] as $day)
                        <div class="flex-1 flex flex-col justify-end items-center gap-1 group">
                            <div class="w-full bg-primary/20 rounded-t-sm transition-all group-hover:bg-primary/40" style="height: {{ $day['in_percent'] ?? 0 }}%"></div>
                            <div class="w-full bg-emerald-500/20 rounded-t-sm transition-all group-hover:bg-emerald-500/40" style="height: {{ $day['out_percent'] ?? 0 }}%"></div>
                            <span class="text-[10px] font-bold text-secondary mt-2">{{ $day['name'] }}</span>
                        </div>
                    @empty
                        <div class="w-full h-full flex flex-col items-center justify-center text-secondary text-xs">
                            <span class="material-symbols-outlined text-3xl mb-1 text-outline">bar_chart</span>
                            <span>Belum ada data tren mutasi stok</span>
                        </div>
                    @endforelse
                </div>

                <div class="mt-6 flex items-center gap-6 justify-center">
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 bg-primary rounded-full"></span>
                        <span class="text-xs font-semibold text-secondary">Barang Masuk</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 bg-emerald-500 rounded-full"></span>
                        <span class="text-xs font-semibold text-secondary">Barang Keluar</span>
                    </div>
                </div>
            </div>

            <!-- Low Stock Widget (1 Column Wide) -->
            <div class="surface-card flex flex-col overflow-hidden">
                <div class="p-6 border-b border-border">
                    <h4 class="font-bold text-lg text-on-surface">List Produk Stok Menipis</h4>
                    <p class="text-xs text-secondary mt-1">Daftar item di bawah ambang minimum</p>
                </div>
                <div class="flex-1 overflow-y-auto">
                    <table class="w-full text-left">
                        <thead class="sticky top-0 bg-white shadow-sm">
                            <tr class="text-[10px] uppercase tracking-wider text-secondary">
                                <th class="px-6 py-3 font-bold">Produk & SKU</th>
                                <th class="px-4 py-3 font-bold text-center">Stok</th>
                                <th class="px-6 py-3 font-bold text-right">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-border">
                            @forelse($lowStockProducts ?? [] as $product)
                                <tr class="hover:bg-canvas transition-colors">
                                    <td class="px-6 py-4">
                                        <p class="text-xs font-bold text-on-surface">{{ $product->name }}</p>
                                        <p class="text-[10px] text-secondary">{{ $product->sku }}</p>
                                    </td>
                                    <td class="px-4 py-4 text-center">
                                        <span class="text-xs font-bold text-amber-600">{{ $product->stock }}</span>
                                        <span class="text-[10px] text-secondary">/ {{ $product->min_stock }}</span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        @if($product->stock <= 0)
                                            <span class="px-2 py-1 bg-error-bg text-error-text text-[10px] font-bold rounded-full border border-error-container uppercase">Critical</span>
                                        @else
                                            <span class="px-2 py-1 bg-amber-50 text-amber-600 text-[10px] font-bold rounded-full border border-amber-200 uppercase">Low Stock</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="px-6 py-12 text-center text-secondary text-xs" colspan="3">
                                        <span class="material-symbols-outlined text-3xl mb-1 text-emerald-500 block">check_circle</span>
                                        <span>Semua stok barang dalam kondisi aman.</span>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="p-4 bg-surface-container-low flex justify-center">
                    <a class="text-primary text-xs font-bold hover:underline flex items-center gap-1" href="{{ route('products.index') }}">
                        Lihat Semua Produk <span class="material-symbols-outlined text-[14px]">arrow_forward</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
