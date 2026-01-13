@extends('layouts.admin')

@php $active = 'dashboard'; @endphp

@section('title', 'Tanami - Admin Dashboard Overview')
@section('header_title', 'Admin Dashboard')

@section('content')
    <div class="max-w-[1400px] mx-auto space-y-10 p-0">
        <div class="flex flex-col gap-1">
            <h2 class="text-2xl font-heading font-extrabold text-tanami-dark">Dashboard Overview</h2>
            <p class="text-sm text-gray-500 font-medium">Monitoring Tanami agritech performance and marketplace
                activity.</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div
                class="bg-white p-6 rounded-2xl shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] border border-gray-50 hover:shadow-md transition-shadow">
                <div class="flex justify-between items-start mb-4">
                    <div class="size-11 flex items-center justify-center bg-green-50 text-primary rounded-xl">
                        <span class="material-symbols-outlined">payments</span>
                    </div>
                    <span
                        class="inline-flex items-center text-[11px] font-bold text-primary bg-green-50 px-2 py-1 rounded-md">
                        <span class="material-symbols-outlined text-sm mr-1">trending_up</span> +12.5%
                    </span>
                </div>
                <div class="space-y-1">
                    <h3 class="text-2xl font-heading font-extrabold text-tanami-dark">$482,900</h3>
                    <p class="text-gray-400 text-xs font-semibold uppercase tracking-wider">GMV</p>
                </div>
            </div>
            <div
                class="bg-white p-6 rounded-2xl shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] border border-gray-50 hover:shadow-md transition-shadow">
                <div class="flex justify-between items-start mb-4">
                    <div
                        class="size-11 flex items-center justify-center bg-orange-50 text-orange-600 rounded-xl">
                        <span class="material-symbols-outlined">receipt_long</span>
                    </div>
                    <span
                        class="inline-flex items-center text-[11px] font-bold text-primary bg-green-50 px-2 py-1 rounded-md">
                        <span class="material-symbols-outlined text-sm mr-1">trending_up</span> +5.4%
                    </span>
                </div>
                <div class="space-y-1">
                    <h3 class="text-2xl font-heading font-extrabold text-tanami-dark">3,842</h3>
                    <p class="text-gray-400 text-xs font-semibold uppercase tracking-wider">Transactions</p>
                </div>
            </div>
            <div
                class="bg-white p-6 rounded-2xl shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] border border-gray-50 hover:shadow-md transition-shadow">
                <div class="flex justify-between items-start mb-4">
                    <div class="size-11 flex items-center justify-center bg-blue-50 text-blue-600 rounded-xl">
                        <span class="material-symbols-outlined">group</span>
                    </div>
                    <span
                        class="inline-flex items-center text-[11px] font-bold text-primary bg-green-50 px-2 py-1 rounded-md">
                        <span class="material-symbols-outlined text-sm mr-1">trending_up</span> +8.2%
                    </span>
                </div>
                <div class="space-y-1">
                    <h3 class="text-2xl font-heading font-extrabold text-tanami-dark">24,592</h3>
                    <p class="text-gray-400 text-xs font-semibold uppercase tracking-wider">Total Users</p>
                </div>
            </div>
            <div
                class="bg-white p-6 rounded-2xl shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] border border-gray-50 hover:shadow-md transition-shadow">
                <div class="flex justify-between items-start mb-4">
                    <div class="size-11 flex items-center justify-center bg-gray-100 text-gray-500 rounded-xl">
                        <span class="material-symbols-outlined">admin_panel_settings</span>
                    </div>
                    <span
                        class="inline-flex items-center text-[11px] font-bold text-gray-500 bg-gray-100 px-2 py-1 rounded-md">
                        <span class="material-symbols-outlined text-sm mr-1">remove</span> 0%
                    </span>
                </div>
                <div class="space-y-1">
                    <h3 class="text-2xl font-heading font-extrabold text-tanami-dark">35</h3>
                    <p class="text-gray-400 text-xs font-semibold uppercase tracking-wider">Total Admins</p>
                </div>
            </div>
        </div>
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div
                class="lg:col-span-1 bg-white rounded-2xl border border-gray-50 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] p-6">
                <div class="flex items-center justify-between mb-8">
                    <div>
                        <h3 class="text-lg font-heading font-bold text-tanami-dark">Sales Trend</h3>
                        <p class="text-xs text-gray-400 font-medium">Daily revenue insights</p>
                    </div>
                    <div
                        class="size-8 bg-gray-50 rounded-lg flex items-center justify-center text-gray-400 cursor-pointer hover:bg-gray-100">
                        <span class="material-symbols-outlined text-sm">more_vert</span>
                    </div>
                </div>
                <div class="h-48 flex items-end justify-between gap-3 px-2">
                    <div class="flex-1 flex flex-col items-center gap-2">
                        <div class="w-full bg-primary/10 rounded-t-lg relative h-32">
                            <div class="absolute bottom-0 left-0 w-full bg-primary rounded-t-lg"
                                style="height: 45%"></div>
                        </div>
                        <span class="text-[10px] text-gray-400 font-bold uppercase">M</span>
                    </div>
                    <div class="flex-1 flex flex-col items-center gap-2">
                        <div class="w-full bg-primary/10 rounded-t-lg relative h-32">
                            <div class="absolute bottom-0 left-0 w-full bg-primary rounded-t-lg"
                                style="height: 65%"></div>
                        </div>
                        <span class="text-[10px] text-gray-400 font-bold uppercase">T</span>
                    </div>
                    <div class="flex-1 flex flex-col items-center gap-2">
                        <div class="w-full bg-primary/10 rounded-t-lg relative h-32">
                            <div class="absolute bottom-0 left-0 w-full bg-primary rounded-t-lg"
                                style="height: 35%"></div>
                        </div>
                        <span class="text-[10px] text-gray-400 font-bold uppercase">W</span>
                    </div>
                    <div class="flex-1 flex flex-col items-center gap-2">
                        <div class="w-full bg-primary/10 rounded-t-lg relative h-32">
                            <div class="absolute bottom-0 left-0 w-full bg-primary rounded-t-lg"
                                style="height: 85%"></div>
                        </div>
                        <span class="text-[10px] text-gray-400 font-bold uppercase">T</span>
                    </div>
                    <div class="flex-1 flex flex-col items-center gap-2">
                        <div class="w-full bg-primary/10 rounded-t-lg relative h-32">
                            <div class="absolute bottom-0 left-0 w-full bg-primary rounded-t-lg"
                                style="height: 55%"></div>
                        </div>
                        <span class="text-[10px] text-gray-400 font-bold uppercase">F</span>
                    </div>
                    <div class="flex-1 flex flex-col items-center gap-2">
                        <div class="w-full bg-primary/10 rounded-t-lg relative h-32">
                            <div class="absolute bottom-0 left-0 w-full bg-primary rounded-t-lg"
                                style="height: 70%"></div>
                        </div>
                        <span class="text-[10px] text-gray-400 font-bold uppercase">S</span>
                    </div>
                    <div class="flex-1 flex flex-col items-center gap-2">
                        <div class="w-full bg-primary/10 rounded-t-lg relative h-32">
                            <div class="absolute bottom-0 left-0 w-full bg-primary rounded-t-lg"
                                style="height: 50%"></div>
                        </div>
                        <span class="text-[10px] text-gray-400 font-bold uppercase">S</span>
                    </div>
                </div>
            </div>
            <div
                class="lg:col-span-2 bg-white rounded-2xl border border-gray-50 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] flex flex-col overflow-hidden">
                <div class="p-6 border-b border-gray-50 flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-heading font-bold text-tanami-dark">Recent Orders</h3>
                        <p class="text-xs text-gray-400 font-medium">Tracking latest marketplace activities</p>
                    </div>
                    <button
                        class="px-4 py-2 bg-gray-50 hover:bg-gray-100 text-gray-600 rounded-xl text-xs font-bold transition-colors">
                        View All
                    </button>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr
                                class="bg-gray-50/50 text-[11px] text-gray-400 font-bold uppercase tracking-wider">
                                <th class="px-6 py-4">No</th>
                                <th class="px-6 py-4">Order ID</th>
                                <th class="px-6 py-4">User</th>
                                <th class="px-6 py-4">Farmer</th>
                                <th class="px-6 py-4">Total</th>
                                <th class="px-6 py-4">Status</th>
                                <th class="px-6 py-4">Date</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm divide-y divide-gray-50">
                            <tr class="hover:bg-gray-50/30 transition-colors">
                                <td class="px-6 py-4 text-gray-400 font-medium">01</td>
                                <td class="px-6 py-4 font-mono text-gray-500 font-medium text-xs">#ORD-7782</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <img alt="User" class="size-8 rounded-full border border-gray-100"
                                            src="https://lh3.googleusercontent.com/aida-public/AB6AXuD2FFsaegNFK-wUMoVYb02fpvVLxlyPRLTYdqlCo5sI2W_VLJAK0dw_2aC7YvjTKwEWAfF5vq0X4TdDP6AJeRWNpue7-iDuIwkFq1TiF8rOAQrOeguRKoUc5PhtQT6g0zCzVQyLBxHD7Mv5SRAY5ogBOPaX9W8B5Lmd-aLH_SI5B28iN1zeJnZ6ZrFwrS9cl4ooBnQGwmbsunhtadAMcNNFgDadxcmth12Ti-90PByqqCvmUQWCRds6PllX866P8RdLl9x4Knj2YPV5" />
                                        <span class="font-semibold text-tanami-dark">Robert Fox</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-gray-600 font-medium">Jenny Wilson</td>
                                <td class="px-6 py-4 font-bold text-tanami-dark">$1,200.50</td>
                                <td class="px-6 py-4">
                                    <span
                                        class="inline-flex px-2.5 py-1 rounded-full text-[10px] font-bold bg-green-50 text-green-700 uppercase tracking-wide">Completed</span>
                                </td>
                                <td class="px-6 py-4 text-gray-500 text-xs">Oct 24, 2024</td>
                            </tr>
                            <tr class="hover:bg-gray-50/30 transition-colors">
                                <td class="px-6 py-4 text-gray-400 font-medium">02</td>
                                <td class="px-6 py-4 font-mono text-gray-500 font-medium text-xs">#ORD-7783</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="size-8 rounded-full bg-orange-100 text-orange-600 flex items-center justify-center font-bold text-[10px]">
                                            SJ</div>
                                        <span class="font-semibold text-tanami-dark">Sarah Jenkins</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-gray-600 font-medium">Albert Flores</td>
                                <td class="px-6 py-4 font-bold text-tanami-dark">$850.00</td>
                                <td class="px-6 py-4">
                                    <span
                                        class="inline-flex px-2.5 py-1 rounded-full text-[10px] font-bold bg-yellow-50 text-yellow-700 uppercase tracking-wide">Pending</span>
                                </td>
                                <td class="px-6 py-4 text-gray-500 text-xs">Oct 24, 2024</td>
                            </tr>
                            <tr class="hover:bg-gray-50/30 transition-colors">
                                <td class="px-6 py-4 text-gray-400 font-medium">03</td>
                                <td class="px-6 py-4 font-mono text-gray-500 font-medium text-xs">#ORD-7784</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="size-8 rounded-full bg-purple-100 text-purple-600 flex items-center justify-center font-bold text-[10px]">
                                            EW</div>
                                        <span class="font-semibold text-tanami-dark">Emma Wilson</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-gray-600 font-medium">Est. Cooper</td>
                                <td class="px-6 py-4 font-bold text-tanami-dark">$2,340.00</td>
                                <td class="px-6 py-4">
                                    <span
                                        class="inline-flex px-2.5 py-1 rounded-full text-[10px] font-bold bg-red-50 text-red-700 uppercase tracking-wide">Cancelled</span>
                                </td>
                                <td class="px-6 py-4 text-gray-500 text-xs">Oct 23, 2024</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection