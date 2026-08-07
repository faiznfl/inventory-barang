<x-layouts.app title="Manajemen Supplier - Fixoria Sales">
    <div class="p-4 sm:p-6 lg:p-8 space-y-6">
        <!-- Page Header -->
        <header class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h2 class="font-display-lg text-xl sm:text-display-lg text-on-surface">Manajemen Supplier</h2>
                <nav class="flex text-xs text-secondary items-center gap-2 mt-1">
                    <a class="hover:text-primary transition-colors" href="{{ route('dashboard') }}">Dashboard</a>
                    <span class="material-symbols-outlined text-[14px]">chevron_right</span>
                    <span class="text-on-surface font-semibold">Supplier</span>
                </nav>
            </div>
            <a href="{{ route('suppliers.create') }}" class="bg-primary-container hover:bg-primary text-white px-4 sm:px-5 py-2.5 rounded-lg flex items-center justify-center gap-2 transition-all font-body-md text-xs sm:text-sm shadow-sm active:scale-95 shrink-0">
                <span class="material-symbols-outlined text-[18px] sm:text-[20px]">add</span>
                <span>Tambah Supplier</span>
            </a>
        </header>

        @if (session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 p-4 rounded-xl text-sm flex items-center justify-between shadow-xs">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-green-600">check_circle</span>
                    <span>{{ session('success') }}</span>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="text-green-600 hover:text-green-800">
                    <span class="material-symbols-outlined text-sm">close</span>
                </button>
            </div>
        @endif

        <!-- Filter Bar Card -->
        <div class="surface-card rounded-xl p-4 border border-border/50">
            <form method="GET" action="{{ route('suppliers.index') }}" class="flex flex-col sm:flex-row items-center gap-3 w-full grow max-w-2xl">
                <div class="relative w-full sm:grow flex items-center">
                    <span class="material-symbols-outlined absolute left-3 text-outline text-[20px] pointer-events-none">search</span>
                    <input class="w-full h-10 pl-10 pr-4 border border-border rounded-lg text-sm focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all" name="search" value="{{ request('search') }}" placeholder="Cari nama supplier, kontak, email, atau telepon..." type="text">
                </div>
                <div class="flex items-center gap-2 w-full sm:w-auto">
                    <button type="submit" class="h-10 flex-1 sm:flex-none flex items-center justify-center gap-2 px-4 border border-border rounded-lg text-sm font-medium text-on-surface-variant hover:bg-canvas transition-colors shrink-0">
                        <span class="material-symbols-outlined text-[18px]">filter_list</span>
                        Cari
                    </button>
                    @if(request('search'))
                        <a href="{{ route('suppliers.index') }}" class="h-10 flex items-center justify-center px-3 text-xs text-secondary hover:text-primary transition-colors shrink-0">Reset</a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Data Table Card -->
        <div class="surface-card rounded-xl overflow-hidden border border-border/50">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse min-w-[900px]" id="suppliers-table">
                    <thead>
                        <tr class="bg-surface-container-low border-b border-border">
                            <th class="px-6 py-4 w-12 text-center">
                                <input class="rounded border-border text-primary-container focus:ring-primary-container" type="checkbox" id="select-all">
                            </th>
                            <th class="px-6 py-4 font-label-sm text-on-surface-variant uppercase tracking-wider text-xs whitespace-nowrap">Nama Supplier</th>
                            <th class="px-6 py-4 font-label-sm text-on-surface-variant uppercase tracking-wider text-xs whitespace-nowrap">Nama Kontak</th>
                            <th class="px-6 py-4 font-label-sm text-on-surface-variant uppercase tracking-wider text-xs whitespace-nowrap">Telepon / WA</th>
                            <th class="px-6 py-4 font-label-sm text-on-surface-variant uppercase tracking-wider text-xs whitespace-nowrap">Email</th>
                            <th class="px-6 py-4 font-label-sm text-on-surface-variant uppercase tracking-wider text-xs whitespace-nowrap">Alamat</th>
                            <th class="px-6 py-4 font-label-sm text-on-surface-variant uppercase tracking-wider text-xs whitespace-nowrap">Status</th>
                            <th class="px-6 py-4 font-label-sm text-on-surface-variant uppercase tracking-wider text-xs text-center whitespace-nowrap w-28">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border">
                        @forelse($suppliers ?? [] as $supplier)
                            <tr class="hover:bg-canvas transition-colors supplier-row">
                                <td class="px-6 py-4 text-center">
                                    <input class="rounded border-border text-primary-container focus:ring-primary-container row-checkbox" type="checkbox">
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-lg bg-surface-container-high flex items-center justify-center text-primary">
                                            <span class="material-symbols-outlined">corporate_fare</span>
                                        </div>
                                        <span class="font-body-md text-on-surface font-semibold">{{ $supplier->name }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-body-md text-on-surface-variant whitespace-nowrap">{{ $supplier->contact_name ?? '-' }}</td>
                                <td class="px-6 py-4 text-body-md text-on-surface-variant whitespace-nowrap">{{ $supplier->phone ?? '-' }}</td>
                                <td class="px-6 py-4 text-body-md text-on-surface-variant whitespace-nowrap">{{ $supplier->email ?? '-' }}</td>
                                <td class="px-6 py-4 text-body-md text-on-surface-variant max-w-xs truncate" title="{{ $supplier->address }}">{{ $supplier->address ?? '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($supplier->is_active ?? true)
                                        <span class="px-3 py-1 rounded-full text-[12px] font-semibold bg-green-100 text-green-700">Aktif</span>
                                    @else
                                        <span class="px-3 py-1 rounded-full text-[12px] font-semibold bg-gray-100 text-gray-500">Nonaktif</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center whitespace-nowrap">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('suppliers.edit', $supplier) }}" class="p-2 hover:bg-surface-container rounded-lg text-primary transition-colors inline-flex items-center" title="Edit Supplier">
                                            <span class="material-symbols-outlined text-xl">edit</span>
                                        </a>
                                        <form action="{{ route('suppliers.destroy', $supplier) }}" method="POST" class="inline-flex" onsubmit="return confirm('Apakah Anda yakin ingin menghapus supplier ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 hover:bg-error-container rounded-lg text-error transition-colors inline-flex items-center" title="Hapus Supplier">
                                                <span class="material-symbols-outlined text-xl">delete</span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="px-6 py-16 text-center text-on-surface-variant" colspan="8">
                                    <div class="flex flex-col items-center justify-center max-w-sm mx-auto space-y-3">
                                        <div class="w-16 h-16 rounded-full bg-surface-container-low flex items-center justify-center text-outline">
                                            <span class="material-symbols-outlined text-3xl">local_shipping</span>
                                        </div>
                                        <div>
                                            <h3 class="font-bold text-on-surface text-base">Belum Ada Data Supplier</h3>
                                            <p class="text-xs text-on-surface-variant mt-1">Daftar mitra supplier masih kosong. Klik tombol "Tambah Supplier" untuk menambahkan data mitra baru.</p>
                                        </div>
                                        <a href="{{ route('suppliers.create') }}" class="bg-primary-container text-on-primary px-4 py-2 rounded-lg text-xs font-semibold flex items-center gap-1.5 transition-all shadow-sm">
                                            <span class="material-symbols-outlined text-sm">add</span>
                                            Tambah Supplier
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if(isset($suppliers) && method_exists($suppliers, 'links'))
                <div class="px-4 sm:px-6 py-4 border-t border-border bg-surface">
                    {{ $suppliers->links() }}
                </div>
            @endif
        </div>

        <!-- Summary Cards Footer -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
            <div class="surface-card rounded-xl p-5 sm:p-6 flex items-center gap-4 border border-border/50">
                <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-surface-container-high flex items-center justify-center text-primary shrink-0">
                    <span class="material-symbols-outlined text-[24px] sm:text-[28px]">groups</span>
                </div>
                <div>
                    <p class="text-on-surface-variant font-label-sm text-xs">Total Supplier</p>
                    <h3 class="text-xl sm:text-[24px] font-bold text-on-surface">{{ number_format($totalSuppliersCount ?? 0) }}</h3>
                </div>
            </div>
            <div class="surface-card rounded-xl p-5 sm:p-6 flex items-center gap-4 border border-border/50">
                <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-green-50 flex items-center justify-center text-green-600 shrink-0">
                    <span class="material-symbols-outlined text-[24px] sm:text-[28px]">check_circle</span>
                </div>
                <div>
                    <p class="text-on-surface-variant font-label-sm text-xs">Supplier Aktif</p>
                    <h3 class="text-xl sm:text-[24px] font-bold text-on-surface">{{ number_format($activeSuppliersCount ?? 0) }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Micro-interactions Script -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const selectAllHeader = document.getElementById('select-all');
            const rowCheckboxes = document.querySelectorAll('.row-checkbox');

            if (selectAllHeader) {
                selectAllHeader.addEventListener('change', (e) => {
                    rowCheckboxes.forEach(cb => {
                        cb.checked = e.target.checked;
                    });
                });
            }
        });
    </script>
</x-layouts.app>
