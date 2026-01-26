<footer class="dark:bg-background-dark py-8 px-4 md:px-10">
    <div class="container mx-auto">
        <div class="w-full bg-gradient-to-br from-[#3a8f16] to-[#53be20] rounded-[24px] p-6 md:p-8 relative overflow-hidden shadow-lg">
            <!-- Decorative blur -->
            <div class="absolute -top-20 -right-20 w-60 h-60 bg-white/10 rounded-full blur-3xl"></div>

            <!-- Main content grid -->
            <div class="grid grid-cols-1 md:grid-cols-12 gap-6 md:gap-8 relative z-10">
                <!-- Brand & Tagline -->
                <div class="md:col-span-3">
                    <img src="{{ asset('images/logowhite.png') }}" alt="Tanami" class="h-6 mb-3" />
                    <p class="font-heading text-sm font-medium leading-snug text-white/90 mb-4 max-w-[240px]">
                        Smarter agritech solutions, powered by nature.
                    </p>
                    <div class="flex gap-2">
                        <a class="size-8 rounded-lg bg-white/20 flex items-center justify-center hover:bg-white/30 transition-all" href="#">
                            <svg class="size-4 fill-white" viewBox="0 0 24 24">
                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"></path>
                            </svg>
                        </a>
                        <a class="size-8 rounded-lg bg-white/20 flex items-center justify-center hover:bg-white/30 transition-all" href="#">
                            <svg class="size-4 fill-white" viewBox="0 0 24 24">
                                <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.84 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"></path>
                            </svg>
                        </a>
                        <a class="size-8 rounded-lg bg-white/20 flex items-center justify-center hover:bg-white/30 transition-all" href="#">
                            <svg class="size-4 fill-white" viewBox="0 0 24 24">
                                <path d="M22.675 0h-21.35c-.732 0-1.325.593-1.325 1.325v21.351c0 .731.593 1.324 1.325 1.324h11.495v-9.294h-3.128v-3.622h3.128v-2.671c0-3.1 1.893-4.788 4.659-4.788 1.325 0 2.463.099 2.795.143v3.24l-1.918.001c-1.504 0-1.795.715-1.795 1.763v2.313h3.587l-.467 3.622h-3.12v9.293h6.116c.73 0 1.323-.593 1.323-1.324v-21.35c0-.732-.593-1.325-1.325-1.325z"></path>
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Navigation -->
                <div class="md:col-span-2">
                    <h4 class="font-handwriting font-medium text-white/70 mb-2 italic text-sm">Navigation</h4>
                    <ul class="space-y-1.5 font-heading font-semibold text-white text-sm">
                        <li><a class="hover:text-white/80 transition-colors" href="#">How it works</a></li>
                        <li><a class="hover:text-white/80 transition-colors" href="#">Features</a></li>
                        <li><a class="hover:text-white/80 transition-colors" href="#">Pricing</a></li>
                        <li><a class="hover:text-white/80 transition-colors" href="#">Testimonials</a></li>
                    </ul>
                </div>

                <!-- Company -->
                <div class="md:col-span-2">
                    <h4 class="font-handwriting font-medium text-white/70 mb-2 italic text-sm">Company</h4>
                    <ul class="space-y-1.5 font-heading font-semibold text-white text-sm">
                        <li><a class="hover:text-white/80 transition-colors" href="#">Blog</a></li>
                        <li><a class="hover:text-white/80 transition-colors" href="#">About</a></li>
                        <li><a class="hover:text-white/80 transition-colors" href="#">Terms</a></li>
                        <li><a class="hover:text-white/80 transition-colors" href="#">Privacy</a></li>
                    </ul>
                </div>

                <!-- Subscribe -->
                <div class="md:col-span-5 flex flex-col justify-end items-end">
                    <div class="text-left">
                        <h4 class="font-handwriting font-medium text-white/70 mb-2 italic text-sm">Stay updated</h4>
                        <div class="flex items-center bg-white/20 backdrop-blur-sm rounded-full p-1 pl-3 max-w-sm">
                            <input class="bg-transparent border-none text-sm placeholder:text-white/60 focus:ring-0 w-full text-white" placeholder="Enter email" type="email" />
                            <button class="bg-white text-[#53be20] text-xs font-semibold px-3 py-2 rounded-full hover:bg-white/90 transition-colors whitespace-nowrap">Subscribe</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bottom bar with copyright and large brand -->
            <div class="flex items-end justify-between mt-6 pt-4 border-t border-white/20 relative z-10">
                <p class="text-xs text-white/60">© 2026 Tanami. All rights reserved.</p>

                <!-- Large brand logo -->
                <img src="{{ asset('images/logowhite.png') }}" alt="Tanami" class="h-20 md:h-24 opacity-30 select-none -mb-6 md:-mb-12" />
            </div>
        </div>
    </div>
</footer>