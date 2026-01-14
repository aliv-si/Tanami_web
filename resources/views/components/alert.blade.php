{{-- Flash Message Alert Component --}}
@if(session('success'))
<div id="alert-success" class="fixed top-4 right-4 z-50 max-w-md animate-fade-in">
    <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg shadow-lg flex items-center gap-3">
        <span class="material-symbols-outlined text-green-600">check_circle</span>
        <p class="flex-1 text-sm font-medium">{{ session('success') }}</p>
        <button onclick="this.closest('#alert-success').remove()" class="text-green-600 hover:text-green-800">
            <span class="material-symbols-outlined text-xl">close</span>
        </button>
    </div>
</div>
@endif

@if(session('error'))
<div id="alert-error" class="fixed top-4 right-4 z-50 max-w-md animate-fade-in">
    <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg shadow-lg flex items-center gap-3">
        <span class="material-symbols-outlined text-red-600">error</span>
        <p class="flex-1 text-sm font-medium">{{ session('error') }}</p>
        <button onclick="this.closest('#alert-error').remove()" class="text-red-600 hover:text-red-800">
            <span class="material-symbols-outlined text-xl">close</span>
        </button>
    </div>
</div>
@endif

@if($errors->any())
<div id="alert-errors" class="fixed top-4 right-4 z-50 max-w-md animate-fade-in">
    <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg shadow-lg">
        <div class="flex items-center gap-3 mb-2">
            <span class="material-symbols-outlined text-red-600">warning</span>
            <p class="flex-1 text-sm font-bold">Terjadi kesalahan:</p>
            <button onclick="this.closest('#alert-errors').remove()" class="text-red-600 hover:text-red-800">
                <span class="material-symbols-outlined text-xl">close</span>
            </button>
        </div>
        <ul class="list-disc list-inside text-sm ml-6">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
</div>
@endif

<style>
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}
.animate-fade-in {
    animation: fadeIn 0.3s ease-out;
}
</style>

<script>
// Auto-hide alerts after 5 seconds
document.addEventListener('DOMContentLoaded', function() {
    setTimeout(function() {
        ['alert-success', 'alert-error', 'alert-errors'].forEach(function(id) {
            var el = document.getElementById(id);
            if (el) el.remove();
        });
    }, 5000);
});
</script>
