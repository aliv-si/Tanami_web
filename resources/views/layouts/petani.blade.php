<!DOCTYPE html>
<html class="light" lang="en">

<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Tanami - @yield('title', 'Dashboard')</title>
    
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com" rel="preconnect"/>
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>
    
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#53be20",
                        "sidebar": "#1e3f1b",
                        "background": "#f7f7f7",
                        "text-dark": "#1e3f1b",
                    },
                    fontFamily: {
                        "sans": ["Inter", "sans-serif"],
                        "heading": ["Plus Jakarta Sans", "sans-serif"]
                    },
                },
            },
        }
    </script>
    
    <style type="text/tailwindcss">
        @layer base {
            h1, h2, h3, h4 { @apply font-heading; }
            body { @apply font-sans; }
        }
        /* Class ini HARUS sama dengan yang dipanggil di sidebar component */
        .active-nav {
            @apply text-primary bg-white/5 border-r-4 border-primary;
        }
        
        /* Utility Classes lainnya */
        .summary-card {
            @apply bg-white p-6 rounded-xl border border-gray-100 shadow-sm transition-all hover:shadow-md;
        }
        .form-input {
            @apply w-full px-4 py-2.5 bg-white border border-gray-200 rounded-lg text-sm focus:ring-primary focus:border-primary transition-all;
        }
        .review-card {
            @apply bg-white p-6 rounded-xl border border-gray-100 shadow-sm transition-all hover:shadow-md;
        }
    </style>
    @stack('styles')
</head>

<body class="bg-background text-text-dark antialiased">
    <div class="flex min-h-screen">
        @php
            // LOGIKA SINKRONISASI:
            // Menentukan activePage berdasarkan URL saat ini.
            // Menggunakan request()->is() lebih aman daripada str_starts_with manual.
            
            $activePage = 'dashboard'; // Default

            if (request()->is('petani/produk*') || request()->is('produk*')) {
                $activePage = 'produk';
            } elseif (request()->is('petani/pesanan*') || request()->is('pesanan*')) {
                $activePage = 'pesanan';
            } elseif (request()->is('petani/rekening*') || request()->is('rekening*')) {
                $activePage = 'rekening';
            } elseif (request()->is('petani/ulasan*') || request()->is('ulasan*')) {
                $activePage = 'ulasan';
            } elseif (request()->is('petani/dashboard*') || request()->is('dashboard*')) {
                $activePage = 'dashboard';
            }
        @endphp

        <x-sidebar-petani :active="$activePage" />
        
        <main class="flex-1 ml-64">
            @yield('content')
        </main>
    </div>

    @stack('scripts')
</body>
</html>