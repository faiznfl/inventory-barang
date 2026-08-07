<x-layouts.app title="Fixoria Sales - Analytics Dashboard">
    <!-- Dashboard Content -->
    <div class="p-4 sm:p-6 lg:p-8 space-y-6 sm:space-y-8">
        <!-- Header Section -->
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4">
            <div>
                <h2 class="font-display-lg text-xl sm:text-display-lg text-on-surface">Dashboard Overview</h2>
                <p class="text-xs sm:text-sm text-secondary mt-1">Status inventaris terkini per {{ date('d M Y') }}</p>
            </div>
            <div class="flex flex-wrap sm:flex-nowrap gap-2 sm:gap-3 w-full sm:w-auto">
                <a class="bg-white text-on-surface border border-border px-3 sm:px-4 py-2 rounded-lg text-xs sm:text-sm font-semibold hover:bg-surface-container-low transition-all flex items-center justify-center gap-2 flex-1 sm:flex-none" href="{{ route('reports.index') }}">
                    <span class="material-symbols-outlined text-[18px] sm:text-[20px]">download</span> Export Laporan
                </a>
                <a class="bg-primary text-white px-3 sm:px-4 py-2 rounded-lg text-xs sm:text-sm font-semibold hover:opacity-90 transition-all flex items-center justify-center gap-2 shadow-sm flex-1 sm:flex-none" href="{{ route('products.index') }}">
                    <span class="material-symbols-outlined text-[18px] sm:text-[20px]">add</span> Tambah Produk
                </a>
            </div>
        </div>

        <!-- Summary Cards Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
            <!-- Card 1: Total Produk -->
            <div class="surface-card p-5 sm:p-6 flex flex-col justify-between">
                <div class="flex items-center justify-between">
                    <span class="text-secondary font-semibold text-xs sm:text-sm">Total Produk</span>
                    <div class="w-9 h-9 sm:w-10 sm:h-10 bg-primary-container/10 rounded-lg flex items-center justify-center text-primary">
                        <span class="material-symbols-outlined text-xl sm:text-2xl">inventory_2</span>
                    </div>
                </div>
                <div class="mt-4">
                    <h3 class="text-2xl sm:text-3xl font-bold text-on-surface">{{ number_format($totalProducts ?? 0) }}</h3>
                    <p class="text-[11px] sm:text-xs text-secondary mt-1 font-semibold">Total unit terdaftar</p>
                </div>
            </div>

            <!-- Card 2: Total Nilai Inventaris -->
            <div class="surface-card p-5 sm:p-6 flex flex-col justify-between">
                <div class="flex items-center justify-between">
                    <span class="text-secondary font-semibold text-xs sm:text-sm">Total Nilai Inventaris</span>
                    <div class="w-9 h-9 sm:w-10 sm:h-10 bg-tertiary-fixed/40 rounded-lg flex items-center justify-center text-tertiary">
                        <span class="material-symbols-outlined text-xl sm:text-2xl">payments</span>
                    </div>
                </div>
                <div class="mt-4">
                    <h3 class="text-xl sm:text-3xl font-bold text-on-surface truncate">Rp {{ number_format($totalInventoryValue ?? 0, 0, ',', '.') }}</h3>
                    <p class="text-[11px] sm:text-xs text-secondary mt-1 font-semibold">Total aset terdaftar</p>
                </div>
            </div>

            <!-- Card 3: Stok Menipis -->
            <div class="surface-card p-5 sm:p-6 border-l-4 border-l-amber-500">
                <div class="flex items-center justify-between">
                    <span class="text-secondary font-semibold text-xs sm:text-sm">Stok Menipis</span>
                    <div class="w-9 h-9 sm:w-10 sm:h-10 bg-amber-50 rounded-lg flex items-center justify-center text-amber-600">
                        <span class="material-symbols-outlined text-xl sm:text-2xl">warning</span>
                    </div>
                </div>
                <div class="mt-4">
                    <h3 class="text-2xl sm:text-3xl font-bold text-amber-600">{{ number_format($lowStockCount ?? 0) }}</h3>
                    <p class="text-[11px] sm:text-xs text-secondary mt-1 font-semibold">Perlu restock segera</p>
                </div>
            </div>

            <!-- Card 4: Transaksi Hari Ini -->
            <div class="surface-card p-5 sm:p-6">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-secondary font-semibold text-xs sm:text-sm">Transaksi Hari Ini</span>
                    <div class="w-9 h-9 sm:w-10 sm:h-10 bg-surface-container rounded-lg flex items-center justify-center text-secondary">
                        <span class="material-symbols-outlined text-xl sm:text-2xl">history</span>
                    </div>
                </div>
                <div class="space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-xs font-semibold text-secondary">Barang Masuk</span>
                        <span class="text-xs sm:text-sm font-bold text-emerald-600">{{ $todayInCount ?? 0 }} Unit</span>
                    </div>
                    <div class="w-full bg-canvas h-1.5 rounded-full">
                        <div class="bg-emerald-500 h-1.5 rounded-full" style="width: {{ min(100, ($todayInCount ?? 0) * 5) }}%"></div>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-xs font-semibold text-secondary">Barang Keluar</span>
                        <span class="text-xs sm:text-sm font-bold text-primary">{{ $todayOutCount ?? 0 }} Unit</span>
                    </div>
                    <div class="w-full bg-canvas h-1.5 rounded-full">
                        <div class="bg-primary h-1.5 rounded-full" style="width: {{ min(100, ($todayOutCount ?? 0) * 5) }}%"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts & Widget Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 pb-8 sm:pb-12">
            <!-- Stock Trend Chart (2 Columns Wide) -->
            <div class="lg:col-span-2 surface-card p-4 sm:p-6 flex flex-col">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-6 sm:mb-8">
                    <div>
                        <h4 class="font-bold text-base sm:text-lg text-on-surface">Tren Transaksi Mutasi Stok</h4>
                        <p class="text-xs text-secondary">Pergerakan unit masuk vs keluar</p>
                    </div>
                    <select class="text-xs sm:text-sm font-semibold border-border rounded-lg bg-white focus:ring-primary focus:border-primary px-3 py-1.5 outline-none self-start sm:self-auto">
                        <option>7 Hari Terakhir</option>
                        <option>30 Hari Terakhir</option>
                        <option>90 Hari Terakhir</option>
                    </select>
                </div>

                <!-- Visual Representation of Mutasi Stok Chart -->
                <div class="flex-1 relative h-56 sm:h-64 w-full flex items-end gap-1.5 sm:gap-2 px-2 overflow-x-auto">
                    <div class="absolute inset-0 flex flex-col justify-between opacity-5 pointer-events-none">
                        <div class="border-b border-on-surface h-px w-full"></div>
                        <div class="border-b border-on-surface h-px w-full"></div>
                        <div class="border-b border-on-surface h-px w-full"></div>
                        <div class="border-b border-on-surface h-px w-full"></div>
                        <div class="border-b border-on-surface h-px w-full"></div>
                    </div>
                    @forelse($chartDays ?? [] as $day)
                        <div class="flex-1 flex flex-col justify-end items-center gap-1 group min-w-[28px]">
                            <div class="w-full bg-primary/20 rounded-t-sm transition-all group-hover:bg-primary/40" style="height: {{ $day['in_percent'] ?? 0 }}%"></div>
                            <div class="w-full bg-emerald-500/20 rounded-t-sm transition-all group-hover:bg-emerald-500/40" style="height: {{ $day['out_percent'] ?? 0 }}%"></div>
                            <span class="text-[9px] sm:text-[10px] font-bold text-secondary mt-2">{{ $day['name'] }}</span>
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
                <div class="p-4 sm:p-6 border-b border-border">
                    <h4 class="font-bold text-base sm:text-lg text-on-surface">List Produk Stok Menipis</h4>
                    <p class="text-xs text-secondary mt-1">Daftar item di bawah ambang minimum</p>
                </div>
                <div class="flex-1 overflow-x-auto overflow-y-auto max-h-80 lg:max-h-none">
                    <table class="w-full text-left min-w-[320px]">
                        <thead class="sticky top-0 bg-white shadow-sm">
                            <tr class="text-[10px] uppercase tracking-wider text-secondary">
                                <th class="px-4 sm:px-6 py-3 font-bold">Produk & SKU</th>
                                <th class="px-3 sm:px-4 py-3 font-bold text-center">Stok</th>
                                <th class="px-4 sm:px-6 py-3 font-bold text-right">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-border">
                            @forelse($lowStockProducts ?? [] as $product)
                                <tr class="hover:bg-canvas transition-colors">
                                    <td class="px-4 sm:px-6 py-3.5">
                                        <p class="text-xs font-bold text-on-surface truncate max-w-[140px]">{{ $product->name }}</p>
                                        <p class="text-[10px] text-secondary font-mono">{{ $product->sku }}</p>
                                    </td>
                                    <td class="px-3 sm:px-4 py-3.5 text-center">
                                        <span class="text-xs font-bold text-amber-600">{{ $product->stock }}</span>
                                        <span class="text-[10px] text-secondary">/ {{ $product->min_stock }}</span>
                                    </td>
                                    <td class="px-4 sm:px-6 py-3.5 text-right whitespace-nowrap">
                                        @if($product->stock <= 0)
                                            <span class="px-2 py-0.5 bg-error-bg text-error-text text-[10px] font-bold rounded-full border border-error-container uppercase">Critical</span>
                                        @else
                                            <span class="px-2 py-0.5 bg-amber-50 text-amber-600 text-[10px] font-bold rounded-full border border-amber-200 uppercase">Low Stock</span>
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
