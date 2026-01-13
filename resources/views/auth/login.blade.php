<!DOCTYPE html>
<html class="light" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Tanami - Login</title>
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

<body
    class="bg-background-light font-sans text-base font-normal text-content-dark antialiased flex flex-col min-h-screen">
    <div class="relative flex flex-col w-full min-h-screen">
        <main class="flex-1 flex flex-col items-center justify-center p-4 sm:p-6 w-full relative">
            <div
                class="w-full max-w-[400px] bg-white rounded-xl shadow-xl shadow-gray-200/50 border border-gray-100 overflow-hidden">
                <div class="p-6 sm:p-8">
                    <div class="mb-6 text-center">
                        <h2 class="text-2xl font-heading font-bold text-[#1e3f1b] mb-1.5 tracking-tight">Welcome Back
                        </h2>
                        <p class="text-gray-500 font-sans text-sm font-normal">Login to continue managing your farm
                            needs</p>
                    </div>
                    <form action="#" class="space-y-4" method="POST">
                        <div class="space-y-1">
                            <label class="block text-xs font-bold text-[#1e3f1b] font-sans" for="email">Email
                                Address</label>
                            <div class="relative">
                                <input
                                    class="w-full px-3 py-2.5 rounded-lg border border-gray-200 focus:border-[#53be20] focus:ring-1 focus:ring-[#53be20] outline-none transition-all font-sans text-sm text-gray-800 placeholder-gray-400"
                                    id="email" name="email" placeholder="name@tanami.ag" required=""
                                    type="email" />
                            </div>
                        </div>
                        <div class="space-y-1">
                            <label class="block text-xs font-bold text-[#1e3f1b] font-sans"
                                for="password">Password</label>
                            <div class="relative">
                                <input
                                    class="w-full px-3 py-2.5 rounded-lg border border-gray-200 focus:border-[#53be20] focus:ring-1 focus:ring-[#53be20] outline-none transition-all font-sans text-sm text-gray-800 placeholder-gray-400"
                                    id="password" name="password" placeholder="••••••••" required=""
                                    type="password" />
                            </div>
                        </div>
                        <div class="flex items-center justify-between pt-0.5">
                            <div class="flex items-center">
                                <input
                                    class="h-3.5 w-3.5 rounded border-gray-300 text-[#53be20] focus:ring-[#53be20] cursor-pointer"
                                    id="remember-me" name="remember-me" type="checkbox" />
                                <label class="ml-2 block text-xs text-gray-600 font-sans cursor-pointer"
                                    for="remember-me">Remember me</label>
                            </div>
                            <a class="text-xs font-semibold text-[#1e3f1b] hover:text-[#53be20] transition-colors font-sans"
                                href="#">Forgot Password?</a>
                        </div>
                        <button
                            class="w-full bg-[#53be20] hover:bg-[#46a51b] text-white font-heading font-semibold rounded-lg px-4 py-2.5 transition-all shadow-md shadow-[#53be20]/20 text-sm mt-1"
                            type="submit">
                            Login
                        </button>
                    </form>
                    <div class="relative my-5">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-100"></div>
                        </div>
                        <div class="relative flex justify-center text-xs">
                            <span class="bg-white px-2 text-gray-400 font-sans">Or</span>
                        </div>
                    </div>
                    <button
                        class="w-full flex items-center justify-center gap-2.5 bg-white border border-gray-200 hover:bg-gray-50 hover:border-gray-300 text-gray-700 font-semibold font-sans rounded-lg px-4 py-2.5 transition-colors text-sm"
                        type="button">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M23.766 12.2764C23.766 11.4607 23.6999 10.6406 23.5588 9.83807H12.24V14.4591H18.7217C18.4528 15.9494 17.5885 17.2678 16.323 18.1056V21.1039H20.19C22.4608 19.0139 23.766 15.9274 23.766 12.2764Z"
                                fill="#4285F4"></path>
                            <path
                                d="M12.24 24.0008C15.4765 24.0008 18.2059 22.9382 20.19 21.1039L16.323 18.1056C15.2517 18.8375 13.8627 19.252 12.24 19.252C9.11388 19.252 6.45946 17.1399 5.50705 14.3003H1.5166V17.3912C3.55371 21.4434 7.7029 24.0008 12.24 24.0008Z"
                                fill="#34A853"></path>
                            <path
                                d="M5.50705 14.3003C5.03832 12.8727 5.03832 11.1273 5.50705 9.69968V6.60876H1.5166C-0.185718 10.0056 -0.185718 13.9944 1.5166 17.3912L5.50705 14.3003Z"
                                fill="#FBBC05"></path>
                            <path
                                d="M12.24 4.74966C13.9509 4.7232 15.6044 5.36697 16.8434 6.54867L20.2695 3.12262C18.1001 1.0855 15.2208 -0.0344664 12.24 0.000808666C7.7029 0.000808666 3.55371 2.55822 1.5166 6.60876L5.50705 9.69968C6.45064 6.86173 9.10842 4.74966 12.24 4.74966Z"
                                fill="#EA4335"></path>
                        </svg>
                        Continue with Google
                    </button>
                </div>
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex flex-col items-center gap-2">
                    <p class="text-xs text-gray-600 font-sans">
                        Don't have an account?
                        <a class="font-bold text-[#1e3f1b] hover:text-[#53be20] transition-colors"
                            href="#">Register</a>
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
