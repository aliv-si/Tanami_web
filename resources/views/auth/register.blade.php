<!DOCTYPE html>
<html class="light" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Tanami - Register</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect" />
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700;900&amp;family=Plus+Jakarta+Sans:wght@400;500;600;700;800&amp;display=swap"
        rel="stylesheet" />
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#53be20",
                        "background-light": "#f7f7f7",
                        "background-dark": "#162012",
                        "content-dark": "#1e3f1b",
                        "content-light": "#f2f4f0",
                    },
                    fontFamily: {
                        "sans": ["Inter", "sans-serif"],
                        "heading": ["Plus Jakarta Sans", "sans-serif"]
                    },
                    borderRadius: {
                        "DEFAULT": "0.5rem",
                        "lg": "0.75rem",
                        "xl": "1rem",
                        "full": "9999px"
                    },
                },
            },
        }
    </script>
</head>

<body class="bg-background-light font-sans text-base font-normal text-content-dark antialiased">
    <div class="relative flex flex-col w-full min-h-screen">
        <main class="flex-1 flex flex-col items-center justify-center py-8 px-4 sm:px-6 lg:px-8 w-full">
            <div class="w-full max-w-md bg-white rounded-xl shadow-xl shadow-gray-200/50 overflow-hidden p-6 sm:p-8 border border-gray-100">
                <div class="text-center mb-6">
                    <h2 class="text-2xl font-heading font-bold text-[#1e3f1b] leading-tight">Create Your Account</h2>
                    <p class="mt-1.5 text-sm text-gray-500 font-sans">Start growing smarter with Tanami</p>
                </div>

                @if (session('success'))
                <div class="mb-4 p-3 bg-green-50 border border-green-200 rounded-lg">
                    <p class="text-sm text-green-700">{{ session('success') }}</p>
                </div>
                @endif

                @if ($errors->any())
                <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded-lg">
                    @foreach ($errors->all() as $error)
                    <p class="text-sm text-red-600">{{ $error }}</p>
                    @endforeach
                </div>
                @endif

                <form action="{{ route('register') }}" class="space-y-4" method="POST">
                    @csrf

                    {{-- Role Selection --}}
                    <div>
                        <label class="block text-xs font-bold text-[#1e3f1b] font-sans mb-2">Daftar Sebagai</label>
                        <div class="grid grid-cols-2 gap-3">
                            <label class="relative cursor-pointer">
                                <input type="radio" name="role_pengguna" value="pembeli" class="peer sr-only" {{ old('role_pengguna', 'pembeli') === 'pembeli' ? 'checked' : '' }} required />
                                <div class="flex items-center justify-center gap-2 p-3 border-2 border-gray-200 rounded-lg peer-checked:border-[#53be20] peer-checked:bg-green-50 transition-all">
                                    <span class="material-symbols-outlined text-gray-500 peer-checked:text-[#53be20]">shopping_bag</span>
                                    <span class="text-sm font-semibold text-gray-700">Pembeli</span>
                                </div>
                            </label>
                            <label class="relative cursor-pointer">
                                <input type="radio" name="role_pengguna" value="petani" class="peer sr-only" {{ old('role_pengguna') === 'petani' ? 'checked' : '' }} />
                                <div class="flex items-center justify-center gap-2 p-3 border-2 border-gray-200 rounded-lg peer-checked:border-[#53be20] peer-checked:bg-green-50 transition-all">
                                    <span class="material-symbols-outlined text-gray-500 peer-checked:text-[#53be20]">agriculture</span>
                                    <span class="text-sm font-semibold text-gray-700">Petani</span>
                                </div>
                            </label>
                        </div>
                        <p class="text-xs text-gray-400 mt-2">
                            <span class="text-amber-600">⚠️</span> Akun petani memerlukan verifikasi admin (1-2 hari kerja)
                        </p>
                    </div>

                    {{-- Full Name --}}
                    <div>
                        <label class="block text-xs font-bold text-[#1e3f1b] font-sans mb-1" for="nama_lengkap">Nama Lengkap</label>
                        <input autocomplete="name"
                            class="w-full px-3 py-2.5 border border-gray-200 rounded-lg focus:border-[#53be20] focus:ring-1 focus:ring-[#53be20] outline-none transition-all text-sm @error('nama_lengkap') border-red-500 @enderror"
                            id="nama_lengkap" name="nama_lengkap" placeholder="John Doe" required type="text" value="{{ old('nama_lengkap') }}" />
                    </div>

                    {{-- Email --}}
                    <div>
                        <label class="block text-xs font-bold text-[#1e3f1b] font-sans mb-1" for="email">Email Address</label>
                        <input autocomplete="email"
                            class="w-full px-3 py-2.5 border border-gray-200 rounded-lg focus:border-[#53be20] focus:ring-1 focus:ring-[#53be20] outline-none transition-all text-sm @error('email') border-red-500 @enderror"
                            id="email" name="email" placeholder="you@example.com" required type="email" value="{{ old('email') }}" />
                    </div>

                    {{-- Phone (Optional) --}}
                    <div>
                        <label class="block text-xs font-bold text-[#1e3f1b] font-sans mb-1" for="no_hp">No. HP <span class="text-gray-400 font-normal">(Opsional)</span></label>
                        <input autocomplete="tel"
                            class="w-full px-3 py-2.5 border border-gray-200 rounded-lg focus:border-[#53be20] focus:ring-1 focus:ring-[#53be20] outline-none transition-all text-sm"
                            id="no_hp" name="no_hp" placeholder="08123456789" type="tel" value="{{ old('no_hp') }}" />
                    </div>

                    {{-- Password --}}
                    <div>
                        <label class="block text-xs font-bold text-[#1e3f1b] font-sans mb-1" for="password">Password</label>
                        <input autocomplete="new-password"
                            class="w-full px-3 py-2.5 border border-gray-200 rounded-lg focus:border-[#53be20] focus:ring-1 focus:ring-[#53be20] outline-none transition-all text-sm @error('password') border-red-500 @enderror"
                            id="password" name="password" placeholder="Minimal 8 karakter" required type="password" />
                    </div>

                    {{-- Confirm Password --}}
                    <div>
                        <label class="block text-xs font-bold text-[#1e3f1b] font-sans mb-1" for="password_confirmation">Konfirmasi Password</label>
                        <input autocomplete="new-password"
                            class="w-full px-3 py-2.5 border border-gray-200 rounded-lg focus:border-[#53be20] focus:ring-1 focus:ring-[#53be20] outline-none transition-all text-sm"
                            id="password_confirmation" name="password_confirmation" placeholder="Ulangi password" required type="password" />
                    </div>

                    {{-- Submit --}}
                    <button
                        class="w-full bg-[#53be20] hover:bg-[#46a31b] text-white font-heading font-semibold rounded-lg px-4 py-2.5 transition-all shadow-md shadow-[#53be20]/20 text-sm mt-2"
                        type="submit">
                        Daftar Sekarang
                    </button>
                </form>

                <div class="mt-5 text-center border-t border-gray-100 pt-5">
                    <p class="text-sm text-gray-600 font-sans">
                        Sudah punya akun?
                        <a class="font-semibold text-[#53be20] hover:text-[#46a31b] transition-colors"
                            href="{{ route('login') }}">Login</a>
                    </p>
                </div>
            </div>
        </main>
        <footer class="py-6 text-center text-sm text-gray-400 font-sans bg-background-light">
            <p>© 2026 Tanami. All rights reserved.</p>
        </footer>
    </div>
</body>

</html>