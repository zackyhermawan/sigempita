@extends('layouts.app')

@section('title', 'Tambah Data Anak (Admin)')

@section('content')
{{-- max-w disesuaikan agar tidak terlalu lebar di desktop, tetap nyaman di mobile --}}
<div class="max-w-2xl mx-auto py-2 md:py-4">
    <a href="/admin/children" class="inline-flex items-center text-rose-500 font-bold mb-4 md:mb-6 hover:translate-x-1 transition-transform text-sm md:text-base">
        <x-heroicon-o-arrow-left class="w-4 h-4 md:w-5 md:h-5 mr-2" />
        Kembali
    </a>

    {{-- rounded-3xl untuk mobile, rounded-[3rem] untuk desktop agar tetap estetik --}}
    <div class="bg-white rounded-xl md:rounded-xl p-6 md:p-10 shadow-sm border border-rose-50 relative overflow-hidden">
        
        <div class="mb-6 md:mb-10 text-center">
            <h2 class="text-2xl md:text-3xl font-black text-slate-800 leading-tight px-2">Registrasi Anak Baru</h2>
            <p class="text-xs md:text-sm text-slate-400 font-medium mt-2">Menambahkan data anak ke akun Bunda tertentu.</p>
        </div>

        <form action="/admin/children" onsubmit="handleLogin(this)" method="POST" class="space-y-4 md:space-y-6">
            @csrf
            
            <div class="space-y-1">
                <label class="block text-xs md:text-sm font-bold text-slate-700 mb-1 ml-1">Tautkan ke Akun Bunda</label>
                <div class="relative">
                    <select name="user_id" id="user_select" required 
                        class="block w-full px-5 md:px-6 py-4 md:py-5 bg-slate-50 border-none rounded-xl md:rounded-2xl focus:ring-2 focus:ring-rose-400 font-bold text-slate-700 shadow-inner appearance-none transition-all text-xs md:text-sm">
                        <option value="">-- Pilih Akun User --</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" data-name="{{ $user->name }}">
                                {{ $user->name }} ({{ $user->username }})
                            </option>
                        @endforeach
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center pr-5 md:pr-6 pointer-events-none text-rose-300">
                        <x-heroicon-o-chevron-down class="w-4 h-4 md:w-5 md:h-5" />
                    </div>
                </div>
                @error('user_id') <p class="text-rose-500 text-[10px] font-black ml-3 uppercase mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="space-y-1">
                <label class="block text-xs md:text-sm font-bold text-slate-700 mb-1 ml-1">Nama Lengkap Anak</label>
                <input type="text" name="name" required placeholder="Masukkan nama lengkap..."
                    class="block w-full px-5 md:px-6 py-4 md:py-5 bg-slate-50 border-none rounded-xl md:rounded-2xl focus:ring-2 focus:ring-rose-400 font-bold text-slate-700 shadow-inner transition-all text-xs md:text-sm">
            </div>

            <div class="space-y-1">
                <label class="block text-xs md:text-sm font-bold text-slate-700 mb-1 ml-1">Jenis Kelamin</label>
                <select name="gender" 
                    class="w-full px-5 md:px-6 py-4 md:py-5 bg-slate-50 border-none rounded-xl md:rounded-2xl focus:ring-2 focus:ring-amber-400 font-bold text-slate-700 shadow-inner transition-all text-xs md:text-sm">
                    <option value="" disabled selected>Pilih Jenis Kelamin</option>
                    <option value="Laki-laki">Laki-laki</option>
                    <option value="Perempuan">Perempuan</option>
                </select>
                @error('gender') <span class="text-rose-500 text-[10px] mt-1 ml-1 font-bold">{{ $message }}</span> @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-8">
                <div class="space-y-1">
                    <label class="block text-xs md:text-sm font-bold text-slate-700 mb-1 ml-1">Tanggal Lahir</label>
                    <input type="date" name="date_of_birth" value="{{ old('date_of_birth') }}"
                        class="w-full px-5 md:px-6 py-4 md:py-5 bg-slate-50 border-none rounded-xl md:rounded-2xl focus:ring-2 focus:ring-amber-400 font-bold text-slate-700 shadow-inner transition-all text-xs md:text-sm">
                    @error('date_of_birth') <span class="text-rose-500 text-[10px] mt-1 ml-1 font-bold">{{ $message }}</span> @enderror
                </div>
                <div class="space-y-1">
                    <label class="block text-xs md:text-sm font-bold text-slate-700 mb-1 ml-1">Nama Orang Tua</label>
                    <input type="text" name="parent_name" id="parent_name" required placeholder="Nama Bunda/Ayah..."
                        class="block w-full px-5 md:px-6 py-4 md:py-5 bg-slate-50 border-none rounded-xl md:rounded-2xl focus:ring-2 focus:ring-rose-400 font-bold text-slate-700 shadow-inner transition-all text-xs md:text-sm">
                </div>
            </div>

            <div class="pt-4">
                <button id="registerBtn" type="submit" class="flex items-center justify-center gap-3 w-full mt-4 py-4 md:py-5 bg-rose-500 text-white font-black rounded-xl md:rounded-2xl shadow-xl shadow-rose-100 hover:bg-rose-600 active:scale-[0.98] transition-all uppercase tracking-widest text-xs md:text-sm cursor-pointer">
                    <span id="btnText">Daftarkan</span>
                    <div id="spinner" class="hidden animate-spin rounded-full h-5 w-5 border-2 border-white border-t-transparent"></div>
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Script JS tetap sama (fungsional) --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const userSelect = document.getElementById('user_select');
        const parentInput = document.getElementById('parent_name');

        userSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const userName = selectedOption.getAttribute('data-name');

            if (userName) {
                parentInput.value = userName;
            } else {
                parentInput.value = '';
            }
        });
    });

    function handleLogin(form) {
        const btn = document.getElementById('registerBtn');
        const text = document.getElementById('btnText');
        const spinner = document.getElementById('spinner');

        // 1. Matikan tombol biar gak di-klik dua kali
        btn.disabled = true;
        
        // 2. Ubah tampilan tombol (agak transparan & kursor berubah)
        btn.classList.add('opacity-80', 'cursor-not-allowed');

        // 3. Ganti teks & munculkan spinner
        text.innerText = 'Memuat...'; 
        spinner.classList.remove('hidden');

        return true; // Biarkan form lanjut kirim data ke server
    }
</script>
@endsection