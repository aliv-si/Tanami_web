<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>DompetKu - @yield('title')</title>

        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
      
        <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
        <script src="https://cdn.tailwindcss.com"></script>

        <style>
        body { font-family: 'Inter', sans-serif; }
        </style>
    </head>
    <body class="bg-gray-50 text-gray-800">
        <div class="flex h-screen">
            <aside class="w-64 bg-white border-r border-gray-200 hidden md:block">
                <div class="p-6">
                    <h1 class="text-2xl font-bold text-indigo-600 tracking-tighter">DompetKu</h1>
                </div>
                <nav class="mt-6 px-6 space-y-2">
                    <a href="{{ url('/') }}" class="block px-4 py-2.5 bg-indigo-50 text-indigo-700 rounded-lg font-medium">
                    Dashboard
                    </a>
                    <a href="{{ url('/transaksi/create') }}" class="block px-4 py-2.5 text-gray-600 hover:bg-gray-50 hover:text-gray-900 rounded-lg transition">
                    Tambah Transaksi
                    </a>
                    <a href="{{ url('/laporan') }}" class="block px-4 py-2.5 text-gray-600 hover:bg-gray-50 hover:text-gray-900 rounded-lg transition">
                    Laporan (VIP)
                    </a>
                </nav>
            </aside>
            <main class="flex-1 flex flex-col overflow-hidden">
                <header class="bg-white shadow-sm border-b border-gray-200 p-4 md:hidden">
                    <h1 class="text-xl font-bold text-indigo-600">DompetKu</h1>
                </header>
                <div class="flex-1 overflow-auto p-4 md:p-8">
                    @if(session('success'))
                    <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-r shadow-sm">
                        <p class="font-bold">Berhasil!</p>
                        <p>{{ session('success') }}</p>
                    </div>
                    @elseif (session('gagal'))
                    <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-r shadow-sm">
                        <p class="font-bold">Gagal!</p>
                        <p>{{ session('gagal') }}</p>
                    </div>
                    @endif
                    @yield('content')
                </div>
            </main>
        </div>
    </body>
</html>