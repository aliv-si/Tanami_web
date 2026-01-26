@extends('layouts.app')

@section('title', 'Kontak | Tanami')

@section('content')
<main class="grow flex flex-col items-center justify-center py-10 px-4 md:px-10 lg:px-40 w-full">
    <div class="max-w-[1080px] w-full flex flex-col gap-10">
        <div class="flex flex-col gap-3 text-center md:text-left">
            <h2 class="text-text-heading text-4xl font-semibold font-jakarta leading-tight tracking-tight">Contact Us
            </h2>
            <p class="text-text-body text-lg font-normal max-w-2xl font-inter">
                Have questions about our produce, partnership opportunities, or platform? We're here to help you grow.
            </p>
        </div>
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-start">
            <div class="lg:col-span-5 flex flex-col gap-8 order-2 lg:order-1">
                <div class="grid gap-6">
                    <div class="flex items-start gap-4">
                        <div
                            class="size-10 rounded-full bg-primary/10 flex items-center justify-center text-primary shrink-0">
                            <span class="material-symbols-outlined">location_on</span>
                        </div>
                        <div>
                            <h3 class="text-text-heading font-bold text-lg font-inter">Visit Our Farm</h3>
                            <p class="text-text-body font-inter">Condong Catur, Depok, Sleman<br />Amikom University of Technology
                            </p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div
                            class="size-10 rounded-full bg-primary/10 flex items-center justify-center text-primary shrink-0">
                            <span class="material-symbols-outlined">call</span>
                        </div>
                        <div>
                            <h3 class="text-text-heading font-bold text-lg font-inter">Call Us</h3>
                            <p class="text-text-body font-inter">Mon-Fri from 8am to 5pm.</p>
                            <a class="text-primary font-medium hover:underline font-inter" href="tel:+15550000000">+1
                                (555) 000-0000</a>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div
                            class="size-10 rounded-full bg-primary/10 flex items-center justify-center text-primary shrink-0">
                            <span class="material-symbols-outlined">mail</span>
                        </div>
                        <div>
                            <h3 class="text-text-heading font-bold text-lg font-inter">Email Us</h3>
                            <p class="text-text-body font-inter">Send us a message anytime!</p>
                            <a class="text-primary font-medium hover:underline font-inter"
                                href="mailto:support@tanami.ag">support@tanami.ag</a>
                        </div>
                    </div>
                </div>
                <div
                    class="w-full h-64 md:h-72 rounded-xl overflow-hidden shadow-sm border border-gray-200 relative group">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3953.2818903270895!2d110.4064711757746!3d-7.7598995769579995!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7a599bd3bdc4ef%3A0x6f1714b0c4544586!2sUniversitas%20Amikom%20Yogyakarta!5e0!3m2!1sid!2sid!4v1769420606696!5m2!1sid!2sid"
                        width="100%"
                        height="100%"
                        style="border:0;"
                        allowfullscreen=""
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            </div>
            <div class="lg:col-span-7 order-1 lg:order-2">
                <div
                    class="bg-white dark:bg-[#1e281a] rounded-xl shadow-lg border border-gray-100 dark:border-white/5 p-6 md:p-10">
                    <form id="contact-form" action="{{ route('kontak.store') }}" class="flex flex-col gap-6" method="POST">
                        @csrf
                        <div id="status-message" class="hidden p-4 rounded-lg text-sm font-medium"></div>

                        <div class="flex flex-col gap-2">
                            <label class="text-text-heading text-sm font-semibold uppercase tracking-wide font-inter"
                                for="name">Full Name</label>
                            <div class="relative">
                                <input
                                    class="w-full h-14 rounded-lg bg-background-light dark:bg-black/20 border border-[#dfe5dc] px-4 text-base text-text-heading placeholder-[#9ca3af] focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all duration-200 font-inter"
                                    id="name" name="name" placeholder="Enter your full name" type="text" required />
                                <div
                                    class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none">
                                    <span class="material-symbols-outlined text-xl">person</span>
                                </div>
                            </div>
                            <span class="text-red-500 text-xs mt-1 hidden" id="error-name"></span>
                        </div>
                        <div class="flex flex-col gap-2">
                            <label class="text-text-heading text-sm font-semibold uppercase tracking-wide font-inter"
                                for="email">Email Address</label>
                            <div class="relative">
                                <input
                                    class="w-full h-14 rounded-lg bg-background-light dark:bg-black/20 border border-[#dfe5dc] px-4 text-base text-text-heading placeholder-[#9ca3af] focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all duration-200 font-inter"
                                    id="email" name="email" placeholder="you@example.com" type="email" required />
                                <div
                                    class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none">
                                    <span class="material-symbols-outlined text-xl">alternate_email</span>
                                </div>
                            </div>
                            <span class="text-red-500 text-xs mt-1 hidden" id="error-email"></span>
                        </div>
                        <div class="flex flex-col gap-2">
                            <label class="text-text-heading text-sm font-semibold uppercase tracking-wide font-inter"
                                for="subject">Subject</label>
                            <div class="relative">
                                <select
                                    class="w-full h-14 rounded-lg bg-background-light dark:bg-black/20 border border-[#dfe5dc] px-4 text-base text-text-heading focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all duration-200 appearance-none font-inter"
                                    id="subject" name="subject" required>
                                    <option value="">Select a subject</option>
                                    <option value="General Inquiry">General Inquiry</option>
                                    <option value="Product Support">Product Support</option>
                                    <option value="Partnership">Partnership</option>
                                    <option value="Wholesale Orders">Wholesale Orders</option>
                                </select>
                                <div
                                    class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none">
                                    <span class="material-symbols-outlined text-xl">expand_more</span>
                                </div>
                            </div>
                            <span class="text-red-500 text-xs mt-1 hidden" id="error-subject"></span>
                        </div>
                        <div class="flex flex-col gap-2">
                            <label class="text-text-heading text-sm font-semibold uppercase tracking-wide font-inter"
                                for="message">Your Message</label>
                            <textarea
                                class="w-full min-h-36 rounded-lg bg-background-light dark:bg-black/20 border border-[#dfe5dc] p-4 text-base text-text-heading placeholder-[#9ca3af] focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all duration-200 resize-y font-inter"
                                id="message" name="message" placeholder="How can we help you?" required></textarea>
                            <span class="text-red-500 text-xs mt-1 hidden" id="error-message"></span>
                        </div>
                        <button
                            id="submit-btn"
                            class="mt-2 w-full h-14 bg-primary hover:bg-primary-dark text-white text-base font-bold rounded-lg transition-colors shadow-md hover:shadow-lg flex items-center justify-center gap-2 group font-jakarta disabled:opacity-70 disabled:cursor-not-allowed"
                            type="submit">
                            <span id="btn-text">Send Message</span>
                            <span id="btn-loader" class="hidden animate-spin">
                                <svg class="h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </span>
                            <span id="btn-icon"
                                class="material-symbols-outlined text-xl group-hover:translate-x-1 transition-transform">send</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@push('scripts')
