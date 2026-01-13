@extends('layouts.app')

@section('title', 'Kontak | Tanami')

@section('content')
    <main class="flex-grow flex flex-col items-center justify-center py-10 px-4 md:px-10 lg:px-40 w-full">
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
                                <p class="text-text-body font-inter">123 Green Valley Road,<br />Agritech District, CA 90210
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
                        <img alt="Map showing location of Tanami farm"
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                            data-alt="Map view of green fields and farm location" data-location="Agritech District"
                            src="https://lh3.googleusercontent.com/aida-public/AB6AXuCeYLmT95MUbVyhRDtfEjk7y7Yers5yuCNL9EsZDcOJqSGTe3I3XntT717MHWPla5WUpG8A4iXHmWK-uqg44zaliL3Vgfz1wEsTTxZupUz21kAOd9Aon9s1QBhnFQJlKDkus11xDEqTpGlGZk4jB3M7ojev5YhiK28GEcAt00crorUGADRb66a_kmRTIMjgRIIEkbj9QJ0jjxMG4X8ON-Sa5Nakcu94kZlNPXZg4-q2FcZgrtoO2KDUyokUa7xVANIxqjlELrAojzYy" />
                        <div
                            class="absolute inset-0 bg-black/10 group-hover:bg-black/0 transition-colors pointer-events-none">
                        </div>
                        <div
                            class="absolute bottom-4 right-4 bg-white px-3 py-1 rounded shadow text-xs font-medium text-text-heading font-inter">
                            Google Maps
                        </div>
                    </div>
                </div>
                <div class="lg:col-span-7 order-1 lg:order-2">
                    <div
                        class="bg-white dark:bg-[#1e281a] rounded-xl shadow-lg border border-gray-100 dark:border-white/5 p-6 md:p-10">
                        <form action="#" class="flex flex-col gap-6" method="POST">
                            <div class="flex flex-col gap-2">
                                <label class="text-text-heading text-sm font-semibold uppercase tracking-wide font-inter"
                                    for="name">Full Name</label>
                                <div class="relative">
                                    <input
                                        class="w-full h-14 rounded-lg bg-background-light dark:bg-black/20 border border-[#dfe5dc] px-4 text-base text-text-heading placeholder-[#9ca3af] focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all duration-200 font-inter"
                                        id="name" name="name" placeholder="Enter your full name" type="text" />
                                    <div
                                        class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none">
                                        <span class="material-symbols-outlined text-xl">person</span>
                                    </div>
                                </div>
                            </div>
                            <div class="flex flex-col gap-2">
                                <label class="text-text-heading text-sm font-semibold uppercase tracking-wide font-inter"
                                    for="email">Email Address</label>
                                <div class="relative">
                                    <input
                                        class="w-full h-14 rounded-lg bg-background-light dark:bg-black/20 border border-[#dfe5dc] px-4 text-base text-text-heading placeholder-[#9ca3af] focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all duration-200 font-inter"
                                        id="email" name="email" placeholder="you@example.com" type="email" />
                                    <div
                                        class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none">
                                        <span class="material-symbols-outlined text-xl">alternate_email</span>
                                    </div>
                                </div>
                            </div>
                            <div class="flex flex-col gap-2">
                                <label class="text-text-heading text-sm font-semibold uppercase tracking-wide font-inter"
                                    for="subject">Subject</label>
                                <div class="relative">
                                    <select
                                        class="w-full h-14 rounded-lg bg-background-light dark:bg-black/20 border border-[#dfe5dc] px-4 text-base text-text-heading focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all duration-200 appearance-none font-inter"
                                        id="subject" name="subject">
                                        <option>General Inquiry</option>
                                        <option>Product Support</option>
                                        <option>Partnership</option>
                                        <option>Wholesale Orders</option>
                                    </select>
                                    <div
                                        class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none">
                                        <span class="material-symbols-outlined text-xl">expand_more</span>
                                    </div>
                                </div>
                            </div>
                            <div class="flex flex-col gap-2">
                                <label class="text-text-heading text-sm font-semibold uppercase tracking-wide font-inter"
                                    for="message">Your Message</label>
                                <textarea
                                    class="w-full min-h-36 rounded-lg bg-background-light dark:bg-black/20 border border-[#dfe5dc] p-4 text-base text-text-heading placeholder-[#9ca3af] focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all duration-200 resize-y font-inter"
                                    id="message" name="message" placeholder="How can we help you?"></textarea>
                            </div>
                            <button
                                class="mt-2 w-full h-14 bg-primary hover:bg-primary-dark text-white text-base font-bold rounded-lg transition-colors shadow-md hover:shadow-lg flex items-center justify-center gap-2 group font-jakarta"
                                type="submit">
                                Send Message
                                <span
                                    class="material-symbols-outlined text-xl group-hover:translate-x-1 transition-transform">send</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection