<!DOCTYPE html>
<html class="h-full" lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>{{ $title ?? 'Fixoria Sales' }}</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link crossorigin href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&amp;family=Plus+Jakarta+Sans:wght@600;700;800&amp;display=swap" rel="stylesheet">
    <!-- Material Symbols -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet">
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "on-secondary-container": "#5e6572",
                        "secondary-fixed-dim": "#c0c7d6",
                        "primary-container": "#2563eb",
                        "surface-container": "#e0f2fe",
                        "inverse-on-surface": "#eff6ff",
                        "error-text": "#DC2626",
                        "surface-dim": "#dbeafe",
                        "surface-container-high": "#dbeafe",
                        "on-primary": "#ffffff",
                        "tertiary-fixed-dim": "#ffb690",
                        "primary": "#2563eb",
                        "error-container": "#ffdad6",
                        "surface": "#FFFFFF",
                        "secondary": "#585f6c",
                        "inverse-primary": "#bfdbfe",
                        "on-surface": "#141b2b",
                        "secondary-fixed": "#dce2f3",
                        "on-secondary-fixed": "#151c27",
                        "surface-bright": "#f9f9ff",
                        "error-bg": "#FEE2E2",
                        "on-tertiary": "#ffffff",
                        "surface-variant": "#dbeafe",
                        "outline": "#787586",
                        "secondary-container": "#dce2f3",
                        "on-secondary": "#ffffff",
                        "on-tertiary-container": "#ffd5c0",
                        "tertiary": "#7c3400",
                        "error": "#ba1a1a",
                        "outline-variant": "#c8c4d7",
                        "background": "#f9f9ff",
                        "on-primary-fixed-variant": "#1e40af",
                        "on-primary-fixed": "#1e3a8a",
                        "on-error-container": "#93000a",
                        "surface-container-highest": "#dbeafe",
                        "on-tertiary-fixed": "#331100",
                        "on-secondary-fixed-variant": "#404754",
                        "label": "#4B5563",
                        "border": "#E5E7EB",
                        "on-error": "#ffffff",
                        "surface-tint": "#3b82f6",
                        "tertiary-container": "#a24600",
                        "canvas": "#F3F4F6",
                        "tertiary-fixed": "#ffdbca",
                        "on-primary-container": "#dfd9ff",
                        "surface-container-low": "#f1f3ff",
                        "surface-container-lowest": "#ffffff",
                        "inverse-surface": "#293040",
                        "on-background": "#141b2b",
                        "on-surface-variant": "#474555",
                        "primary-fixed": "#e4dfff",
                        "primary-fixed-dim": "#c6bfff",
                        "on-tertiary-fixed-variant": "#783200"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                    "spacing": {
                        "stack-gap": "1rem",
                        "grid-gutter": "1.5rem",
                        "container-padding": "2rem"
                    },
                    "fontFamily": {
                        "body-md": ["Inter", "sans-serif"],
                        "label-sm": ["Inter", "sans-serif"],
                        "display-lg": ["Plus Jakarta Sans", "sans-serif"]
                    },
                    "fontSize": {
                        "label-sm": ["12px", {"lineHeight": "16px", "letterSpacing": "0.01em", "fontWeight": "600"}],
                        "body-md": ["14px", {"lineHeight": "20px", "fontWeight": "500"}],
                        "display-lg": ["24px", {"lineHeight": "32px", "letterSpacing": "-0.02em", "fontWeight": "600"}]
                    }
                },
            },
        }
    </script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #F3F4F6;
        }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
            vertical-align: middle;
        }
        .signature-shadow {
            box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.03);
        }
        .animate-fade-in {
            animation: fadeIn 0.5s ease-out forwards;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body class="min-h-screen flex flex-col justify-center items-center p-4">
    <!-- Top Navigation Header -->
    <header class="fixed top-0 left-0 w-full flex justify-between items-center px-8 py-6 pointer-events-none z-10">
        <a href="{{ route('login') }}" class="font-display-lg text-display-lg text-primary pointer-events-auto hover:opacity-90 transition-opacity">Fixoria Sales</a>
        <div class="flex gap-6 pointer-events-auto">
            <button class="text-on-surface-variant hover:text-primary transition-colors focus:outline-none" type="button" aria-label="Help">
                <span class="material-symbols-outlined">help_outline</span>
            </button>
        </div>
    </header>

    <!-- Main Content Shell -->
    <main class="w-full max-w-md animate-fade-in my-auto">
        <!-- Central Card Shell -->
        <div class="bg-surface rounded-xl signature-shadow p-8 border border-border flex flex-col gap-6">
            {{ $slot }}
        </div>

        <!-- System Status Badges -->
        <div class="mt-8 flex justify-center items-center gap-6 text-outline opacity-60">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-[16px]">verified_user</span>
                <span class="font-label-sm text-[10px] uppercase tracking-widest">Secure System</span>
            </div>
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-[16px]">lan</span>
                <span class="font-label-sm text-[10px] uppercase tracking-widest">Inventory v2.4</span>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="mt-8 mb-6 text-center flex flex-col items-center gap-2">
        <div class="flex gap-4">
            <a class="font-label-sm text-label-sm text-on-secondary-container hover:text-primary transition-colors opacity-80" href="#">Privacy Policy</a>
            <a class="font-label-sm text-label-sm text-on-secondary-container hover:text-primary transition-colors opacity-80" href="#">Terms of Service</a>
            <a class="font-label-sm text-label-sm text-on-secondary-container hover:text-primary transition-colors opacity-80" href="#">Contact Support</a>
        </div>
        <p class="font-label-sm text-label-sm text-on-secondary-container opacity-60">© 2024 Fixoria Sales. All rights reserved.</p>
    </footer>
</body>
</html>
