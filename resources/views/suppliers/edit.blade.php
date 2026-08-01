<x-layouts.app title="Edit Supplier - Fixoria Sales">
    <div class="p-6 md:p-8 space-y-6 max-w-7xl mx-auto">
        <!-- Header Container -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 bg-white p-6 rounded-2xl border border-border shadow-sm">
            <div>
                <nav class="flex items-center gap-2 text-xs font-semibold text-secondary mb-2">
                    <a href="{{ route('suppliers.index') }}" class="hover:text-primary transition-colors flex items-center gap-1">
                        <span class="material-symbols-outlined text-sm">local_shipping</span>
                        <span>Supplier</span>
                    </a>
                    <span class="material-symbols-outlined text-[14px]">chevron_right</span>
                    <span class="text-on-surface font-bold">Edit Supplier</span>
                </nav>
                <h2 class="font-display-lg text-display-lg text-on-surface tracking-tight">Edit Data Supplier</h2>
                <p class="font-body-md text-sm text-on-surface-variant mt-0.5">Perbarui rincian identitas dan informasi kontak mitra <strong>{{ $supplier->name }}</strong>.</p>
            </div>
            <div class="flex items-center gap-3 shrink-0">
                <a href="{{ route('suppliers.index') }}" class="px-5 py-2.5 bg-white border border-border text-on-surface rounded-xl font-semibold hover:bg-canvas transition-all flex items-center gap-2 text-sm shadow-xs">
                    <span class="material-symbols-outlined text-sm">arrow_back</span>
                    Batal
                </a>
                <button type="submit" form="edit-supplier-form" class="bg-primary hover:bg-primary/90 text-white px-6 py-2.5 rounded-xl font-semibold flex items-center gap-2 shadow-lg shadow-primary/25 transition-all active:scale-95 text-sm">
                    <span class="material-symbols-outlined text-sm">save</span>
                    Perbarui Supplier
                </button>
            </div>
        </div>

        @if ($errors->any())
            <div class="bg-error-bg border border-error-text/30 text-error-text p-4 rounded-2xl text-sm shadow-xs animate-fade-in">
                <div class="font-bold flex items-center gap-2 mb-1">
                    <span class="material-symbols-outlined text-base">error</span>
                    <span>Terdapat beberapa kesalahan pengisian form:</span>
                </div>
                <ul class="list-disc list-inside space-y-0.5 text-xs pl-6">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form & Live Preview Grid -->
        <form id="edit-supplier-form" action="{{ route('suppliers.update', $supplier) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                <!-- Left Side: Form Inputs (8 cols) -->
                <div class="lg:col-span-8 space-y-6">
                    
                    <!-- Section 1: Identitas Supplier -->
                    <section class="bg-white rounded-2xl p-6 md:p-8 border border-border shadow-xs space-y-6">
                        <div class="flex items-center justify-between pb-4 border-b border-border">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-primary/10 text-primary flex items-center justify-center shrink-0">
                                    <span class="material-symbols-outlined">domain</span>
                                </div>
                                <div>
                                    <h3 class="text-base font-bold text-on-surface">Identitas Supplier</h3>
                                    <p class="text-xs text-on-surface-variant">Nama perusahaan dan penanggung jawab (PIC).</p>
                                </div>
                            </div>
                            <span class="text-[11px] font-bold px-2.5 py-1 bg-surface-container-low text-secondary rounded-full uppercase">Langkah 1</span>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Nama Supplier -->
                            <div class="md:col-span-2">
                                <label class="block text-xs font-bold text-on-surface mb-1.5" for="input_name">
                                    Nama Supplier / Perusahaan <span class="text-error-text">*</span>
                                </label>
                                <div class="relative">
                                    <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-secondary text-lg">corporate_fare</span>
                                    <input class="w-full h-11 pl-10 pr-4 rounded-xl border border-border bg-surface-container-lowest text-sm focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all @error('name') border-error-text @enderror" id="input_name" name="name" value="{{ old('name', $supplier->name) }}" placeholder="Contoh: PT Sumber Makmur Jaya" type="text" required autofocus />
                                </div>
                                @error('name')
                                    <span class="text-xs text-error-text mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Nama Kontak PIC -->
                            <div>
                                <label class="block text-xs font-bold text-on-surface mb-1.5" for="input_contact_name">
                                    Nama Penanggung Jawab (PIC)
                                </label>
                                <div class="relative">
                                    <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-secondary text-lg">person</span>
                                    <input class="w-full h-11 pl-10 pr-4 rounded-xl border border-border bg-surface-container-lowest text-sm focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all @error('contact_name') border-error-text @enderror" id="input_contact_name" name="contact_name" value="{{ old('contact_name', $supplier->contact_name) }}" placeholder="Contoh: Budi Santoso" type="text" />
                                </div>
                                @error('contact_name')
                                    <span class="text-xs text-error-text mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Status Keaktifan -->
                            <div>
                                <label class="block text-xs font-bold text-on-surface mb-1.5">
                                    Status Keaktifan
                                </label>
                                <label class="flex items-center gap-3 h-11 px-4 rounded-xl border border-border bg-surface-container-lowest cursor-pointer hover:bg-canvas transition-colors">
                                    <input type="checkbox" id="input_is_active" name="is_active" value="1" {{ old('is_active', $supplier->is_active) ? 'checked' : '' }} class="w-4 h-4 text-primary rounded border-border focus:ring-primary">
                                    <span class="text-sm font-semibold text-on-surface select-none">Mitra Aktif (Dapat dipilih)</span>
                                </label>
                            </div>
                        </div>
                    </section>

                    <!-- Section 2: Kontak & Alamat -->
                    <section class="bg-white rounded-2xl p-6 md:p-8 border border-border shadow-xs space-y-6">
                        <div class="flex items-center justify-between pb-4 border-b border-border">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-primary/10 text-primary flex items-center justify-center shrink-0">
                                    <span class="material-symbols-outlined">call</span>
                                </div>
                                <div>
                                    <h3 class="text-base font-bold text-on-surface">Kontak & Alamat</h3>
                                    <p class="text-xs text-on-surface-variant">Nomor telepon, email, dan alamat fisik kantor/gudang.</p>
                                </div>
                            </div>
                            <span class="text-[11px] font-bold px-2.5 py-1 bg-surface-container-low text-secondary rounded-full uppercase">Langkah 2</span>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Telepon / WA -->
                            <div>
                                <label class="block text-xs font-bold text-on-surface mb-1.5" for="input_phone">
                                    Nomor Telepon / WhatsApp
                                </label>
                                <div class="relative">
                                    <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-secondary text-lg">phone</span>
                                    <input class="w-full h-11 pl-10 pr-4 rounded-xl border border-border bg-surface-container-lowest text-sm font-mono focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all @error('phone') border-error-text @enderror" id="input_phone" name="phone" value="{{ old('phone', $supplier->phone) }}" placeholder="Contoh: 081234567890" type="text" />
                                </div>
                                @error('phone')
                                    <span class="text-xs text-error-text mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div>
                                <label class="block text-xs font-bold text-on-surface mb-1.5" for="input_email">
                                    Alamat Email Perusahaan
                                </label>
                                <div class="relative">
                                    <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-secondary text-lg">mail</span>
                                    <input class="w-full h-11 pl-10 pr-4 rounded-xl border border-border bg-surface-container-lowest text-sm focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all @error('email') border-error-text @enderror" id="input_email" name="email" value="{{ old('email', $supplier->email) }}" placeholder="Contoh: kontak@sumbermakmur.com" type="email" />
                                </div>
                                @error('email')
                                    <span class="text-xs text-error-text mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Alamat Lengkap -->
                            <div class="md:col-span-2">
                                <label class="block text-xs font-bold text-on-surface mb-1.5" for="input_address">
                                    Alamat Lengkap Kantor / Gudang
                                </label>
                                <div class="relative">
                                    <textarea class="w-full rounded-xl border border-border p-4 bg-surface-container-lowest text-sm focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all @error('address') border-error-text @enderror" id="input_address" name="address" placeholder="Tuliskan alamat lengkap jalan, gedung, kota, dan kode pos..." rows="3">{{ old('address', $supplier->address) }}</textarea>
                                </div>
                                @error('address')
                                    <span class="text-xs text-error-text mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </section>
                </div>

                <!-- Right Side: Live Supplier Preview & Tips (4 cols) -->
                <div class="lg:col-span-4 space-y-6">
                    <!-- Live Supplier Preview Card -->
                    <div class="bg-white rounded-2xl border border-border shadow-sm overflow-hidden sticky top-6">
                        <div class="bg-surface-container-low px-5 py-3.5 border-b border-border flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-primary text-base">visibility</span>
                                <h4 class="font-bold text-xs text-on-surface uppercase tracking-wider">Pratinjau Supplier</h4>
                            </div>
                            <span class="text-[10px] uppercase font-bold bg-primary text-white px-2 py-0.5 rounded-full tracking-wider animate-pulse">Live</span>
                        </div>
                        <div class="p-6 space-y-5">
                            <div class="flex items-center gap-4">
                                <div class="w-14 h-14 rounded-2xl bg-primary/10 text-primary flex items-center justify-center shrink-0 border border-primary/20 shadow-xs">
                                    <span class="material-symbols-outlined text-3xl">corporate_fare</span>
                                </div>
                                <div class="grow min-w-0">
                                    <h5 class="text-base font-bold text-on-surface truncate" id="preview_name">{{ $supplier->name }}</h5>
                                    <p class="text-xs text-secondary truncate flex items-center gap-1 mt-0.5">
                                        <span class="material-symbols-outlined text-sm">person</span>
                                        <span id="preview_contact">PIC: {{ $supplier->contact_name ?: '-' }}</span>
                                    </p>
                                </div>
                            </div>

                            <div class="border-t border-border pt-4 space-y-3">
                                <div class="flex items-center justify-between text-xs">
                                    <span class="text-secondary flex items-center gap-1.5">
                                        <span class="material-symbols-outlined text-base">call</span>
                                        Telepon / WA
                                    </span>
                                    <span class="font-mono font-semibold text-on-surface" id="preview_phone">{{ $supplier->phone ?: '-' }}</span>
                                </div>

                                <div class="flex items-center justify-between text-xs">
                                    <span class="text-secondary flex items-center gap-1.5">
                                        <span class="material-symbols-outlined text-base">mail</span>
                                        Email
                                    </span>
                                    <span class="font-semibold text-on-surface truncate max-w-[150px]" id="preview_email">{{ $supplier->email ?: '-' }}</span>
                                </div>

                                <div class="border-t border-border/60 pt-3">
                                    <span class="text-xs text-secondary flex items-center gap-1.5 mb-1">
                                        <span class="material-symbols-outlined text-base">location_on</span>
                                        Alamat Kantor
                                    </span>
                                    <p class="text-xs text-on-surface line-clamp-2 leading-relaxed" id="preview_address">{{ $supplier->address ?: 'Belum diisi' }}</p>
                                </div>
                            </div>

                            <div class="border-t border-border pt-4 flex items-center justify-between">
                                <span class="text-xs text-secondary font-semibold">Status Kemitraan</span>
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold {{ $supplier->is_active ? 'bg-emerald-100/70 text-emerald-800 border border-emerald-200' : 'bg-gray-100 text-gray-600 border border-gray-200' }}" id="preview_status_container">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $supplier->is_active ? 'bg-emerald-600' : 'bg-gray-400' }}" id="preview_status_dot"></span>
                                    <span id="preview_status_text">{{ $supplier->is_active ? 'Aktif' : 'Nonaktif' }}</span>
                                </span>
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
                                <span><strong class="text-on-surface">Nomor WhatsApp:</strong> Gunakan nomor aktif (contoh 0812...) agar tombol kontak langsung terhubung.</span>
                            </li>
                            <li class="flex items-start gap-2.5">
                                <span class="w-1.5 h-1.5 rounded-full bg-primary shrink-0 mt-1.5"></span>
                                <span><strong class="text-on-surface">Nama PIC:</strong> Cantumkan penanggung jawab operasional untuk memudahkan proses restok barang.</span>
                            </li>
                            <li class="flex items-start gap-2.5">
                                <span class="w-1.5 h-1.5 rounded-full bg-primary shrink-0 mt-1.5"></span>
                                <span><strong class="text-on-surface">Alamat Lengkap:</strong> Tuliskan alamat gudang/kantor pengiriman barang dengan akurat.</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Live Preview Script -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const inputName = document.getElementById('input_name');
            const inputContactName = document.getElementById('input_contact_name');
            const inputPhone = document.getElementById('input_phone');
            const inputEmail = document.getElementById('input_email');
            const inputAddress = document.getElementById('input_address');
            const inputIsActive = document.getElementById('input_is_active');

            const previewName = document.getElementById('preview_name');
            const previewContact = document.getElementById('preview_contact');
            const previewPhone = document.getElementById('preview_phone');
            const previewEmail = document.getElementById('preview_email');
            const previewAddress = document.getElementById('preview_address');
            const previewStatusContainer = document.getElementById('preview_status_container');
            const previewStatusDot = document.getElementById('preview_status_dot');
            const previewStatusText = document.getElementById('preview_status_text');

            const updatePreview = () => {
                if (inputName && previewName) {
                    previewName.textContent = inputName.value.trim() || 'Nama Supplier Baru';
                }

                if (inputContactName && previewContact) {
                    previewContact.textContent = inputContactName.value.trim() ? `PIC: ${inputContactName.value.trim()}` : 'PIC: -';
                }

                if (inputPhone && previewPhone) {
                    previewPhone.textContent = inputPhone.value.trim() || '-';
                }

                if (inputEmail && previewEmail) {
                    previewEmail.textContent = inputEmail.value.trim() || '-';
                }

                if (inputAddress && previewAddress) {
                    previewAddress.textContent = inputAddress.value.trim() || 'Belum diisi';
                }

                if (inputIsActive && previewStatusContainer && previewStatusDot && previewStatusText) {
                    if (inputIsActive.checked) {
                        previewStatusContainer.className = "inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-100/70 text-emerald-800 border border-emerald-200";
                        previewStatusDot.className = "w-1.5 h-1.5 rounded-full bg-emerald-600";
                        previewStatusText.textContent = "Aktif";
                    } else {
                        previewStatusContainer.className = "inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-600 border border-gray-200";
                        previewStatusDot.className = "w-1.5 h-1.5 rounded-full bg-gray-400";
                        previewStatusText.textContent = "Nonaktif";
                    }
                }
            };

            [inputName, inputContactName, inputPhone, inputEmail, inputAddress].forEach(el => {
                if (el) el.addEventListener('input', updatePreview);
            });

            if (inputIsActive) {
                inputIsActive.addEventListener('change', updatePreview);
            }
        });
    </script>
</x-layouts.app>
