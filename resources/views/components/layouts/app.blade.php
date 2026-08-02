<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>{{ $title ?? 'Fixoria Sales - Analytics Dashboard' }}</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link crossorigin href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&amp;family=Inter:wght@400;500;600;700&amp;display=swap" rel="stylesheet">
    <!-- Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet">
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "on-secondary": "#ffffff",
                        "on-tertiary-fixed-variant": "#783200",
                        "inverse-on-surface": "#eff6ff",
                        "secondary-fixed": "#dce2f3",
                        "surface-container": "#e0f2fe",
                        "surface-bright": "#f9f9ff",
                        "primary-container": "#2563eb",
                        "surface-dim": "#dbeafe",
                        "error-text": "#DC2626",
                        "on-primary": "#ffffff",
                        "tertiary-fixed-dim": "#ffb690",
                        "surface-variant": "#dbeafe",
                        "outline": "#787586",
                        "on-tertiary-container": "#ffd5c0",
                        "surface-container-highest": "#dbeafe",
                        "tertiary": "#7c3400",
                        "on-secondary-fixed": "#151c27",
                        "label": "#4B5563",
                        "secondary": "#585f6c",
                        "on-tertiary": "#ffffff",
                        "inverse-primary": "#bfdbfe",
                        "surface-container-high": "#dbeafe",
                        "surface": "#FFFFFF",
                        "error-container": "#ffdad6",
                        "on-secondary-container": "#5e6572",
                        "primary": "#2563eb",
                        "on-surface": "#141b2b",
                        "error-bg": "#FEE2E2",
                        "border": "#E5E7EB",
                        "secondary-fixed-dim": "#c0c7d6",
                        "on-primary-container": "#dbeafe",
                        "canvas": "#F3F4F6",
                        "primary-fixed": "#dbeafe",
                        "background": "#f9f9ff",
                        "surface-tint": "#3b82f6",
                        "surface-container-lowest": "#ffffff",
                        "on-tertiary-fixed": "#331100",
                        "inverse-surface": "#1e293b",
                        "on-error-container": "#93000a",
                        "tertiary-fixed": "#ffdbca",
                        "on-background": "#141b2b",
                        "tertiary-container": "#a24600",
                        "on-primary-fixed-variant": "#1e40af",
                        "outline-variant": "#c8c4d7",
                        "surface-container-low": "#eff6ff",
                        "secondary-container": "#dce2f3",
                        "error": "#ba1a1a",
                        "on-surface-variant": "#474555",
                        "on-secondary-fixed-variant": "#404754",
                        "on-error": "#ffffff",
                        "primary-fixed-dim": "#bfdbfe",
                        "on-primary-fixed": "#1e3a8a"
                    },
                    "borderRadius": {
                        "DEFAULT": "8px",
                        "lg": "8px",
                        "xl": "16px",
                        "full": "9999px"
                    },
                    "spacing": {
                        "stack-gap": "1rem",
                        "container-padding": "2rem",
                        "grid-gutter": "1.5rem"
                    },
                    "fontFamily": {
                        "label-sm": ["Inter", "sans-serif"],
                        "display-lg": ["Plus Jakarta Sans", "sans-serif"],
                        "body-md": ["Inter", "sans-serif"]
                    },
                    "fontSize": {
                        "label-sm": ["12px", {"lineHeight": "16px", "letterSpacing": "0.01em", "fontWeight": "600"}],
                        "display-lg": ["24px", {"lineHeight": "32px", "letterSpacing": "-0.02em", "fontWeight": "600"}],
                        "body-md": ["14px", {"lineHeight": "20px", "fontWeight": "500"}]
                    }
                },
            },
        }
    </script>
    <style>
        body {
            background-color: #F3F4F6;
            color: #141B2B;
            -webkit-font-smoothing: antialiased;
        }
        .canvas-bg { background-color: #F3F4F6; }
        .surface-card {
            background: #FFFFFF;
            border-radius: 16px;
            box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.03);
            border: 1px solid #E5E7EB;
        }
        .sidebar-item-active {
            background-color: #2563eb;
            color: #FFFFFF;
        }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
            vertical-align: middle;
        }
        .fill-icon {
            font-variation-settings: 'FILL' 1;
        }
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #F3F4F6;
        }
        ::-webkit-scrollbar-thumb {
            background: #C5C9D3;
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #9CA3AF;
        }

        /* Clean select styling with custom vector chevron */
        select {
            appearance: none !important;
            -webkit-appearance: none !important;
            -moz-appearance: none !important;
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%23474555' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e") !important;
            background-repeat: no-repeat !important;
            background-position: right 0.75rem center !important;
            background-size: 1rem !important;
            padding-right: 2.5rem !important;
        }

        /* Remove browser default spinner arrows from number inputs */
        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
        input[type=number] {
            -moz-appearance: textfield;
        }
    </style>
