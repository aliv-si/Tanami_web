@extends('layouts.admin')

@php $active = 'pengguna'; @endphp

@section('title', 'Tanami - Farmers Management')
@section('header_title', 'Farmers Management')

@section('content')
    <div class="max-w-[1400px] mx-auto space-y-8">

        <div class="flex items-center gap-2 text-xs font-medium text-gray-400 mb-1">
                <span>Dashboard</span>
                <span class="material-symbols-outlined text-[10px]">chevron_right</span>
                <span class="flex items-center gap-2 text-xs font-medium text-gray-400 mb-1">User Management</span>
                <span class="material-symbols-outlined text-[10px]">chevron_right</span>
                <span class="text-primary">Farmer </span>
            </div>

        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
            <div>
                <h1 class="text-2xl font-heading font-bold text-[#1e3f1b]">Farmers Management</h1>
                <p class="text-gray-500 text-sm mt-1">Verify and manage registered farmers</p>
            </div>
            <div class="flex items-center gap-3 flex-wrap">
                <div class="relative group">
                    <span
                        class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400 group-focus-within:text-primary transition-colors">
                        <span class="material-symbols-outlined text-[20px]">search</span>
                    </span>
                    <input
                        class="w-64 pl-10 pr-4 py-2 rounded-lg bg-white border border-gray-200 focus:ring-2 focus:ring-primary/20 focus:border-primary text-sm font-sans placeholder-gray-400 text-gray-700 transition-all shadow-sm"
                        placeholder="Search farmers..." type="text" />
                </div>
                <div class="relative">
                    <select
                        class="appearance-none bg-white border border-gray-200 text-gray-700 py-2 pl-4 pr-10 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary shadow-sm cursor-pointer font-medium">
                        <option>All Status</option>
                        <option>Pending</option>
                        <option>Verified</option>
                        <option>Rejected</option>
                    </select>
                    <div
                        class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-500">
                        <span class="material-symbols-outlined text-sm">expand_more</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr
                            class="bg-gray-50/50 text-xs text-gray-500 font-bold uppercase border-b border-gray-200 font-heading tracking-wider">
                            <th class="py-4 pl-6 pr-4">Farmer</th>
                            <th class="py-4 px-4">Email</th>
                            <th class="py-4 px-4">Phone</th>
                            <th class="py-4 px-4">City</th>
                            <th class="py-4 px-4">Status</th>
                            <th class="py-4 px-4">Joined Date</th>
                            <th class="py-4 px-4 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm font-sans divide-y divide-gray-100">
                        <tr class="group hover:bg-gray-50 transition-colors">
                            <td class="py-4 pl-6 pr-4">
                                <div class="flex items-center gap-3">
                                    <img alt="Farmer"
                                        class="size-10 rounded-full object-cover ring-2 ring-gray-100"
                                        src="https://lh3.googleusercontent.com/aida-public/AB6AXuD2FFsaegNFK-wUMoVYb02fpvVLxlyPRLTYdqlCo5sI2W_VLJAK0dw_2aC7YvjTKwEWAfF5vq0X4TdDP6AJeRWNpue7-iDuIwkFq1TiF8rOAQrOeguRKoUc5PhtQT6g0zCzVQyLBxHD7Mv5SRAY5ogBOPaX9W8B5Lmd-aLH_SI5B28iN1zeJnZ6ZrFwrS9cl4ooBnQGwmbsunhtadAMcNNFgDadxcmth12Ti-90PByqqCvmUQWCRds6PllX866P8RdLl9x4Knj2YPV5" />
                                    <div>
                                        <div class="font-bold text-[#1e3f1b]">Robert Fox</div>
                                        <div class="text-xs text-gray-400">ID: #FMR-8821</div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-4 text-gray-600">robert.fox@example.com</td>
                            <td class="py-4 px-4 text-gray-600">+1 (555) 012-4521</td>
                            <td class="py-4 px-4 text-gray-600">Portland, OR</td>
                            <td class="py-4 px-4">
                                <span
                                    class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-700 border border-amber-200">
                                    Pending
                                </span>
                            </td>
                            <td class="py-4 px-4 text-gray-600">Oct 24, 2023</td>
                            <td class="py-4 px-4">
                                <div class="flex items-center justify-center gap-2">
                                    <button
                                        class="p-1.5 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded transition-colors"
                                        title="View Details">
                                        <span class="material-symbols-outlined text-[20px]">visibility</span>
                                    </button>
                                    <button
                                        class="p-1.5 text-gray-400 hover:text-primary hover:bg-green-50 rounded transition-colors"
                                        title="Approve">
                                        <span class="material-symbols-outlined text-[20px]">check_circle</span>
                                    </button>
                                    <button
                                        class="p-1.5 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded transition-colors"
                                        title="Reject">
                                        <span class="material-symbols-outlined text-[20px]">cancel</span>
                                    </button>
                                    <div class="w-[1px] h-4 bg-gray-200 mx-1"></div>
                                    <button
                                        class="p-1.5 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded transition-colors"
                                        title="Delete">
                                        <span class="material-symbols-outlined text-[20px]">delete</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr class="group hover:bg-gray-50 transition-colors">
                            <td class="py-4 pl-6 pr-4">
                                <div class="flex items-center gap-3">
                                    <img alt="Farmer"
                                        class="size-10 rounded-full object-cover ring-2 ring-gray-100"
                                        src="https://lh3.googleusercontent.com/aida-public/AB6AXuBRHjfDTqtlRIoYd-024fK-1dThS8_ttQLbnzB3gWFeAjZJETtomsW8e1Xf07A4aEOlT3D-9zA5axSo_9yMXFqtAZLFzglO17iYM0wyDyG4DrW9Rz0wEarAcVGj1-TLg6KMXjLgVIjBjB4G2qgxCGL5V96k8E9eNLcNlDewmftQAhIsrvSAUfRxJKpjlhq0pkSyp0CzAS0NtJSHCDHoNKBi4tukCtDOlIY_wrrGDFn49Qa3wxxQItrWqO8_UlF9YbTuZsuxOnydT-US" />
                                    <div>
                                        <div class="font-bold text-[#1e3f1b]">Albert Flores</div>
                                        <div class="text-xs text-gray-400">ID: #FMR-8822</div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-4 text-gray-600">albert.f@example.com</td>
                            <td class="py-4 px-4 text-gray-600">+1 (555) 018-9923</td>
                            <td class="py-4 px-4 text-gray-600">Austin, TX</td>
                            <td class="py-4 px-4">
                                <span
                                    class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-primary/10 text-primary border border-primary/20">
                                    Verified
                                </span>
                            </td>
                            <td class="py-4 px-4 text-gray-600">Oct 22, 2023</td>
                            <td class="py-4 px-4">
                                <div class="flex items-center justify-center gap-2">
                                    <button
                                        class="p-1.5 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded transition-colors"
                                        title="View Details">
                                        <span class="material-symbols-outlined text-[20px]">visibility</span>
                                    </button>
                                    <div class="w-[1px] h-4 bg-gray-200 mx-1"></div>
                                    <button
                                        class="p-1.5 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded transition-colors"
                                        title="Delete">
                                        <span class="material-symbols-outlined text-[20px]">delete</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr class="group hover:bg-gray-50 transition-colors">
                            <td class="py-4 pl-6 pr-4">
                                <div class="flex items-center gap-3">
                                    <img alt="Farmer"
                                        class="size-10 rounded-full object-cover ring-2 ring-gray-100"
                                        src="https://lh3.googleusercontent.com/aida-public/AB6AXuDzMgTbP6V2U58yhe4WzxnS87_ra8vP5vJjnxMdBxYgAi76nbFvZy-7uw3hEwrUZVeymkAFt1qntcyDa9DnS0XBKJSuorYc1OMgAY8mGjxlKiBDmhZq3qjIvhKxxXJghlrq160jjDVYfs-ONvGK_Lx4xyHiaTKrRq1qstNre-lzhmH73ILm4T09TjvD7QykrTU8XN1--hHesXfi5R4AORG6mo2b03sffkhVm9QtFUI8WHl8tIkdRpJtSXkQp6UVbNjtfIP1hgDFCpMN" />
                                    <div>
                                        <div class="font-bold text-[#1e3f1b]">Jenny Wilson</div>
                                        <div class="text-xs text-gray-400">ID: #FMR-8823</div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-4 text-gray-600">jenny.w@example.com</td>
                            <td class="py-4 px-4 text-gray-600">+1 (555) 723-1102</td>
                            <td class="py-4 px-4 text-gray-600">Reno, NV</td>
                            <td class="py-4 px-4">
                                <span
                                    class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700 border border-red-200">
                                    Rejected
                                </span>
                            </td>
                            <td class="py-4 px-4 text-gray-600">Oct 21, 2023</td>
                            <td class="py-4 px-4">
                                <div class="flex items-center justify-center gap-2">
                                    <button
                                        class="p-1.5 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded transition-colors"
                                        title="View Details">
                                        <span class="material-symbols-outlined text-[20px]">visibility</span>
                                    </button>
                                    <button
                                        class="p-1.5 text-gray-400 hover:text-primary hover:bg-green-50 rounded transition-colors"
                                        title="Re-evaluate">
                                        <span class="material-symbols-outlined text-[20px]">check_circle</span>
                                    </button>
                                    <div class="w-[1px] h-4 bg-gray-200 mx-1"></div>
                                    <button
                                        class="p-1.5 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded transition-colors"
                                        title="Delete">
                                        <span class="material-symbols-outlined text-[20px]">delete</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr class="group hover:bg-gray-50 transition-colors">
                            <td class="py-4 pl-6 pr-4">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="size-10 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center font-bold text-sm ring-2 ring-gray-100">
                                        CW</div>
                                    <div>
                                        <div class="font-bold text-[#1e3f1b]">Cameron W.</div>
                                        <div class="text-xs text-gray-400">ID: #FMR-8824</div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-4 text-gray-600">cameron.w@example.com</td>
                            <td class="py-4 px-4 text-gray-600">+1 (555) 441-2993</td>
                            <td class="py-4 px-4 text-gray-600">Seattle, WA</td>
                            <td class="py-4 px-4">
                                <span
                                    class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-primary/10 text-primary border border-primary/20">
                                    Verified
                                </span>
                            </td>
                            <td class="py-4 px-4 text-gray-600">Oct 19, 2023</td>
                            <td class="py-4 px-4">
                                <div class="flex items-center justify-center gap-2">
                                    <button
                                        class="p-1.5 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded transition-colors"
                                        title="View Details">
                                        <span class="material-symbols-outlined text-[20px]">visibility</span>
                                    </button>
                                    <div class="w-[1px] h-4 bg-gray-200 mx-1"></div>
                                    <button
                                        class="p-1.5 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded transition-colors"
                                        title="Delete">
                                        <span class="material-symbols-outlined text-[20px]">delete</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr class="group hover:bg-gray-50 transition-colors">
                            <td class="py-4 pl-6 pr-4">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="size-10 rounded-full bg-orange-100 text-orange-600 flex items-center justify-center font-bold text-sm ring-2 ring-gray-100">
                                        EM</div>
                                    <div>
                                        <div class="font-bold text-[#1e3f1b]">Esther M.</div>
                                        <div class="text-xs text-gray-400">ID: #FMR-8825</div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-4 text-gray-600">esther.m@example.com</td>
                            <td class="py-4 px-4 text-gray-600">+1 (555) 992-1144</td>
                            <td class="py-4 px-4 text-gray-600">Phoenix, AZ</td>
                            <td class="py-4 px-4">
                                <span
                                    class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-700 border border-amber-200">
                                    Pending
                                </span>
                            </td>
                            <td class="py-4 px-4 text-gray-600">Oct 18, 2023</td>
                            <td class="py-4 px-4">
                                <div class="flex items-center justify-center gap-2">
                                    <button
                                        class="p-1.5 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded transition-colors"
                                        title="View Details">
                                        <span class="material-symbols-outlined text-[20px]">visibility</span>
                                    </button>
                                    <button
                                        class="p-1.5 text-gray-400 hover:text-primary hover:bg-green-50 rounded transition-colors"
                                        title="Approve">
                                        <span class="material-symbols-outlined text-[20px]">check_circle</span>
                                    </button>
                                    <button
                                        class="p-1.5 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded transition-colors"
                                        title="Reject">
                                        <span class="material-symbols-outlined text-[20px]">cancel</span>
                                    </button>
                                    <div class="w-[1px] h-4 bg-gray-200 mx-1"></div>
                                    <button
                                        class="p-1.5 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded transition-colors"
                                        title="Delete">
                                        <span class="material-symbols-outlined text-[20px]">delete</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50 flex items-center justify-between">
                <p class="text-sm text-gray-500">Showing <span class="font-bold text-gray-700">1-5</span> of
                    <span class="font-bold text-gray-700">142</span> farmers</p>
                <div class="flex gap-2">
                    <button
                        class="p-2 border border-gray-200 rounded-lg hover:bg-white hover:border-gray-300 disabled:opacity-50 disabled:cursor-not-allowed transition-colors text-gray-500"
                        disabled="">
                        <span class="material-symbols-outlined text-sm">chevron_left</span>
                    </button>
                    <button
                        class="px-3.5 py-2 bg-white border border-primary text-primary font-bold text-sm rounded-lg shadow-sm">1</button>
                    <button
                        class="px-3.5 py-2 bg-white border border-gray-200 text-gray-600 hover:bg-gray-50 hover:border-gray-300 font-medium text-sm rounded-lg transition-all">2</button>
                    <button
                        class="px-3.5 py-2 bg-white border border-gray-200 text-gray-600 hover:bg-gray-50 hover:border-gray-300 font-medium text-sm rounded-lg transition-all">3</button>
                    <span class="px-2 py-2 text-gray-400">...</span>
                    <button
                        class="px-3.5 py-2 bg-white border border-gray-200 text-gray-600 hover:bg-gray-50 hover:border-gray-300 font-medium text-sm rounded-lg transition-all">12</button>
                    <button
                        class="p-2 border border-gray-200 bg-white rounded-lg hover:bg-gray-50 hover:border-gray-300 transition-colors text-gray-600">
                        <span class="material-symbols-outlined text-sm">chevron_right</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection