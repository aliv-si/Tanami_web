<style>
    .nav-link {
        @apply text-content-dark dark:text-gray-300 hover:text-primary dark:hover:text-primary
               transition-colors text-[16px] font-semibold leading-normal;
    }

    .nav-icon-btn {
        @apply flex items-center justify-center size-10 rounded-full
               hover:bg-gray-100 dark:hover:bg-gray-800
               text-content-dark dark:text-white transition-colors;
    }
</style>

<header
    class="sticky top-0 z-50 w-full bg-white/90 dark:bg-background-dark/90 backdrop-blur-md border-b border-[#e5e7eb] dark:border-[#2f3e2a]">
    <div class="px-4 md:px-10 py-3 mx-auto max-w-[1280px]">
        <div class="flex items-center justify-between whitespace-nowrap">
            <div class="flex items-center gap-3 text-content-dark dark:text-white">
                <div class="size-8 text-primary flex items-center justify-center">
                    <span class="material-symbols-outlined text-3xl">eco</span>
                </div>
                <h2
                    class="text-content-dark dark:text-white text-xl font-bold font-heading leading-tight tracking-[-0.015em]">
                    TANAMI</h2>
            </div>
            <div class="hidden md:flex flex-1 justify-center gap-8 font-heading">
                <a class="text-content-dark dark:text-gray-300 hover:text-primary dark:hover:text-primary transition-colors text-[16px] font-semibold leading-normal"
                    href="#">Home</a>
                <a class="text-content-dark dark:text-gray-300 hover:text-primary dark:hover:text-primary transition-colors text-[16px] font-semibold leading-normal"
                    href="#">Shop</a>
                <a class="text-content-dark dark:text-gray-300 hover:text-primary dark:hover:text-primary transition-colors text-[16px] font-semibold leading-normal"
                    href="#">About</a>
                <a class="text-content-dark dark:text-gray-300 hover:text-primary dark:hover:text-primary transition-colors text-[16px] font-semibold leading-normal"
                    href="#">Contact</a>
            </div>
            <div class="flex gap-3">
                <button
                    class="flex items-center justify-center size-10 rounded-full hover:bg-gray-100 dark:hover:bg-gray-800 text-content-dark dark:text-white transition-colors">
                    <span class="material-symbols-outlined">search</span>
                </button>
                <button
                    class="relative flex items-center justify-center size-10 rounded-full hover:bg-gray-100 dark:hover:bg-gray-800 text-content-dark dark:text-white transition-colors">
                    <span class="material-symbols-outlined">shopping_bag</span>
                    <span class="absolute top-1 right-1 size-2 bg-primary rounded-full"></span>
                </button>
                <button
                    class="flex items-center justify-center size-10 rounded-full hover:bg-gray-100 dark:hover:bg-gray-800 text-content-dark dark:text-white transition-colors">
                    <span class="material-symbols-outlined">person</span>
                </button>
            </div>
        </div>
    </div>
</header>