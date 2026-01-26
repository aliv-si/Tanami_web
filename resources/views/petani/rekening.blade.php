@extends('layouts.petani')

@section('title', 'Rekening Bank')

@section('content')
<header class="bg-white border-b border-gray-200 sticky top-0 z-40">
    <div class="flex items-center justify-between px-8 py-5">
        <div class="flex items-center gap-4">
            <h1 class="text-2xl font-bold font-heading text-text-dark">Bank Account</h1>
        </div>
        <div class="flex items-center gap-4">
            <button type="button" onclick="document.getElementById('tambah-modal').classList.remove('hidden')" class="bg-primary hover:bg-primary/90 text-white px-5 py-2 rounded-lg font-bold font-heading flex items-center gap-2 transition-all shadow-sm">
                <span class="material-symbols-outlined">add</span>
                Add Account
            </button>
        </div>
    </div>
</header>

<div class="p-8 max-w-[1200px] mx-auto">
    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg flex items-center gap-2">
            <span class="material-symbols-outlined">check_circle</span>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg flex items-center gap-2">
            <span class="material-symbols-outlined">error</span>
            {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg">
            <ul class="list-disc list-inside text-sm">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Bank Accounts List -->
    <div class="space-y-4">
        @forelse($rekeningList as $rekening)
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 {{ $rekening->is_utama ? 'ring-2 ring-primary' : '' }}">
            <div class="flex items-start justify-between">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-primary/10 rounded-xl flex items-center justify-center">
                        <span class="material-symbols-outlined text-primary text-2xl">account_balance</span>
                    </div>
                    <div>
                        <div class="flex items-center gap-2 mb-1">
                            <h3 class="font-heading font-bold text-text-dark">{{ $rekening->nama_bank }}</h3>
                            @if($rekening->is_utama)
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-bold bg-primary/10 text-primary">Primary</span>
                            @endif
                        </div>
                        <p class="text-gray-600 font-mono text-lg">{{ $rekening->no_rekening }}</p>
                        <p class="text-sm text-gray-500">a.n. {{ $rekening->atas_nama }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    @if(!$rekening->is_utama)
                    <form action="{{ url('/rekening/' . $rekening->id_rekening . '/utama') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="px-3 py-1.5 text-sm text-primary font-semibold hover:bg-primary/10 rounded-lg transition-all" title="Jadikan Utama">
                            Set as Primary
                        </button>
                    </form>
                    @endif
                    <button type="button" onclick="openEditModal({{ json_encode($rekening) }})" class="p-2 text-gray-400 hover:text-primary hover:bg-primary/10 rounded-lg transition-all" title="Edit">
                        <span class="material-symbols-outlined">edit</span>
                    </button>
                    <form action="{{ url('/rekening/' . $rekening->id_rekening) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus rekening ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="p-2 text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition-all" title="Hapus">
                            <span class="material-symbols-outlined">delete</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-12 text-center">
            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <span class="material-symbols-outlined text-gray-400 text-3xl">account_balance</span>
            </div>
            <h3 class="font-heading font-bold text-gray-600 mb-2">No bank account</h3>
            <p class="text-sm text-gray-400 mb-4">Add a bank account to receive payments</p>
            <button type="button" onclick="document.getElementById('tambah-modal').classList.remove('hidden')" class="inline-flex items-center gap-2 bg-primary hover:bg-primary/90 text-white px-6 py-2.5 rounded-lg font-bold font-heading transition-all">
                <span class="material-symbols-outlined">add</span>
                Add Account
            </button>
        </div>
        @endforelse
    </div>

    <!-- Info Card -->
    <div class="mt-8 bg-blue-50 border border-blue-200 rounded-xl p-6">
        <div class="flex items-start gap-4">
            <span class="material-symbols-outlined text-blue-600 text-2xl">info</span>
            <div>
                <h3 class="font-heading font-bold text-blue-800 mb-2">Important Information</h3>
                <ul class="text-sm text-blue-700 space-y-1">
                    <li>• The main account will be used to receive funds from escrow</li>
                    <li>• Make sure the account holder's name matches your identity</li>
                    <li>• Fund withdrawals will be processed after the order is confirmed complete by the buyer</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Rekening -->
<div id="tambah-modal" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl max-w-md w-full p-6">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-bold font-heading">Add New Account</h3>
            <button type="button" onclick="document.getElementById('tambah-modal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        <form action="{{ url('/rekening') }}" method="POST">
            @csrf
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Bank Name <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_bank" required class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-primary focus:border-primary" placeholder="Example: BCA, Mandiri, BNI"/>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Account Number <span class="text-red-500">*</span></label>
                    <input type="text" name="no_rekening" required class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-primary focus:border-primary" placeholder="Enter account number"/>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Account Holder <span class="text-red-500">*</span></label>
                    <input type="text" name="atas_nama" required class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-primary focus:border-primary" placeholder="Account holder name"/>
                </div>
                <div>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="is_utama" value="1" class="w-4 h-4 rounded text-primary focus:ring-primary"/>
                        <span class="text-sm font-medium text-gray-700">Set as primary account</span>
                    </label>
                </div>
            </div>
            <div class="flex gap-3 mt-6">
                <button type="button" onclick="document.getElementById('tambah-modal').classList.add('hidden')" class="flex-1 px-4 py-2 border border-gray-200 rounded-lg font-semibold text-gray-600 hover:bg-gray-50">
                    Cancel
                </button>
                <button type="submit" class="flex-1 px-4 py-2 bg-primary text-white rounded-lg font-semibold hover:bg-primary/90">
                    Save
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit Rekening -->
<div id="edit-modal" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl max-w-md w-full p-6">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-bold font-heading">Edit Account</h3>
            <button type="button" onclick="document.getElementById('edit-modal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        <form id="edit-form" action="" method="POST">
            @csrf
            @method('PUT')
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Bank Name <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_bank" id="edit-nama-bank" required class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-primary focus:border-primary"/>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Account Number <span class="text-red-500">*</span></label>
                    <input type="text" name="no_rekening" id="edit-no-rekening" required class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-primary focus:border-primary"/>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Account Holder <span class="text-red-500">*</span></label>
                    <input type="text" name="atas_nama" id="edit-atas-nama" required class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-primary focus:border-primary"/>
                </div>
            </div>
            <div class="flex gap-3 mt-6">
                <button type="button" onclick="document.getElementById('edit-modal').classList.add('hidden')" class="flex-1 px-4 py-2 border border-gray-200 rounded-lg font-semibold text-gray-600 hover:bg-gray-50">
                    Cancel
                </button>
                <button type="submit" class="flex-1 px-4 py-2 bg-primary text-white rounded-lg font-semibold hover:bg-primary/90">
                    Update
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function openEditModal(rekening) {
    document.getElementById('edit-form').action = '/rekening/' + rekening.id_rekening;
    document.getElementById('edit-nama-bank').value = rekening.nama_bank;
    document.getElementById('edit-no-rekening').value = rekening.no_rekening;
    document.getElementById('edit-atas-nama').value = rekening.atas_nama;
    document.getElementById('edit-modal').classList.remove('hidden');
}
</script>
@endpush
@endsection