</head>
<body class="font-body-md text-body-md h-screen w-screen flex overflow-hidden">
    <!-- Sidebar Navigation -->
    <aside class="w-64 bg-white border-r border-border flex flex-col h-screen shrink-0 z-50">
        <!-- Brand Identity -->
        <div class="px-6 py-8">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
                <div class="w-10 h-10 bg-primary rounded-lg flex items-center justify-center text-white">
                    <span class="material-symbols-outlined fill-icon">inventory_2</span>
                </div>
                <h1 class="font-display-lg text-display-lg text-primary tracking-tight">Fixoria Sales</h1>
            </a>
        </div>

        <!-- Navigation Menu -->
        <nav class="flex-1 px-4 space-y-1 overflow-y-auto">
            <a class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('dashboard') ? 'sidebar-item-active' : 'text-secondary hover:bg-surface-container-low' }} rounded-lg transition-all" href="{{ route('dashboard') }}">
                <span class="material-symbols-outlined {{ request()->routeIs('dashboard') ? 'fill-icon' : '' }}">dashboard</span>
                <span class="font-semibold">Dashboard</span>
            </a>
            <a class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('products.*') ? 'sidebar-item-active' : 'text-secondary hover:bg-surface-container-low' }} rounded-lg transition-all" href="{{ route('products.index') }}">
                <span class="material-symbols-outlined {{ request()->routeIs('products.*') ? 'fill-icon' : '' }}">inventory_2</span>
                <span class="font-semibold">Master Produk</span>
            </a>
            <a class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('categories.*') ? 'sidebar-item-active' : 'text-secondary hover:bg-surface-container-low' }} rounded-lg transition-all" href="{{ route('categories.index') }}">
                <span class="material-symbols-outlined {{ request()->routeIs('categories.*') ? 'fill-icon' : '' }}">category</span>
                <span class="font-semibold">Kategori</span>
            </a>
            <a class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('suppliers.*') ? 'sidebar-item-active' : 'text-secondary hover:bg-surface-container-low' }} rounded-lg transition-all" href="{{ route('suppliers.index') }}">
                <span class="material-symbols-outlined {{ request()->routeIs('suppliers.*') ? 'fill-icon' : '' }}">local_shipping</span>
                <span class="font-semibold">Supplier</span>
            </a>
            <a class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('stock-transactions.*') ? 'sidebar-item-active' : 'text-secondary hover:bg-surface-container-low' }} rounded-lg transition-all" href="{{ route('stock-transactions.index') }}">
                <span class="material-symbols-outlined {{ request()->routeIs('stock-transactions.*') ? 'fill-icon' : '' }}">swap_horiz</span>
                <span class="font-semibold">Transaksi Stok</span>
            </a>
            <a class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('reports.*') ? 'sidebar-item-active' : 'text-secondary hover:bg-surface-container-low' }} rounded-lg transition-all" href="{{ route('reports.index') }}">
                <span class="material-symbols-outlined {{ request()->routeIs('reports.*') ? 'fill-icon' : '' }}">assessment</span>
                <span class="font-semibold">Laporan</span>
            </a>
            <a class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('users.*') ? 'sidebar-item-active' : 'text-secondary hover:bg-surface-container-low' }} rounded-lg transition-all" href="{{ route('users.index') }}">
                <span class="material-symbols-outlined {{ request()->routeIs('users.*') ? 'fill-icon' : '' }}">manage_accounts</span>
                <span class="font-semibold">Pengguna & Role</span>
            </a>
        </nav>

        <!-- User Profile Section -->
        <div class="p-4 mt-auto border-t border-border">
            <div class="bg-surface-container-low rounded-xl p-4 flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-primary-container text-white font-bold flex items-center justify-center text-sm shrink-0">
                    AW
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-bold text-on-surface truncate">Andi Wijaya</p>
                    <p class="text-xs text-secondary truncate">Inventory Manager</p>
                </div>
                <form method="POST" action="{{ route('login') }}" class="inline">
                    @csrf
                    <a href="{{ route('login') }}" class="text-secondary hover:text-error transition-colors" title="Logout">
                        <span class="material-symbols-outlined">logout</span>
                    </a>
                </form>
            </div>
        </div>
    </aside>

    <!-- Main Content Canvas -->
    <main class="flex-1 flex flex-col min-w-0 h-screen overflow-y-auto scroll-smooth">
        <!-- TopAppBar -->
        <header class="h-16 flex items-center justify-between px-8 bg-white/80 backdrop-blur-md sticky top-0 z-40 border-b border-border/50 shrink-0">
            <div class="flex-1 max-w-xl flex items-center h-full">
                @php
                    $searchAction = route('products.index');
                    $searchPlaceholder = 'Cari data produk, SKU, supplier...';

                    if (request()->routeIs('categories.*')) {
                        $searchAction = route('categories.index');
                        $searchPlaceholder = 'Cari nama kategori...';
                    } elseif (request()->routeIs('suppliers.*')) {
                        $searchAction = route('suppliers.index');
                        $searchPlaceholder = 'Cari nama supplier, email, telepon...';
                    } elseif (request()->routeIs('products.*')) {
                        $searchAction = route('products.index');
                        $searchPlaceholder = 'Cari nama produk, SKU...';
                    }
                @endphp
                <form action="{{ $searchAction }}" method="GET" class="relative flex items-center w-full h-10 my-auto group" id="global-header-search-form">
                    <button type="submit" class="absolute left-3.5 top-1/2 -translate-y-1/2 flex items-center justify-center text-outline group-focus-within:text-primary transition-colors hover:text-primary focus:outline-none" title="Cari">
                        <span class="material-symbols-outlined text-[20px]">search</span>
                    </button>
                    <input id="global-header-search" name="search" value="{{ request('search') }}" class="w-full h-10 bg-canvas border border-transparent focus:border-primary/30 focus:bg-white focus:ring-2 focus:ring-primary/20 rounded-xl pl-10 pr-4 text-sm transition-all outline-none" placeholder="{{ $searchPlaceholder }}" type="text" autocomplete="off">
                </form>
            </div>
            <div class="flex items-center gap-6">
                <button class="relative p-2 text-secondary hover:bg-surface-container-low rounded-full transition-all" type="button">
                    <span class="material-symbols-outlined">notifications</span>
                    <span class="absolute top-2 right-2 w-2 h-2 bg-error rounded-full border-2 border-white"></span>
                </button>
                <button class="p-2 text-secondary hover:bg-surface-container-low rounded-full transition-all" type="button">
                    <span class="material-symbols-outlined">help_outline</span>
                </button>
                <div class="h-6 w-px bg-border"></div>
                <div class="flex items-center gap-2">
                    <span class="text-sm font-semibold text-on-surface">ID Sales: FX-8892</span>
                </div>
            </div>
        </header>

        <!-- Dynamic Content Slot -->
        {{ $slot }}

        <!-- Footer -->
        <footer class="mt-auto px-8 py-6 border-t border-border flex items-center justify-between text-secondary">
            <p class="font-label-sm text-label-sm">© 2024 Fixoria Sales. All rights reserved.</p>
            <div class="flex gap-6">
                <a class="font-label-sm text-label-sm hover:text-primary transition-colors" href="#">Privacy Policy</a>
                <a class="font-label-sm text-label-sm hover:text-primary transition-colors" href="#">Terms of Service</a>
                <a class="font-label-sm text-label-sm hover:text-primary transition-colors" href="#">Contact Support</a>
            </div>
        </footer>
    </main>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const headerSearch = document.getElementById('global-header-search');
            const localUserSearch = document.getElementById('user-search-input');

            if (headerSearch && localUserSearch) {
                if (headerSearch.value) {
                    localUserSearch.value = headerSearch.value;
                    localUserSearch.dispatchEvent(new Event('input'));
                }
                headerSearch.addEventListener('input', (e) => {
                    localUserSearch.value = e.target.value;
                    localUserSearch.dispatchEvent(new Event('input'));
                });
            }
        });
    </script>
</body>
</html>
