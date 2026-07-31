<x-layouts.app title="Tambah Kategori Baru - Fixoria Sales">
    <div class="p-6 md:p-8 space-y-6 max-w-4xl mx-auto">
        <!-- Header Container -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 bg-white p-6 rounded-2xl border border-border shadow-sm">
            <div>
                <nav class="flex items-center gap-2 text-xs font-semibold text-secondary mb-2">
                    <a href="{{ route('categories.index') }}" class="hover:text-primary transition-colors flex items-center gap-1">
                        <span class="material-symbols-outlined text-sm">category</span>
                        <span>Kategori</span>
                    </a>
                    <span class="material-symbols-outlined text-[14px]">chevron_right</span>
                    <span class="text-on-surface font-bold">Tambah Kategori</span>
                </nav>
                <h2 class="font-display-lg text-display-lg text-on-surface tracking-tight">Tambah Kategori Baru</h2>
                <p class="font-body-md text-sm text-on-surface-variant mt-0.5">Lengkapi formulir di bawah ini untuk membuat pengelompokan kategori produk baru.</p>
            </div>
            <div class="flex items-center gap-3 shrink-0">
                <a href="{{ route('categories.index') }}" class="px-5 py-2.5 bg-white border border-border text-on-surface rounded-xl font-semibold hover:bg-canvas transition-all flex items-center gap-2 text-sm shadow-xs">
                    <span class="material-symbols-outlined text-sm">arrow_back</span>
                    Batal
                </a>
                <button type="submit" form="create-category-form" class="bg-primary hover:bg-primary/90 text-white px-6 py-2.5 rounded-xl font-semibold flex items-center gap-2 shadow-lg shadow-primary/25 transition-all active:scale-95 text-sm">
                    <span class="material-symbols-outlined text-sm">save</span>
                    Simpan Kategori
                </button>
            </div>
        </div>

        @if ($errors->any())
            <div class="bg-error-bg border border-error-text/30 text-error-text p-4 rounded-2xl text-sm shadow-xs">
                <div class="font-bold flex items-center gap-2 mb-1">
                    <span class="material-symbols-outlined text-base">error</span>
                    <span>Terdapat kesalahan pada isian form:</span>
                </div>
                <ul class="list-disc list-inside space-y-0.5 text-xs pl-6">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form Card -->
        <div class="bg-white rounded-2xl p-6 md:p-8 border border-border shadow-xs">
            <form id="create-category-form" action="{{ route('categories.store') }}" method="POST" class="space-y-6">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-on-surface mb-1.5" for="input_nama">
                            Nama Kategori <span class="text-error-text">*</span>
                        </label>
                        <input class="w-full h-11 px-4 rounded-xl border border-border bg-surface-container-lowest text-sm focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all @error('name') border-error-text @enderror" id="input_nama" name="name" value="{{ old('name') }}" placeholder="Contoh: Elektronik, Furniture, Alat Kantor" type="text" required autofocus />
                        @error('name')
                            <span class="text-xs text-error-text mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-on-surface mb-1.5" for="input_deskripsi">Deskripsi Kategori</label>
                        <textarea class="w-full rounded-xl border border-border p-4 bg-surface-container-lowest text-sm focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all @error('description') border-error-text @enderror" id="input_deskripsi" name="description" placeholder="Tuliskan gambaran singkat mengenai kelompok barang dalam kategori ini..." rows="4">{{ old('description') }}</textarea>
                        @error('description')
                            <span class="text-xs text-error-text mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>
