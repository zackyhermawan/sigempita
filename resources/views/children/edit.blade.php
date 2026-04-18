@extends('layouts.app')

@section('title', 'Ubah Data')

@section('content')
<div class="max-w-2xl mx-auto px-2">
    {{-- Tombol Kembali --}}
    <a href="/children" class="inline-flex items-center text-rose-500 font-bold mb-4 md:mb-6 hover:translate-x-1 transition-transform text-sm md:text-base px-2">
        <x-heroicon-o-arrow-left class="w-4 h-4 md:w-5 md:h-5 mr-2" />
        Kembali
    </a>

    {{-- CARD FORM --}}
    <div class="bg-white rounded-2xl md:rounded-3xl p-6 md:p-10 shadow-sm border border-rose-50">
        <div class="mb-6 md:mb-8">
            <h2 class="text-xl md:text-2xl font-black text-slate-800 mb-1 leading-tight">Edit Data {{ $child->name }}</h2>
            <p class="text-xs md:text-sm text-slate-500 font-medium italic">Pastikan data pertumbuhan si kecil tetap akurat ya Bunda.</p>
        </div>

        <form action="/children/{{ $child->id }}" onsubmit="handleLogin(this)" method="POST" class="space-y-5 md:space-y-6">
            @csrf
            @method('PUT')
            
            {{-- Nama Lengkap --}}
            <div>
                <label class="block text-[10px] md:text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-2 italic">Nama Lengkap Anak</label>
                <input type="text" name="name" value="{{ old('name', $child->name) }}"
                    class="w-full px-5 py-3.5 md:py-4 bg-slate-50 border-none rounded-xl md:rounded-2xl focus:ring-2 focus:ring-rose-200 font-bold text-slate-700 shadow-inner transition-all placeholder:text-slate-300 text-sm md:text-base"
                    placeholder="Contoh: Sultan Zacky">
                @error('name') <span class="text-rose-500 text-[10px] md:text-xs mt-1 ml-2 font-bold">{{ $message }}</span> @enderror
            </div>

            {{-- Jenis Kelamin --}}
            <div>
                <label class="block text-[10px] md:text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-2 italic">Jenis Kelamin</label>
                <div class="relative">
                    <select name="gender" class="w-full px-5 py-3.5 md:py-4 bg-slate-50 border-none rounded-xl md:rounded-2xl focus:ring-2 focus:ring-rose-200 font-bold text-slate-700 shadow-inner transition-all text-sm md:text-base appearance-none">
                        <option value="" disabled>Pilih Jenis Kelamin</option>
                        <option value="Laki-laki" {{ old('gender', $child->gender) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="Perempuan" {{ old('gender', $child->gender) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-slate-400">
                        <x-heroicon-m-chevron-down class="w-5 h-5" />
                    </div>
                </div>
                @error('gender') <span class="text-rose-500 text-[10px] md:text-xs mt-1 ml-2 font-bold">{{ $message }}</span> @enderror
            </div>
            

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 md:gap-6">
                {{-- Tanggal Lahir --}}
                <div>
                    <label class="block text-[10px] md:text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-2 italic">Tanggal Lahir</label>
                    <input type="date" name="date_of_birth" value="{{ old('date_of_birth', \Carbon\Carbon::parse($child->date_of_birth)->format('Y-m-d')) }}"
                        class="w-full px-5 py-3.5 md:py-4 bg-slate-50 border-none rounded-xl md:rounded-2xl focus:ring-2 focus:ring-rose-200 font-bold text-slate-700 shadow-inner transition-all text-sm md:text-base">
                    @error('date_of_birth') <span class="text-rose-500 text-[10px] md:text-xs mt-1 ml-2 font-bold">{{ $message }}</span> @enderror
                </div>

                {{-- Nama Orang Tua --}}
                <div>
                    <label class="block text-[10px] md:text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-2 italic">Nama Bunda/Ayah</label>
                    <input type="text" name="parent_name" value="{{ old('parent_name', $child->parent_name) }}"
                        class="w-full px-5 py-3.5 md:py-4 bg-slate-50 border-none rounded-xl md:rounded-2xl focus:ring-2 focus:ring-rose-200 font-bold text-slate-700 shadow-inner transition-all placeholder:text-slate-300 text-sm md:text-base"
                        placeholder="Nama Orang Tua">
                    @error('parent_name') <span class="text-rose-500 text-[10px] md:text-xs mt-1 ml-2 font-bold">{{ $message }}</span> @enderror
                </div>
            </div>

            {{-- Button Perbarui: Menggunakan warna Amber agar beda dengan Simpan Baru --}}
            <button id="registerBtn" type="submit" class="flex items-center justify-center gap-3 w-full mt-4 py-4 md:py-5 bg-amber-400 text-white font-black rounded-xl md:rounded-2xl shadow-xl shadow-amber-100 hover:bg-amber-500 active:scale-[0.98] transition-all uppercase tracking-widest text-xs md:text-sm">
                <span id="btnText">Perbarui Data Si Kecil</span>
                <div id="spinner" class="hidden animate-spin rounded-full h-5 w-5 border-2 border-white border-t-transparent"></div>
            </button>
        </form>
    </div>
</div>
<script>
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