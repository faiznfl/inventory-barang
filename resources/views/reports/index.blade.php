<x-layouts.app title="Laporan & Ekspor Data - Fixoria Sales">
    <div class="p-8 space-y-8">
        <!-- Top App Bar Content -->
        <header class="flex justify-between items-center">
            <div>
                <h1 class="font-display-lg text-display-lg text-on-surface mb-1">Laporan & Ekspor Data</h1>
                <p class="text-on-surface-variant font-body-md text-body-md">Pantau rekapitulasi mutasi stok dan unduh laporan dalam berbagai format.</p>
            </div>
            <div class="flex items-center gap-3">
                <button class="w-10 h-10 flex items-center justify-center rounded-full hover:bg-surface-container transition-colors text-on-surface-variant" type="button">
                    <span class="material-symbols-outlined">help_outline</span>
                </button>
                <button class="w-10 h-10 flex items-center justify-center rounded-full hover:bg-surface-container transition-colors text-on-surface-variant" type="button">
                    <span class="material-symbols-outlined">notifications</span>
                </button>
            </div>
        </header>

        <!-- Report Filter Panel -->
        <section class="surface-card rounded-xl p-6 border border-border">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                <!-- Filters -->
                <div class="lg:col-span-8 flex flex-wrap gap-4 items-end">
                    <div class="w-full sm:w-auto min-w-[280px]">
                        <label class="block text-label-sm font-label-sm text-on-surface-variant mb-2">Rentang Tanggal</label>
                        <div class="relative">
                            <input class="w-full h-10 pl-10 pr-4 rounded-lg border border-border bg-background focus:ring-2 focus:ring-primary focus:border-transparent text-sm cursor-pointer outline-none" readonly type="text" value="{{ date('01 M Y') }} - {{ date('t M Y') }}">
                            <span class="material-symbols-outlined absolute left-3 top-2 text-outline text-[20px]">calendar_today</span>
                        </div>
                    </div>
                    <div class="w-full sm:w-auto min-w-[180px]">
                        <label class="block text-label-sm font-label-sm text-on-surface-variant mb-2">Jenis Mutasi</label>
                        <select class="w-full h-10 px-4 rounded-lg border border-border bg-background focus:ring-2 focus:ring-primary focus:border-transparent text-sm outline-none">
                            <option value="">Semua</option>
                            <option value="in">Barang Masuk</option>
                            <option value="out">Barang Keluar</option>
                        </select>
                    </div>
                    <div class="w-full sm:w-auto min-w-[180px]">
                        <label class="block text-label-sm font-label-sm text-on-surface-variant mb-2">Kategori</label>
                        <select class="w-full h-10 px-4 rounded-lg border border-border bg-background focus:ring-2 focus:ring-primary focus:border-transparent text-sm outline-none">
                            <option value="">Semua Kategori</option>
                            @foreach($categories ?? [] as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button class="h-10 px-6 bg-primary text-white rounded-lg font-body-md text-body-md hover:bg-surface-tint transition-all flex items-center gap-2 shadow-sm" type="button">
                        <span class="material-symbols-outlined text-[18px]">filter_list</span>
                        Filter
                    </button>
                </div>
                <!-- Export Actions -->
                <div class="lg:col-span-4 flex justify-end items-end gap-3">
                    <button class="export-btn h-10 px-4 border border-border rounded-lg font-body-md text-body-md text-on-surface hover:bg-surface-container-low transition-colors flex items-center gap-2 group" type="button">
                        <span class="material-symbols-outlined text-error group-hover:scale-110 transition-transform">picture_as_pdf</span>
                        Ekspor PDF
                    </button>
                    <button class="export-btn h-10 px-4 border border-border rounded-lg font-body-md text-body-md text-on-surface hover:bg-surface-container-low transition-colors flex items-center gap-2 group" type="button">
                        <span class="material-symbols-outlined text-tertiary group-hover:scale-110 transition-transform">description</span>
                        CSV / Excel
                    </button>
                </div>
            </div>
        </section>

        <!-- Report Preview Table -->
        <section class="surface-card rounded-xl border border-border overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-surface-container-low border-b border-border">
                            <th class="px-6 py-4 font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Tanggal</th>
                            <th class="px-6 py-4 font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">SKU</th>
                            <th class="px-6 py-4 font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Nama Barang</th>
                            <th class="px-6 py-4 font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Kategori</th>
                            <th class="px-6 py-4 font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Jenis Transaksi</th>
                            <th class="px-6 py-4 font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider text-right">Qty</th>
                            <th class="px-6 py-4 font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">User Input</th>
                            <th class="px-6 py-4 font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border">
                        @forelse($reports ?? [] as $report)
                            <tr class="hover:bg-canvas transition-colors">
                                <td class="px-6 py-4 text-sm whitespace-nowrap">{{ $report->created_at ? $report->created_at->format('d M Y') : '-' }}</td>
                                <td class="px-6 py-4 text-sm font-semibold whitespace-nowrap">{{ $report->product->sku ?? '-' }}</td>
                                <td class="px-6 py-4 text-sm font-medium">{{ $report->product->name ?? '-' }}</td>
                                <td class="px-6 py-4 text-sm text-on-surface-variant">{{ $report->product->category->name ?? '-' }}</td>
                                <td class="px-6 py-4 text-sm">
                                    @if(($report->type ?? '') === 'in')
                                        <span class="px-2 py-1 bg-green-100 text-green-700 text-[11px] font-bold rounded uppercase flex items-center gap-1 w-fit">
                                            <span class="material-symbols-outlined text-[14px]">arrow_downward</span> Masuk
                                        </span>
                                    @else
                                        <span class="px-2 py-1 bg-red-100 text-red-700 text-[11px] font-bold rounded uppercase flex items-center gap-1 w-fit">
                                            <span class="material-symbols-outlined text-[14px]">arrow_upward</span> Keluar
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-right font-bold">{{ $report->qty ?? 0 }}</td>
                                <td class="px-6 py-4 text-sm">{{ $report->user->name ?? '-' }}</td>
                                <td class="px-6 py-4 text-sm text-on-surface-variant">{{ $report->notes ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td class="px-6 py-16 text-center text-on-surface-variant" colspan="8">
                                    <div class="flex flex-col items-center justify-center max-w-sm mx-auto space-y-3">
                                        <div class="w-16 h-16 rounded-full bg-surface-container-low flex items-center justify-center text-outline">
                                            <span class="material-symbols-outlined text-3xl">assessment</span>
                                        </div>
                                        <div>
                                            <h3 class="font-bold text-on-surface text-base">Belum Ada Data Laporan</h3>
                                            <p class="text-xs text-on-surface-variant mt-1">Belum ada rekaman laporan transaksi mutasi stok untuk rentang filter ini.</p>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr class="bg-surface-container-high border-t border-border">
                            <td class="px-6 py-4" colspan="5">
                                <div class="flex gap-8">
                                    <div class="flex items-center gap-2">
                                        <span class="text-on-surface-variant text-sm">Total Barang Masuk:</span>
                                        <span class="text-sm font-extrabold text-primary">{{ number_format($totalInQty ?? 0) }}</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span class="text-on-surface-variant text-sm">Total Barang Keluar:</span>
                                        <span class="text-sm font-extrabold text-error-text">{{ number_format($totalOutQty ?? 0) }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-right" colspan="3">
                                <span class="text-on-surface-variant text-xs">Menampilkan {{ isset($reports) && method_exists($reports, 'count') ? $reports->count() : 0 }} entri</span>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </section>

        <!-- Pagination -->
        <div class="mt-6 flex justify-between items-center">
            <p class="text-sm text-on-surface-variant">Hal 1 dari 1</p>
            <div class="flex gap-2">
                <button class="w-8 h-8 rounded border border-border flex items-center justify-center hover:bg-surface-container transition-colors disabled:opacity-40" disabled type="button">
                    <span class="material-symbols-outlined text-[18px]">chevron_left</span>
                </button>
                <button class="w-8 h-8 rounded border-none bg-primary text-white flex items-center justify-center font-bold text-xs" type="button">1</button>
                <button class="w-8 h-8 rounded border border-border flex items-center justify-center hover:bg-surface-container transition-colors disabled:opacity-40" disabled type="button">
                    <span class="material-symbols-outlined text-[18px]">chevron_right</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Export Micro-interaction Script -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const exportButtons = document.querySelectorAll('.export-btn');
            exportButtons.forEach(btn => {
                btn.addEventListener('click', () => {
                    const originalText = btn.innerHTML;
                    btn.innerHTML = '<span class="material-symbols-outlined animate-spin">sync</span> Memproses...';
                    btn.classList.add('opacity-70', 'pointer-events-none');
                    setTimeout(() => {
                        btn.innerHTML = originalText;
                        btn.classList.remove('opacity-70', 'pointer-events-none');
                    }, 1500);
                });
            });
        });
    </script>
</x-layouts.app>