<script>
    document.getElementById('contact-form').addEventListener('submit', async function(e) {
        e.preventDefault();

        const form = this;
        const submitBtn = document.getElementById('submit-btn');
        const btnText = document.getElementById('btn-text');
        const btnLoader = document.getElementById('btn-loader');
        const btnIcon = document.getElementById('btn-icon');
        const statusMsg = document.getElementById('status-message');

        // Reset errors
        document.querySelectorAll('[id^="error-"]').forEach(el => {
            el.classList.add('hidden');
            el.textContent = '';
        });
        statusMsg.classList.add('hidden');
        statusMsg.className = 'hidden p-4 rounded-lg text-sm font-medium';

        // Loading state
        submitBtn.disabled = true;
        btnText.textContent = 'Sending...';
        btnLoader.classList.remove('hidden');
        btnIcon.classList.add('hidden');

        try {
            const formData = new FormData(form);
            const response = await fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            });

            const result = await response.json();

            if (response.ok) {
                // Success
                statusMsg.textContent = result.message;
                statusMsg.classList.remove('hidden');
                statusMsg.classList.add('bg-green-100', 'text-green-800');
                form.reset();
            } else if (response.status === 422) {
                // Validation Errors
                Object.keys(result.errors).forEach(key => {
                    const errorEl = document.getElementById(`error-${key}`);
                    if (errorEl) {
                        errorEl.textContent = result.errors[key][0];
                        errorEl.classList.remove('hidden');
                    }
                });
                statusMsg.textContent = 'Please fix the errors below.';
                statusMsg.classList.remove('hidden');
                statusMsg.classList.add('bg-red-100', 'text-red-800');
            } else {
                // Other Errors
                statusMsg.textContent = result.message || 'An error occurred. Please try again.';
                statusMsg.classList.remove('hidden');
                statusMsg.classList.add('bg-red-100', 'text-red-800');
            }
        } catch (error) {
            console.error('Error:', error);
            statusMsg.textContent = 'Network error. Please check your connection.';
            statusMsg.classList.remove('hidden');
            statusMsg.classList.add('bg-red-100', 'text-red-800');
        } finally {
            // Restore button state
            submitBtn.disabled = false;
            btnText.textContent = 'Send Message';
            btnLoader.classList.add('hidden');
            btnIcon.classList.remove('hidden');

            // Scroll to status message
            statusMsg.scrollIntoView({
                behavior: 'smooth',
                block: 'center'
            });
        }
    });
</script>
@endpush