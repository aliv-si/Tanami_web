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
    <script src="{{ asset('js/app.js') }}"></script>
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

<body
    class="bg-background-light dark:bg-background-dark font-sans text-base font-normal text-content-dark dark:text-content-light overflow-x-hidden antialiased">
    <div class="relative flex flex-col w-full min-h-screen group/design-root">
        <main
            class="flex-1 flex flex-col items-center justify-center py-8 px-4 sm:px-6 lg:px-8 w-full bg-background-light dark:bg-background-dark">
            <div
                class="w-full max-w-md bg-white dark:bg-[#1f2b1b] rounded-xl shadow-[0_4px_20px_rgba(0,0,0,0.05)] overflow-hidden p-6 border border-gray-100 dark:border-white/5">
                <div class="text-center mb-5">
                    <h2 class="text-xl font-heading font-bold text-[#1e3f1b] dark:text-white leading-tight">Create Your
                        Account</h2>
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400 font-sans">Start growing smarter with Tanami
                    </p>
                </div>
                <form action="{{ route('register') }}" class="space-y-3" method="POST">
                    @csrf

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

                    <div>
                        <label class="block text-xs font-medium text-[#1e3f1b] dark:text-gray-200 font-sans mb-1"
                            for="full-name">Daftar Sebagai</label>
                        <div class="grid grid-cols-2 gap-3">
                            <label class="relative cursor-pointer">
                                <input type="radio" name="role_pengguna" value="pembeli" class="peer sr-only" {{ old('role_pengguna', 'pembeli') === 'pembeli' ? 'checked' : '' }} required />
                                <div class="flex items-center justify-center gap-2 p-3 border-2 border-gray-200 rounded-lg peer-checked:border-[#53be20] peer-checked:bg-green-50 transition-all">
                                    <span class="material-symbols-outlined text-gray-500 peer-checked:text-[#53be20]">shopping_bag</span>
                                    <span class="text-sm text-gray-700">Pembeli</span>
                                </div>
                            </label>
                            <label class="relative cursor-pointer">
                                <input type="radio" name="role_pengguna" value="petani" class="peer sr-only" {{ old('role_pengguna') === 'petani' ? 'checked' : '' }} />
                                <div class="flex items-center justify-center gap-2 p-3 border-2 border-gray-200 rounded-lg peer-checked:border-[#53be20] peer-checked:bg-green-50 transition-all">
                                    <span class="material-symbols-outlined text-gray-500 peer-checked:text-[#53be20]">agriculture</span>
                                    <span class="text-sm text-gray-700">Petani</span>
                                </div>
                            </label>
                        </div>
                        <p class="text-xs text-gray-400 mt-2">
                            <span class="text-amber-600">⚠️</span> Akun petani memerlukan verifikasi admin (1-2 hari kerja)
                        </p>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-[#1e3f1b] dark:text-gray-200 font-sans mb-1"
                            for="nama_lengkap">Full Name</label>
                        <div class="mt-0.5">
                            <input autocomplete="name"
                                class="appearance-none block w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-[#53be20] focus:border-[#53be20] text-sm font-sans bg-white dark:bg-white/5 text-gray-900 dark:text-white transition-colors"
                                id="nama_lengkap" name="nama_lengkap" placeholder="John Doe" required="" type="text" value="{{ old('nama_lengkap') }}" />
                            @error('nama_lengkap')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-[#1e3f1b] dark:text-gray-200 font-sans mb-1"
                            for="email">Email Address</label>
                        <div class="mt-0.5">
                            <input autocomplete="email"
                                class="appearance-none block w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-[#53be20] focus:border-[#53be20] text-sm font-sans bg-white dark:bg-white/5 text-gray-900 dark:text-white transition-colors"
                                id="email" name="email" placeholder="you@example.com" required=""
                                type="email" value="{{ old('email') }}" />
                            @error('email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-[#1e3f1b] dark:text-gray-200 font-sans mb-1"
                            for="password">Password</label>
                        <div class="mt-0.5 relative">
                            <input autocomplete="new-password"
                                class="appearance-none block w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-[#53be20] focus:border-[#53be20] text-sm font-sans bg-white dark:bg-white/5 text-gray-900 dark:text-white transition-colors"
                                id="password" name="password" placeholder="••••••••" required="" type="password" oninput="checkPasswordStrength(this.value)" />
                            @error('password')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mt-1.5 flex gap-1" id="strengthBars">
                            <div id="bar1" class="h-1 flex-1 bg-gray-200 dark:bg-white/10 rounded-full transition-colors"></div>
                            <div id="bar2" class="h-1 flex-1 bg-gray-200 dark:bg-white/10 rounded-full transition-colors"></div>
                            <div id="bar3" class="h-1 flex-1 bg-gray-200 dark:bg-white/10 rounded-full transition-colors"></div>
                            <div id="bar4" class="h-1 flex-1 bg-gray-200 dark:bg-white/10 rounded-full transition-colors"></div>
                        </div>
                        <p id="strengthText" class="text-[10px] text-gray-500 mt-1 font-sans">Password strength: -</p>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-[#1e3f1b] dark:text-gray-200 font-sans mb-1"
                            for="password_confirmation">Confirm Password</label>
                        <div class="mt-0.5">
                            <input autocomplete="new-password"
                                class="appearance-none block w-full px-3 py-2 border border-gray-300 dark:border-gray-700 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-[#53be20] focus:border-[#53be20] text-sm font-sans bg-white dark:bg-white/5 text-gray-900 dark:text-white transition-colors"
                                id="password_confirmation" name="password_confirmation" placeholder="••••••••" required=""
                                type="password" />
                            @error('password_confirmation')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="flex items-start">
                        <div class="flex h-5 items-center">
                            <input
                                class="h-3.5 w-3.5 text-[#53be20] focus:ring-[#53be20] border-gray-300 rounded cursor-pointer"
                                id="terms" name="terms" type="checkbox" required />
                        </div>
                        <div class="ml-2 text-xs">
                            <label class="font-medium text-gray-600 dark:text-gray-400 font-sans" for="terms">
                                I agree to the <a
                                    class="text-[#53be20] hover:text-[#46a31b] hover:underline transition-colors"
                                    href="#">Terms</a> &amp; <a
                                    class="text-[#53be20] hover:text-[#46a31b] hover:underline transition-colors"
                                    href="#">Privacy Policy</a>
                            </label>
                        </div>
                    </div>
                    <div>
                        <button
                            class="w-full flex justify-center py-2 px-4 border border-transparent rounded-lg shadow-sm text-sm font-semibold text-white bg-[#53be20] hover:bg-[#46a31b] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#53be20] font-heading transition-colors"
                            type="submit">
                            Create Account
                        </button>
                    </div>
                </form>
                <div class="mt-4">
                    <div class="relative">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-200 dark:border-gray-700"></div>
                        </div>
                        <div class="relative flex justify-center text-xs">
                            <span class="px-2 bg-white dark:bg-[#1f2b1b] text-gray-500 font-sans">Or continue
                                with</span>
                        </div>
                    </div>
                    <div class="mt-4">
                        <button
                            class="w-full flex justify-center items-center gap-2 px-4 py-2 border border-gray-300 dark:border-gray-600 shadow-sm text-sm font-medium rounded-lg text-gray-700 dark:text-gray-200 bg-white dark:bg-white/5 hover:bg-gray-50 dark:hover:bg-white/10 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-200 font-sans transition-colors"
                            type="button">
                            <img alt="Google" class="w-4 h-4"
                                src="https://lh3.googleusercontent.com/aida-public/AB6AXuBDiQcRd7colLZ05XYOmQHGwV5gds2UvrXCUOFFSP5dXmL1QkMIavzslGgp3faOzpe8YQ75Hdtv7KYvK7MrvNFi8in-851hqWppPnUNc_t3sj5mYtEhXJL-7WQDIS16rmSpvfK2c1C43w23FLf8eoxcT2uXeBY3E8juc38pGW8TccEN1eYI-GNeMq61EdoxTL5IM2cd2m4mlo5X_wtvd4jjQA8iyW0QWeNZ20m7tJQLkigeGX4GqgyMeJALu6mI-0BegWQZT0TEXfrZ" />
                            Sign up with Google
                        </button>
                    </div>
                </div>
                <div class="mt-4 text-center border-t border-gray-100 dark:border-white/5 pt-4">
                    <p class="text-xs text-gray-600 font-sans">
                        Already have an account?
                        <a class="font-bold text-[#1e3f1b] hover:text-[#53be20] transition-colors"
                            href="{{ route('login') }}">Login</a>
                    </p>
                </div>
            </div>
        </main>
    </div>
</body>

</html>