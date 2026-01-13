@extends('layouts.app')

@section('title', 'Market | Tanami')

@section('content')
    <main class="flex-1 w-full max-w-[1440px] mx-auto px-6 lg:px-10 py-8">
        <div class="flex flex-wrap gap-2 mb-6 font-display">
            <a class="text-text-secondary text-sm font-medium hover:text-primary transition-colors" href="#">Home</a>
            <span class="text-text-secondary text-sm font-medium">/</span>
            <span class="text-text-main dark:text-white text-sm font-medium">Catalog</span>
        </div>
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-8">
            <div>
                <h1 class="text-text-main dark:text-white text-3xl md:text-4xl font-bold font-heading tracking-tight mb-2">
                    Agricultural Products</h1>
                <p class="text-text-secondary dark:text-gray-400 font-display">Find the best seeds, fertilizers, and tools
                    for your farm.</p>
            </div>
            <div class="flex items-center gap-3">
                <label class="hidden md:block text-sm font-medium text-text-secondary dark:text-gray-400 font-display">Sort
                    by:</label>
                <div class="relative">
                    <select
                        class="appearance-none h-10 pl-4 pr-10 rounded-lg border border-[#dfe5dc] dark:border-[#2a3825] bg-white dark:bg-[#1e2a1a] text-sm text-text-main dark:text-white focus:ring-1 focus:ring-primary focus:border-primary cursor-pointer font-display">
                        <option>Recommended</option>
                        <option>Newest Arrivals</option>
                        <option>Price: Low to High</option>
                        <option>Price: High to Low</option>
                    </select>
                    <span
                        class="material-symbols-outlined absolute right-2 top-1/2 -translate-y-1/2 text-text-secondary pointer-events-none text-lg">expand_more</span>
                </div>
            </div>
        </div>
        <div class="flex flex-col lg:flex-row gap-8">
            <aside class="w-full lg:w-64 flex-shrink-0 space-y-6">
                <div class="block lg:hidden relative">
                    <span
                        class="absolute left-3 top-1/2 -translate-y-1/2 text-text-secondary material-symbols-outlined">search</span>
                    <input class="w-full rounded-lg bg-white border border-[#dfe5dc] py-2 pl-10 pr-4 text-sm font-display"
                        placeholder="Search products..." type="text" />
                </div>
                <div
                    class="bg-white dark:bg-[#1e2a1a] rounded-xl border border-[#dfe5dc] dark:border-[#2a3825] overflow-hidden shadow-sm">
                    <div class="p-4 border-b border-[#dfe5dc] dark:border-[#2a3825] flex justify-between items-center">
                        <h3 class="font-bold text-text-main dark:text-white font-heading">Filters</h3>
                        <button class="text-xs font-medium text-primary hover:underline font-heading">Reset All</button>
                    </div>
                    <details class="group border-b border-[#dfe5dc] dark:border-[#2a3825]" open="">
                        <summary
                            class="flex cursor-pointer items-center justify-between px-4 py-3 hover:bg-gray-50 dark:hover:bg-[#253220]">
                            <span class="text-sm font-bold text-text-main dark:text-white font-heading">Categories</span>
                            <span
                                class="material-symbols-outlined text-text-secondary transition-transform group-open:rotate-180">expand_more</span>
                        </summary>
                        <div class="px-4 pb-4 pt-1 space-y-2">
                            <label class="flex items-center gap-3 cursor-pointer group/item">
                                <input checked=""
                                    class="rounded border-gray-300 text-primary focus:ring-primary w-4 h-4"
                                    type="checkbox" />
                                <span
                                    class="text-sm text-text-secondary group-hover/item:text-text-main dark:text-gray-400 dark:group-hover/item:text-white transition-colors font-display">Seeds
                                    &amp; Seedlings (12)</span>
                            </label>
                            <label class="flex items-center gap-3 cursor-pointer group/item">
                                <input class="rounded border-gray-300 text-primary focus:ring-primary w-4 h-4"
                                    type="checkbox" />
                                <span
                                    class="text-sm text-text-secondary group-hover/item:text-text-main dark:text-gray-400 dark:group-hover/item:text-white transition-colors font-display">Fertilizers
                                    (8)</span>
                            </label>
                            <label class="flex items-center gap-3 cursor-pointer group/item">
                                <input class="rounded border-gray-300 text-primary focus:ring-primary w-4 h-4"
                                    type="checkbox" />
                                <span
                                    class="text-sm text-text-secondary group-hover/item:text-text-main dark:text-gray-400 dark:group-hover/item:text-white transition-colors font-display">Farm
                                    Tools (15)</span>
                            </label>
                            <label class="flex items-center gap-3 cursor-pointer group/item">
                                <input class="rounded border-gray-300 text-primary focus:ring-primary w-4 h-4"
                                    type="checkbox" />
                                <span
                                    class="text-sm text-text-secondary group-hover/item:text-text-main dark:text-gray-400 dark:group-hover/item:text-white transition-colors font-display">Irrigation
                                    (5)</span>
                            </label>
                        </div>
                    </details>
                    <details class="group border-b border-[#dfe5dc] dark:border-[#2a3825]" open="">
                        <summary
                            class="flex cursor-pointer items-center justify-between px-4 py-3 hover:bg-gray-50 dark:hover:bg-[#253220]">
                            <span class="text-sm font-bold text-text-main dark:text-white font-heading">Price Range</span>
                            <span
                                class="material-symbols-outlined text-text-secondary transition-transform group-open:rotate-180">expand_more</span>
                        </summary>
                        <div class="px-4 pb-4 pt-1">
                            <div class="flex items-center justify-between mb-4 font-display">
                                <span class="text-xs text-text-secondary dark:text-gray-400">$0</span>
                                <span class="text-xs text-text-secondary dark:text-gray-400">$1000+</span>
                            </div>
                            <div class="relative h-1 bg-gray-200 rounded-full mb-6">
                                <div class="absolute left-0 right-1/3 top-0 h-full bg-primary rounded-full"></div>
                                <div
                                    class="absolute left-0 top-1/2 -translate-y-1/2 -translate-x-1/2 size-4 bg-white border-2 border-primary rounded-full cursor-pointer shadow-md">
                                </div>
                                <div
                                    class="absolute right-1/3 top-1/2 -translate-y-1/2 translate-x-1/2 size-4 bg-white border-2 border-primary rounded-full cursor-pointer shadow-md">
                                </div>
                            </div>
                            <div class="flex gap-2">
                                <div class="relative w-full">
                                    <span
                                        class="absolute left-3 top-1/2 -translate-y-1/2 text-xs text-text-secondary font-display">$</span>
                                    <input
                                        class="w-full pl-6 pr-2 py-1.5 text-sm border border-gray-200 rounded text-center focus:ring-primary focus:border-primary font-display"
                                        type="number" value="0" />
                                </div>
                                <span class="text-gray-400 self-center">-</span>
                                <div class="relative w-full">
                                    <span
                                        class="absolute left-3 top-1/2 -translate-y-1/2 text-xs text-text-secondary font-display">$</span>
                                    <input
                                        class="w-full pl-6 pr-2 py-1.5 text-sm border border-gray-200 rounded text-center focus:ring-primary focus:border-primary font-display"
                                        type="number" value="650" />
                                </div>
                            </div>
                        </div>
                    </details>
                    <details class="group">
                        <summary
                            class="flex cursor-pointer items-center justify-between px-4 py-3 hover:bg-gray-50 dark:hover:bg-[#253220]">
                            <span class="text-sm font-bold text-text-main dark:text-white font-heading">Brands</span>
                            <span
                                class="material-symbols-outlined text-text-secondary transition-transform group-open:rotate-180">expand_more</span>
                        </summary>
                        <div class="px-4 pb-4 pt-1 space-y-2">
                            <label class="flex items-center gap-3 cursor-pointer group/item">
                                <input class="rounded border-gray-300 text-primary focus:ring-primary w-4 h-4"
                                    type="checkbox" />
                                <span
                                    class="text-sm text-text-secondary group-hover/item:text-text-main dark:text-gray-400 dark:group-hover/item:text-white transition-colors font-display">GreenGrow</span>
                            </label>
                            <label class="flex items-center gap-3 cursor-pointer group/item">
                                <input class="rounded border-gray-300 text-primary focus:ring-primary w-4 h-4"
                                    type="checkbox" />
                                <span
                                    class="text-sm text-text-secondary group-hover/item:text-text-main dark:text-gray-400 dark:group-hover/item:text-white transition-colors font-display">EcoHarvest</span>
                            </label>
                            <label class="flex items-center gap-3 cursor-pointer group/item">
                                <input class="rounded border-gray-300 text-primary focus:ring-primary w-4 h-4"
                                    type="checkbox" />
                                <span
                                    class="text-sm text-text-secondary group-hover/item:text-text-main dark:text-gray-400 dark:group-hover/item:text-white transition-colors font-display">AgriTech
                                    Pro</span>
                            </label>
                            <label class="flex items-center gap-3 cursor-pointer group/item">
                                <input class="rounded border-gray-300 text-primary focus:ring-primary w-4 h-4"
                                    type="checkbox" />
                                <span
                                    class="text-sm text-text-secondary group-hover/item:text-text-main dark:text-gray-400 dark:group-hover/item:text-white transition-colors font-display">Nature's
                                    Best</span>
                            </label>
                        </div>
                    </details>
                </div>
            </aside>
            <div class="flex-1">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 2xl:grid-cols-4 gap-5">
                    <div
                        class="group relative flex flex-col bg-white dark:bg-[#1e2a1a] border border-[#dfe5dc] dark:border-[#2a3825] rounded-xl overflow-hidden shadow-sm hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
                        <div class="relative aspect-[4/3] w-full bg-gray-100 overflow-hidden">
                            <span
                                class="absolute top-3 left-3 bg-primary text-white text-[10px] font-bold px-2 py-0.5 rounded-md z-10 font-heading">New</span>
                            <button
                                class="absolute top-3 right-3 p-1.5 bg-white/80 dark:bg-black/50 backdrop-blur-sm rounded-full text-gray-400 hover:text-red-500 transition-colors z-10">
                                <span class="material-symbols-outlined text-[18px]">favorite</span>
                            </button>
                            <img alt="Organic Potting Soil"
                                class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105"
                                src="https://lh3.googleusercontent.com/aida-public/AB6AXuCmh4sVQKlMX9BX-L3ZbAtlvpZLOJDMB4riXgNr7o7HsA6brxZzkmyQlt3lubPR-MPHY_rwWemML0kiRshU9mZKKSeACjGUAOxPG3-jxcKjkLpAEfQ8zy_UGC6ieM-XYgnf2CJQhHsuHwXszh-J1L7rhgTE3Anp6oZa-yxWE6P08VIPTr1cmW5Lh8EPW3rYapodiIf-z20hrxvP2cJCrr9P2zPSegRJjAYSt-axCeFCG6H_ioAiXrAMAOBfVGDZb3mwzFfuVzD9Ydrj" />
                        </div>
                        <div class="p-3.5 flex flex-col flex-1">
                            <div class="flex items-center gap-0.5 mb-1.5">
                                <span
                                    class="material-symbols-outlined text-yellow-400 text-[14px] fill-current">star</span>
                                <span
                                    class="material-symbols-outlined text-yellow-400 text-[14px] fill-current">star</span>
                                <span
                                    class="material-symbols-outlined text-yellow-400 text-[14px] fill-current">star</span>
                                <span
                                    class="material-symbols-outlined text-yellow-400 text-[14px] fill-current">star</span>
                                <span class="material-symbols-outlined text-gray-300 text-[14px]">star</span>
                                <span class="text-[10px] text-text-secondary ml-1 font-display">(24)</span>
                            </div>
                            <h3
                                class="text-base font-bold text-[#1e3f1b] dark:text-white mb-1 line-clamp-2 font-heading leading-tight">
                                Premium Organic Potting Soil Mix - 5kg</h3>
                            <p class="text-xs text-text-secondary dark:text-gray-400 mb-3 line-clamp-2 font-display">
                                Nutrient-rich blend perfect for indoor and outdoor plants. 100% Organic.</p>
                            <div class="mt-auto flex items-center justify-between gap-2">
                                <span class="text-lg font-bold text-[#53be20] font-display">$18.99</span>
                                <button
                                    class="flex items-center gap-1.5 bg-primary/10 hover:bg-primary text-primary hover:text-white px-3 py-1.5 rounded-lg font-bold text-[11px] transition-all duration-300 font-heading">
                                    <span class="material-symbols-outlined text-[16px]">add_shopping_cart</span>
                                    Add to Cart
                                </button>
                            </div>
                        </div>
                    </div>
                    <div
                        class="group relative flex flex-col bg-white dark:bg-[#1e2a1a] border border-[#dfe5dc] dark:border-[#2a3825] rounded-xl overflow-hidden shadow-sm hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
                        <div class="relative aspect-[4/3] w-full bg-gray-100 overflow-hidden">
                            <span
                                class="absolute top-3 left-3 bg-orange-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-md z-10 font-heading">Sale</span>
                            <button
                                class="absolute top-3 right-3 p-1.5 bg-white/80 dark:bg-black/50 backdrop-blur-sm rounded-full text-gray-400 hover:text-red-500 transition-colors z-10">
                                <span class="material-symbols-outlined text-[18px]">favorite</span>
                            </button>
                            <img alt="Steel Garden Shovel"
                                class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105"
                                src="https://lh3.googleusercontent.com/aida-public/AB6AXuDM57pXZS1bZgCg1BuQtTN8GTolhkWZvDxImXthXIxMmiuIcrDnWfZQkPAan0d5NzDXs7jfRYFuc4hNZVF1qYjAjGg-Ua2jy1A-ttSO8fvOGI3Z9dIP8GJ-_npo1_gCy927zBn6IDDWaA8WWRQL5MI_kscWVI7lyxCU6XGIQ1cvWbjadkHeikNJnJEGTCNR-mgTGqxcV4wQVLcsID4AjnRSpcA9dg0m4kWEoH8MOJg5d5_LIBeZvIc6-6v81G0qc1PBfSNEqp8PtTig" />
                        </div>
                        <div class="p-3.5 flex flex-col flex-1">
                            <div class="flex items-center gap-0.5 mb-1.5">
                                <span
                                    class="material-symbols-outlined text-yellow-400 text-[14px] fill-current">star</span>
                                <span
                                    class="material-symbols-outlined text-yellow-400 text-[14px] fill-current">star</span>
                                <span
                                    class="material-symbols-outlined text-yellow-400 text-[14px] fill-current">star</span>
                                <span
                                    class="material-symbols-outlined text-yellow-400 text-[14px] fill-current">star</span>
                                <span
                                    class="material-symbols-outlined text-yellow-400 text-[14px] fill-current">star</span>
                                <span class="text-[10px] text-text-secondary ml-1 font-display">(128)</span>
                            </div>
                            <h3
                                class="text-base font-bold text-[#1e3f1b] dark:text-white mb-1 line-clamp-2 font-heading leading-tight">
                                Heavy Duty Stainless Steel Shovel</h3>
                            <p class="text-xs text-text-secondary dark:text-gray-400 mb-3 line-clamp-2 font-display">
                                Ergonomic handle and rust-resistant blade for tough gardening tasks.</p>
                            <div class="mt-auto flex items-center justify-between gap-2">
                                <div class="flex flex-col">
                                    <span class="text-[10px] text-gray-400 line-through font-display">$45.00</span>
                                    <span class="text-lg font-bold text-[#53be20] font-display">$34.99</span>
                                </div>
                                <button
                                    class="flex items-center gap-1.5 bg-primary/10 hover:bg-primary text-primary hover:text-white px-3 py-1.5 rounded-lg font-bold text-[11px] transition-all duration-300 font-heading">
                                    <span class="material-symbols-outlined text-[16px]">add_shopping_cart</span>
                                    Add to Cart
                                </button>
                            </div>
                        </div>
                    </div>
                    <div
                        class="group relative flex flex-col bg-white dark:bg-[#1e2a1a] border border-[#dfe5dc] dark:border-[#2a3825] rounded-xl overflow-hidden shadow-sm hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
                        <div class="relative aspect-[4/3] w-full bg-gray-100 overflow-hidden">
                            <button
                                class="absolute top-3 right-3 p-1.5 bg-white/80 dark:bg-black/50 backdrop-blur-sm rounded-full text-gray-400 hover:text-red-500 transition-colors z-10">
                                <span class="material-symbols-outlined text-[18px]">favorite</span>
                            </button>
                            <img alt="Hybrid Corn Seeds"
                                class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105"
                                src="https://lh3.googleusercontent.com/aida-public/AB6AXuDnzzL8WIBnb1j50MffomTZkKx-K-iFsF1Jrk06SquBH9jXlnWY9tGQnZilDxz0SZapWEo9zY1TyE-KBhlwJRKx8v7YbNVBjWRAt01CRK3QfHxYAPFrHuUMLHOXLxD20P7BcEdUUEViJ29z5OLLvPoe6szE_nBVL4IhpmUbRxsrtm02sfOb5dh_KLiCDQzDhtFRctHqQQpKon0jbeyjwCXjNYRA2bWDtEl1PhkVNlGp9YBmCHMoVGBes6ryQJ6HJm_RSaM0MWS11uQI" />
                        </div>
                        <div class="p-3.5 flex flex-col flex-1">
                            <div class="flex items-center gap-0.5 mb-1.5">
                                <span
                                    class="material-symbols-outlined text-yellow-400 text-[14px] fill-current">star</span>
                                <span
                                    class="material-symbols-outlined text-yellow-400 text-[14px] fill-current">star</span>
                                <span
                                    class="material-symbols-outlined text-yellow-400 text-[14px] fill-current">star</span>
                                <span
                                    class="material-symbols-outlined text-yellow-400 text-[14px] fill-current">star</span>
                                <span class="material-symbols-outlined text-gray-300 text-[14px]">star</span>
                                <span class="text-[10px] text-text-secondary ml-1 font-display">(56)</span>
                            </div>
                            <h3
                                class="text-base font-bold text-[#1e3f1b] dark:text-white mb-1 line-clamp-2 font-heading leading-tight">
                                Golden Harvest Hybrid Corn Seeds - 1kg</h3>
                            <p class="text-xs text-text-secondary dark:text-gray-400 mb-3 line-clamp-2 font-display">
                                High-yield variety suitable for various climates. Drought resistant.</p>
                            <div class="mt-auto flex items-center justify-between gap-2">
                                <span class="text-lg font-bold text-[#53be20] font-display">$12.50</span>
                                <button
                                    class="flex items-center gap-1.5 bg-primary/10 hover:bg-primary text-primary hover:text-white px-3 py-1.5 rounded-lg font-bold text-[11px] transition-all duration-300 font-heading">
                                    <span class="material-symbols-outlined text-[16px]">add_shopping_cart</span>
                                    Add to Cart
                                </button>
                            </div>
                        </div>
                    </div>
                    <div
                        class="group relative flex flex-col bg-white dark:bg-[#1e2a1a] border border-[#dfe5dc] dark:border-[#2a3825] rounded-xl overflow-hidden shadow-sm hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
                        <div class="relative aspect-[4/3] w-full bg-gray-100 overflow-hidden">
                            <button
                                class="absolute top-3 right-3 p-1.5 bg-white/80 dark:bg-black/50 backdrop-blur-sm rounded-full text-gray-400 hover:text-red-500 transition-colors z-10">
                                <span class="material-symbols-outlined text-[18px]">favorite</span>
                            </button>
                            <img alt="Modern Watering Can"
                                class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105"
                                src="https://lh3.googleusercontent.com/aida-public/AB6AXuCDyhO5Ou65My3nPvmzvVGIBZWkDmrjqDS-X6-q44sZ-Y1EF3ErwqlBFekb_Ctebga2x7OTH6emmVnJtJJqW9QoyBlPmllSNXfYdgBCbjgQlMQuZ7bsSQMKcymeKdu9G-2mC4Rk9SbER9yasGO14HK6Uwo38t5KPoIcMZNTXP75jF2Uj9HatVODHPqWWCuBU7a8-A-aZQ7e33aqSsiQp3kuojTFWT0LiE-gehAXgXw8Op0BTrDpiCqMHvZrXgDhK7k8WHmqZsB8p1oF" />
                        </div>
                        <div class="p-3.5 flex flex-col flex-1">
                            <div class="flex items-center gap-0.5 mb-1.5">
                                <span
                                    class="material-symbols-outlined text-yellow-400 text-[14px] fill-current">star</span>
                                <span
                                    class="material-symbols-outlined text-yellow-400 text-[14px] fill-current">star</span>
                                <span
                                    class="material-symbols-outlined text-yellow-400 text-[14px] fill-current">star</span>
                                <span class="material-symbols-outlined text-gray-300 text-[14px]">star</span>
                                <span class="material-symbols-outlined text-gray-300 text-[14px]">star</span>
                                <span class="text-[10px] text-text-secondary ml-1 font-display">(15)</span>
                            </div>
                            <h3
                                class="text-base font-bold text-[#1e3f1b] dark:text-white mb-1 line-clamp-2 font-heading leading-tight">
                                Modern Compact Watering Can - 2L</h3>
                            <p class="text-xs text-text-secondary dark:text-gray-400 mb-3 line-clamp-2 font-display">
                                Stylish and functional design for indoor plant care. Durable plastic.</p>
                            <div class="mt-auto flex items-center justify-between gap-2">
                                <span class="text-lg font-bold text-[#53be20] font-display">$15.00</span>
                                <button
                                    class="flex items-center gap-1.5 bg-primary/10 hover:bg-primary text-primary hover:text-white px-3 py-1.5 rounded-lg font-bold text-[11px] transition-all duration-300 font-heading">
                                    <span class="material-symbols-outlined text-[16px]">add_shopping_cart</span>
                                    Add to Cart
                                </button>
                            </div>
                        </div>
                    </div>
                    <div
                        class="group relative flex flex-col bg-white dark:bg-[#1e2a1a] border border-[#dfe5dc] dark:border-[#2a3825] rounded-xl overflow-hidden shadow-sm hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
                        <div class="relative aspect-[4/3] w-full bg-gray-100 overflow-hidden">
                            <span
                                class="absolute top-3 left-3 bg-blue-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-md z-10 font-heading">Best
                                Seller</span>
                            <button
                                class="absolute top-3 right-3 p-1.5 bg-white/80 dark:bg-black/50 backdrop-blur-sm rounded-full text-gray-400 hover:text-red-500 transition-colors z-10">
                                <span class="material-symbols-outlined text-[18px]">favorite</span>
                            </button>
                            <img alt="All-Purpose Fertilizer"
                                class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105"
                                src="https://lh3.googleusercontent.com/aida-public/AB6AXuCVNrKVLAuW3Tn9HTZ0o0J3AUCE1iEGHMj-b8GnsoZIBbLocg5Zxw1WAbMgqWhCEjDgUKJ6CIj9HMoL09glubWc2hH8r0IPlm2wsXrdPNdnVm6zSKcZUD1O4f5RvXD4r1POGqS2FTsDiIGBKwZ3tuSy3rN6uP-jAlROu47tfhrk9Ub6cBGEUfjUpiF4a0VvSdONykEsp5a5A_60vyUtL9wxsAXJPkbtYtMGhUtocUZM-pGIA6vJrTuTE7wrmZbhO9bVrsFgkoKuXarZ" />
                        </div>
                        <div class="p-3.5 flex flex-col flex-1">
                            <div class="flex items-center gap-0.5 mb-1.5">
                                <span
                                    class="material-symbols-outlined text-yellow-400 text-[14px] fill-current">star</span>
                                <span
                                    class="material-symbols-outlined text-yellow-400 text-[14px] fill-current">star</span>
                                <span
                                    class="material-symbols-outlined text-yellow-400 text-[14px] fill-current">star</span>
                                <span
                                    class="material-symbols-outlined text-yellow-400 text-[14px] fill-current">star</span>
                                <span
                                    class="material-symbols-outlined text-yellow-400 text-[14px] fill-current">star</span>
                                <span class="text-[10px] text-text-secondary ml-1 font-display">(342)</span>
                            </div>
                            <h3
                                class="text-base font-bold text-[#1e3f1b] dark:text-white mb-1 line-clamp-2 font-heading leading-tight">
                                GrowFast All-Purpose Fertilizer - 10kg</h3>
                            <p class="text-xs text-text-secondary dark:text-gray-400 mb-3 line-clamp-2 font-display">
                                Balanced NPK formula for vegetables, flowers, and lawns.</p>
                            <div class="mt-auto flex items-center justify-between gap-2">
                                <span class="text-lg font-bold text-[#53be20] font-display">$29.99</span>
                                <button
                                    class="flex items-center gap-1.5 bg-primary/10 hover:bg-primary text-primary hover:text-white px-3 py-1.5 rounded-lg font-bold text-[11px] transition-all duration-300 font-heading">
                                    <span class="material-symbols-outlined text-[16px]">add_shopping_cart</span>
                                    Add to Cart
                                </button>
                            </div>
                        </div>
                    </div>
                    <div
                        class="group relative flex flex-col bg-white dark:bg-[#1e2a1a] border border-[#dfe5dc] dark:border-[#2a3825] rounded-xl overflow-hidden shadow-sm hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
                        <div class="relative aspect-[4/3] w-full bg-gray-100 overflow-hidden">
                            <button
                                class="absolute top-3 right-3 p-1.5 bg-white/80 dark:bg-black/50 backdrop-blur-sm rounded-full text-gray-400 hover:text-red-500 transition-colors z-10">
                                <span class="material-symbols-outlined text-[18px]">favorite</span>
                            </button>
                            <img alt="Pruning Shears"
                                class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105"
                                src="https://lh3.googleusercontent.com/aida-public/AB6AXuBLRoNisxsUDfCrOeM8PmeRjXP4Aad5TZ17ZrTi_v7OsHbSGiB6xyzPGMkmUWCqFrsK84eiUwF0sR6HMOWKOg3vQVT2kPIaIjPkTO2QMHNnAcdVjF3854yWeMeUxDlpMVHw2sZmMmsnH5WcZxkbEz0znMa1cN9LJ6eTo1373we90FTOdZrUt6TFFbWQSmuPItPsWsQ3PFzInG-0tLFseah4qoQTjShYMoPx-0tih2__JOXtJuqBOjV0nMHyShsvpAzgM2G1HlQtu6yy" />
                        </div>
                        <div class="p-3.5 flex flex-col flex-1">
                            <div class="flex items-center gap-0.5 mb-1.5">
                                <span
                                    class="material-symbols-outlined text-yellow-400 text-[14px] fill-current">star</span>
                                <span
                                    class="material-symbols-outlined text-yellow-400 text-[14px] fill-current">star</span>
                                <span
                                    class="material-symbols-outlined text-yellow-400 text-[14px] fill-current">star</span>
                                <span
                                    class="material-symbols-outlined text-yellow-400 text-[14px] fill-current">star</span>
                                <span class="material-symbols-outlined text-gray-300 text-[14px]">star</span>
                                <span class="text-[10px] text-text-secondary ml-1 font-display">(45)</span>
                            </div>
                            <h3
                                class="text-base font-bold text-[#1e3f1b] dark:text-white mb-1 line-clamp-2 font-heading leading-tight">
                                Precision Steel Pruning Shears</h3>
                            <p class="text-xs text-text-secondary dark:text-gray-400 mb-3 line-clamp-2 font-display">Sharp,
                                durable blades for clean cuts on stems and branches.</p>
                            <div class="mt-auto flex items-center justify-between gap-2">
                                <span class="text-lg font-bold text-[#53be20] font-display">$22.00</span>
                                <button
                                    class="flex items-center gap-1.5 bg-primary/10 hover:bg-primary text-primary hover:text-white px-3 py-1.5 rounded-lg font-bold text-[11px] transition-all duration-300 font-heading">
                                    <span class="material-symbols-outlined text-[16px]">add_shopping_cart</span>
                                    Add to Cart
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex items-center justify-center mt-12 gap-2">
                    <button
                        class="flex h-10 w-10 items-center justify-center rounded-lg border border-[#dfe5dc] bg-white dark:bg-[#1e2a1a] dark:border-[#2a3825] dark:text-white hover:bg-gray-50 dark:hover:bg-[#253220] transition-colors disabled:opacity-50"
                        disabled="">
                        <span class="material-symbols-outlined text-sm">chevron_left</span>
                    </button>
                    <button
                        class="flex h-10 w-10 items-center justify-center rounded-lg bg-primary text-white font-semibold transition-colors font-display">1</button>
                    <button
                        class="flex h-10 w-10 items-center justify-center rounded-lg border border-[#dfe5dc] bg-white dark:bg-[#1e2a1a] dark:border-[#2a3825] text-text-main dark:text-white hover:bg-gray-50 dark:hover:bg-[#253220] transition-colors font-display">2</button>
                    <button
                        class="flex h-10 w-10 items-center justify-center rounded-lg border border-[#dfe5dc] bg-white dark:bg-[#1e2a1a] dark:border-[#2a3825] text-text-main dark:text-white hover:bg-gray-50 dark:hover:bg-[#253220] transition-colors font-display">3</button>
                    <span class="flex h-10 w-10 items-center justify-center text-text-secondary font-display">...</span>
                    <button
                        class="flex h-10 w-10 items-center justify-center rounded-lg border border-[#dfe5dc] bg-white dark:bg-[#1e2a1a] dark:border-[#2a3825] text-text-main dark:text-white hover:bg-gray-50 dark:hover:bg-[#253220] transition-colors font-display">8</button>
                    <button
                        class="flex h-10 w-10 items-center justify-center rounded-lg border border-[#dfe5dc] bg-white dark:bg-[#1e2a1a] dark:border-[#2a3825] dark:text-white hover:bg-gray-50 dark:hover:bg-[#253220] transition-colors">
                        <span class="material-symbols-outlined text-sm">chevron_right</span>
                    </button>
                </div>
            </div>
        </div>
    </main>
@endsection
