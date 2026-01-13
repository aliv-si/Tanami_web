@extends('layouts.admin')

@php $active = 'pengguna'; @endphp

@section('title', 'Tanami - Admin User Profile Detail')
@section('header_title', 'User Profile Detail')

@section('content')
    <div class="max-w-[1400px] mx-auto space-y-6">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="space-y-1">
                <nav class="flex items-center text-sm font-medium text-gray-500">
                    <a class="hover:text-tanami-dark transition-colors" href="#">Dashboard</a>
                    <span class="material-symbols-outlined text-sm mx-2">chevron_right</span>
                    <a class="hover:text-tanami-dark transition-colors" href="#">Users</a>
                    <span class="material-symbols-outlined text-sm mx-2">chevron_right</span>
                    <span class="text-primary font-semibold">Detail</span>
                </nav>
                <h2 class="text-2xl font-heading font-extrabold text-tanami-dark">User Details</h2>
            </div>
            <div class="flex flex-wrap items-center gap-3">
                <button
                    class="flex items-center gap-2 px-4 py-2.5 border border-gray-300 text-gray-600 rounded-xl text-sm font-bold hover:bg-gray-50 transition-colors">
                    <span class="material-symbols-outlined text-lg">arrow_back</span>
                    Back
                </button>
                <button
                    class="flex items-center gap-2 px-4 py-2.5 bg-amber-500 text-white rounded-xl text-sm font-bold hover:bg-amber-600 shadow-sm shadow-amber-200 transition-all">
                    <span class="material-symbols-outlined text-lg">edit</span>
                    Edit User
                </button>
                <button
                    class="flex items-center gap-2 px-4 py-2.5 border border-red-200 text-red-600 rounded-xl text-sm font-bold hover:bg-red-50 transition-colors">
                    <span class="material-symbols-outlined text-lg">block</span>
                    Suspend User
                </button>
            </div>
        </div>
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-1">
                <div
                    class="bg-white rounded-2xl shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] border border-gray-50 p-6 sticky top-6">
                    <div class="flex flex-col items-center text-center pb-6 border-b border-gray-50">
                        <div class="relative mb-4">
                            <img alt="Budi Santoso"
                                class="size-24 rounded-full object-cover border-4 border-gray-50"
                                src="https://lh3.googleusercontent.com/aida-public/AB6AXuDGD88WbXJCTkS2gkfTh98syeLMz9z7-nySKgfzg5hmSf7A3VolrjXi83XJUE62VAxKwpgxeU2V2C4O1hiw1cj5IGlgTbyT3oi81ORjamTpOOJ91s1edPRKDYR1stSUdjY7gs5Yr4Pn_f0o6QKK57liXgongBYaItFeJHqoq1l5VYh991jmap3ihX8CGT00RUighnpJBGRmpGvsI88VzN209mW6-gMxR98pVVpQTowxOTBQ0gUTm4rkqHHtCiVcN31BrdKZHFFg9PTk" />
                            <div class="absolute bottom-1 right-1 bg-green-500 border-2 border-white size-6 rounded-full flex items-center justify-center"
                                title="Verified">
                                <span
                                    class="material-symbols-outlined text-white text-[14px] font-bold">check</span>
                            </div>
                        </div>
                        <h3 class="text-xl font-heading font-bold text-tanami-dark mb-1">Budi Santoso</h3>
                        <p class="text-gray-400 text-sm font-medium mb-4">budi.santoso@gmail.com</p>
                        <div class="flex items-center gap-2">
                            <span
                                class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-green-50 text-green-700 uppercase tracking-wide border border-green-100">
                                <span class="material-symbols-outlined text-sm">agriculture</span> Petani
                            </span>
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-blue-50 text-blue-700 uppercase tracking-wide border border-blue-100">
                                Active
                            </span>
                        </div>
                    </div>
                    <div class="pt-6 space-y-5">
                        <div class="flex items-start gap-4">
                            <div
                                class="size-9 rounded-lg bg-gray-50 text-gray-400 flex items-center justify-center flex-shrink-0">
                                <span class="material-symbols-outlined text-lg">call</span>
                            </div>
                            <div>
                                <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-0.5">
                                    Phone</p>
                                <p class="text-sm font-semibold text-tanami-dark">+62 812 3456 7890</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4">
                            <div
                                class="size-9 rounded-lg bg-gray-50 text-gray-400 flex items-center justify-center flex-shrink-0">
                                <span class="material-symbols-outlined text-lg">calendar_month</span>
                            </div>
                            <div>
                                <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-0.5">
                                    Joined Date</p>
                                <p class="text-sm font-semibold text-tanami-dark">15 Sep 2022</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4">
                            <div
                                class="size-9 rounded-lg bg-gray-50 text-gray-400 flex items-center justify-center flex-shrink-0">
                                <span class="material-symbols-outlined text-lg">location_on</span>
                            </div>
                            <div>
                                <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-0.5">
                                    Location</p>
                                <p class="text-sm font-semibold text-tanami-dark">Malang, Jawa Timur</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="lg:col-span-2 space-y-6">
                <div
                    class="bg-white rounded-2xl shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] border border-gray-50 p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-heading font-bold text-tanami-dark">General Information</h3>
                        <button class="text-primary hover:text-green-700 transition-colors">
                            <span class="material-symbols-outlined">edit_square</span>
                        </button>
                    </div>
                    <div class="space-y-6">
                        <div>
                            <label
                                class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Full
                                Address</label>
                            <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">
                                <p class="text-sm text-gray-700 leading-relaxed">
                                    Jl. Raya Tlogomas No. 246, Babatan, Tegalgondo, Kec. Karangploso, Kabupaten
                                    Malang, Jawa Timur 65144, Indonesia
                                </p>
                            </div>
                        </div>
                        <div>
                            <label
                                class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Bio</label>
                            <p class="text-sm text-gray-600 leading-relaxed">
                                Petani muda yang berfokus pada pengembangan pertanian organik di daerah Malang
                                Raya. Memiliki spesialisasi dalam tanaman hortikultura seperti wortel, brokoli,
                                dan selada. Berkomitmen untuk menerapkan praktik pertanian berkelanjutan dan
                                memberdayakan komunitas petani lokal.
                            </p>
                        </div>
                    </div>
                </div>
                <div
                    class="bg-white rounded-2xl shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] border border-gray-50 flex flex-col overflow-hidden">
                    <div class="p-6 border-b border-gray-50 flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-heading font-bold text-tanami-dark">Recent Activity</h3>
                            <p class="text-xs text-gray-400 font-medium mt-1">Latest actions performed by user
                            </p>
                        </div>
                        <button class="text-primary text-xs font-bold hover:underline">View All History</button>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr
                                    class="bg-gray-50/50 text-[11px] text-gray-400 font-bold uppercase tracking-wider border-b border-gray-50">
                                    <th class="px-6 py-4">Activity</th>
                                    <th class="px-6 py-4">Date</th>
                                    <th class="px-6 py-4">Status / Amount</th>
                                </tr>
                            </thead>
                            <tbody class="text-sm divide-y divide-gray-50">
                                <tr class="hover:bg-gray-50/30 transition-colors group">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="size-8 rounded-full bg-green-50 text-primary flex items-center justify-center group-hover:bg-primary group-hover:text-white transition-colors">
                                                <span class="material-symbols-outlined text-lg">add_box</span>
                                            </div>
                                            <span class="font-semibold text-tanami-dark">Menambahkan Produk Baru
                                                (Wortel Organik)</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-gray-500 text-xs">Oct 25, 2024, 09:30 AM</td>
                                    <td class="px-6 py-4">
                                        <span
                                            class="inline-flex px-2.5 py-1 rounded-full text-[10px] font-bold bg-blue-50 text-blue-700 uppercase tracking-wide">Published</span>
                                    </td>
                                </tr>
                                <tr class="hover:bg-gray-50/30 transition-colors group">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="size-8 rounded-full bg-orange-50 text-orange-600 flex items-center justify-center group-hover:bg-orange-500 group-hover:text-white transition-colors">
                                                <span
                                                    class="material-symbols-outlined text-lg">shopping_bag</span>
                                            </div>
                                            <span class="font-semibold text-tanami-dark">Menerima Pesanan
                                                #ORD-8821</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-gray-500 text-xs">Oct 24, 2024, 02:15 PM</td>
                                    <td class="px-6 py-4 font-bold text-tanami-dark">IDR 450.000</td>
                                </tr>
                                <tr class="hover:bg-gray-50/30 transition-colors group">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="size-8 rounded-full bg-gray-100 text-gray-500 flex items-center justify-center group-hover:bg-gray-600 group-hover:text-white transition-colors">
                                                <span class="material-symbols-outlined text-lg">login</span>
                                            </div>
                                            <span class="font-semibold text-tanami-dark">Login to Admin
                                                Panel</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-gray-500 text-xs">Oct 24, 2024, 08:00 AM</td>
                                    <td class="px-6 py-4">
                                        <span
                                            class="inline-flex px-2.5 py-1 rounded-full text-[10px] font-bold bg-green-50 text-green-700 uppercase tracking-wide">Success</span>
                                    </td>
                                </tr>
                                <tr class="hover:bg-gray-50/30 transition-colors group">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="size-8 rounded-full bg-purple-50 text-purple-600 flex items-center justify-center group-hover:bg-purple-500 group-hover:text-white transition-colors">
                                                <span class="material-symbols-outlined text-lg">payments</span>
                                            </div>
                                            <span class="font-semibold text-tanami-dark">Withdrawal Request
                                                #WD-299</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-gray-500 text-xs">Oct 22, 2024, 11:45 AM</td>
                                    <td class="px-6 py-4 font-bold text-tanami-dark">IDR 2.500.000</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection