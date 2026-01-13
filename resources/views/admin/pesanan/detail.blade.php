@extends('layouts.admin')

@php $active = 'pesanan'; @endphp

@section('title', 'Tanami - Admin Order Detail')
@section('header_title', 'Order Detail')

@section('content')
    <div class="max-w-[1400px] mx-auto space-y-8">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
            <div class="space-y-2">
                <div class="flex items-center gap-2 text-xs font-semibold text-gray-400 uppercase tracking-wide">
                    <span class="hover:text-primary cursor-pointer transition-colors">Dashboard</span>
                    <span class="material-symbols-outlined text-[10px]">arrow_forward_ios</span>
                    <span class="hover:text-primary cursor-pointer transition-colors">Orders</span>
                    <span class="material-symbols-outlined text-[10px]">arrow_forward_ios</span>
                    <span class="text-primary">Detail</span>
                </div>
                <h2 class="text-3xl font-heading font-extrabold text-tanami-dark flex items-center gap-4">
                    Order #ORD-7782
                    <span
                        class="px-3 py-1 rounded-full bg-blue-50 text-blue-600 border border-blue-100 text-xs font-bold uppercase tracking-wide">Shipped</span>
                </h2>
                <p class="text-sm text-gray-500 font-medium">Placed on Oct 24, 2024 at 10:34 AM</p>
            </div>
            <div class="flex items-center gap-3">
                <button
                    class="px-4 py-2.5 bg-white border border-gray-200 text-gray-600 rounded-xl text-sm font-bold hover:bg-gray-50 hover:text-tanami-dark hover:border-gray-300 transition-all flex items-center gap-2 shadow-sm">
                    <span class="material-symbols-outlined text-lg">arrow_back</span>
                    Back
                </button>
                <button
                    class="px-4 py-2.5 bg-white border border-gray-200 text-gray-600 rounded-xl text-sm font-bold hover:bg-gray-50 hover:text-tanami-dark hover:border-gray-300 transition-all flex items-center gap-2 shadow-sm">
                    <span class="material-symbols-outlined text-lg">print</span>
                    Print Invoice
                </button>
                <button
                    class="px-5 py-2.5 bg-primary text-white rounded-xl text-sm font-bold hover:bg-green-600 transition-all shadow-[0_4px_10px_-2px_rgba(83,190,32,0.4)] flex items-center gap-2">
                    <span class="material-symbols-outlined text-lg">check_circle</span>
                    Mark as Completed
                </button>
            </div>
        </div>
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 space-y-8">
                <div
                    class="bg-white rounded-2xl border border-gray-100 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)] overflow-hidden">
                    <div class="p-6 border-b border-gray-50 flex items-center justify-between">
                        <h3 class="text-lg font-heading font-bold text-tanami-dark">Item List</h3>
                        <span class="text-xs font-bold text-gray-400 bg-gray-50 px-2 py-1 rounded-md">1
                            Item</span>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead class="bg-gray-50/50">
                                <tr class="text-[11px] text-gray-400 font-bold uppercase tracking-wider">
                                    <th class="px-6 py-4">Product</th>
                                    <th class="px-6 py-4">Price</th>
                                    <th class="px-6 py-4 text-center">Qty</th>
                                    <th class="px-6 py-4 text-right">Total</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                <tr class="hover:bg-gray-50/30 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-4">
                                            <div
                                                class="size-16 rounded-lg bg-orange-50 border border-orange-100 flex items-center justify-center flex-shrink-0 text-orange-500">
                                                <span class="material-symbols-outlined text-3xl">nutrition</span>
                                            </div>
                                            <div>
                                                <p class="font-heading font-bold text-tanami-dark text-sm">
                                                    Wortel Brastagi</p>
                                                <p class="text-xs text-gray-500 mt-0.5">Fresh Organic Category
                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm font-medium text-gray-600">
                                        Rp 15.000
                                    </td>
                                    <td class="px-6 py-4 text-center text-sm font-medium text-gray-600">
                                        10 kg
                                    </td>
                                    <td class="px-6 py-4 text-right font-bold text-tanami-dark">
                                        Rp 150.000
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div
                    class="bg-white rounded-2xl border border-gray-100 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)] p-6">
                    <h3 class="text-lg font-heading font-bold text-tanami-dark mb-6">Payment Summary</h3>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-500 font-medium">Subtotal</span>
                            <span class="font-bold text-tanami-dark">Rp 150.000</span>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-500 font-medium">Shipping Cost</span>
                            <span class="font-bold text-tanami-dark">Rp 0 (Free)</span>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-500 font-medium">Tax (10%)</span>
                            <span class="font-bold text-tanami-dark">Included</span>
                        </div>
                        <div class="h-px bg-gray-100 my-4"></div>
                        <div class="flex justify-between items-center">
                            <span class="text-base font-bold text-tanami-dark">Grand Total</span>
                            <span class="text-xl font-heading font-extrabold text-primary">Rp 150.000</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="space-y-8">
                <div
                    class="bg-white rounded-2xl border border-gray-100 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)] overflow-hidden">
                    <div class="p-5 border-b border-gray-50">
                        <h3 class="text-sm font-heading font-bold text-tanami-dark uppercase tracking-wide">
                            Customer & Farmer</h3>
                    </div>
                    <div class="p-5 space-y-6">
                        <div class="flex items-start gap-4">
                            <img alt="Customer" class="size-10 rounded-full bg-gray-100 object-cover"
                                src="https://lh3.googleusercontent.com/aida-public/AB6AXuD2FFsaegNFK-wUMoVYb02fpvVLxlyPRLTYdqlCo5sI2W_VLJAK0dw_2aC7YvjTKwEWAfF5vq0X4TdDP6AJeRWNpue7-iDuIwkFq1TiF8rOAQrOeguRKoUc5PhtQT6g0zCzVQyLBxHD7Mv5SRAY5ogBOPaX9W8B5Lmd-aLH_SI5B28iN1zeJnZ6ZrFwrS9cl4ooBnQGwmbsunhtadAMcNNFgDadxcmth12Ti-90PByqqCvmUQWCRds6PllX866P8RdLl9x4Knj2YPV5" />
                            <div>
                                <p class="text-sm font-bold text-tanami-dark">Robert Fox</p>
                                <p class="text-xs text-gray-500 mb-2">Customer</p>
                                <div class="flex items-center gap-2 text-xs text-gray-500">
                                    <span class="material-symbols-outlined text-[14px]">call</span>
                                    +62 812 3456 7890
                                </div>
                            </div>
                        </div>
                        <div class="h-px bg-gray-50"></div>
                        <div class="flex items-start gap-4">
                            <div
                                class="size-10 rounded-full bg-green-100 text-primary flex items-center justify-center font-bold text-sm">
                                JW</div>
                            <div>
                                <p class="text-sm font-bold text-tanami-dark">Jenny Wilson</p>
                                <p class="text-xs text-gray-500 mb-2">Farmer / Seller</p>
                                <div class="flex items-center gap-2 text-xs text-gray-500">
                                    <span class="material-symbols-outlined text-[14px]">call</span>
                                    +62 819 0876 5432
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div
                    class="bg-white rounded-2xl border border-gray-100 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)] overflow-hidden">
                    <div class="p-5 border-b border-gray-50 flex justify-between items-center">
                        <h3 class="text-sm font-heading font-bold text-tanami-dark uppercase tracking-wide">
                            Shipping Info</h3>
                        <span class="material-symbols-outlined text-gray-400 text-lg">local_shipping</span>
                    </div>
                    <div class="p-5 space-y-4">
                        <div>
                            <p class="text-xs text-gray-400 font-bold uppercase mb-1">Shipping Address</p>
                            <p class="text-sm text-gray-600 leading-relaxed">
                                Jl. Sudirman No. 45, Komplek Green Garden Block C2, Jakarta Selatan, 12190
                            </p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 font-bold uppercase mb-1">Courier Service</p>
                            <div class="flex items-center gap-2">
                                <span class="font-bold text-tanami-dark text-sm">JNE Express</span>
                                <span
                                    class="px-2 py-0.5 rounded text-[10px] font-bold bg-gray-100 text-gray-600">REG</span>
                            </div>
                            <p class="text-xs text-primary mt-1 font-medium hover:underline cursor-pointer">
                                Track: JNE882910022</p>
                        </div>
                    </div>
                </div>
                <div
                    class="bg-white rounded-2xl border border-gray-100 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)] overflow-hidden">
                    <div class="p-5 border-b border-gray-50">
                        <h3 class="text-sm font-heading font-bold text-tanami-dark uppercase tracking-wide">
                            Order History</h3>
                    </div>
                    <div class="p-6">
                        <div class="flex flex-col">
                            <div class="timeline-item">
                                <div class="timeline-line"></div>
                                <div class="timeline-dot completed">
                                    <span class="material-symbols-outlined text-white text-[14px]">check</span>
                                </div>
                                <div>
                                    <h4 class="text-sm font-bold text-tanami-dark">Order Placed</h4>
                                    <p class="text-xs text-gray-500 mt-0.5">Oct 24, 2024 - 10:34 AM</p>
                                </div>
                            </div>
                            <div class="timeline-item">
                                <div class="timeline-line"></div>
                                <div class="timeline-dot completed">
                                    <span class="material-symbols-outlined text-white text-[14px]">check</span>
                                </div>
                                <div>
                                    <h4 class="text-sm font-bold text-tanami-dark">Payment Confirmed</h4>
                                    <p class="text-xs text-gray-500 mt-0.5">Oct 24, 2024 - 10:45 AM</p>
                                </div>
                            </div>
                            <div class="timeline-item">
                                <div class="timeline-line"></div>
                                <div class="timeline-dot completed">
                                    <span class="material-symbols-outlined text-white text-[14px]">check</span>
                                </div>
                                <div>
                                    <h4 class="text-sm font-bold text-tanami-dark">Processed by Farmer</h4>
                                    <p class="text-xs text-gray-500 mt-0.5">Oct 24, 2024 - 02:15 PM</p>
                                </div>
                            </div>
                            <div class="timeline-item">
                                <div class="timeline-line"></div>
                                <div class="timeline-dot active">
                                    <span class="size-2 bg-white rounded-full"></span>
                                </div>
                                <div>
                                    <h4 class="text-sm font-bold text-blue-600">Shipped</h4>
                                    <p class="text-xs text-gray-500 mt-0.5">Oct 25, 2024 - 09:30 AM</p>
                                    <p class="text-xs text-gray-400 italic mt-1">On the way to sorting hub</p>
                                </div>
                            </div>
                            <div class="timeline-item">
                                <div class="timeline-line"></div>
                                <div class="timeline-dot"></div>
                                <div>
                                    <h4 class="text-sm font-medium text-gray-400">Delivered</h4>
                                    <p class="text-xs text-gray-400 mt-0.5">Estimated Oct 27, 2024</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection