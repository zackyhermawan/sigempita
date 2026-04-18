@extends('layouts.app')

@section('title', 'Ubah Catatan Makan')

@section('content')
<div class="max-w-2xl mx-auto px-2">
    {{-- Tombol Kembali --}}
    <a href="/food" class="inline-flex items-center text-rose-500 font-bold mb-4 md:mb-6 hover:translate-x-1 transition-transform text-sm md:text-base px-2">
        <x-heroicon-o-arrow-left class="w-4 h-4 md:w-5 md:h-5 mr-2" />
        Kembali
    </a>

    {{-- CARD FORM --}}
    <div class="bg-white rounded-3xl p-6 md:p-10 shadow-sm border border-slate-100">
        {{-- Header Form --}}
        <div class="flex items-center mb-6 md:mb-8">
            <div class="w-10 h-10 md:w-12 md:h-12 bg-amber-50 rounded-xl flex items-center justify-center mr-3 md:mr-4">
                <x-heroicon-o-cake class="w-6 h-6 md:w-8 md:h-8 text-amber-500" />
            </div>
            <div>
                <h2 class="text-xl md:text-2xl font-black text-slate-800 leading-tight">Edit Catatan Makan</h2>
                <p class="text-[10px] md:text-xs text-slate-400 font-bold uppercase tracking-widest mt-0.5">Perbarui Nutrisi Si Kecil</p>
            </div>
        </div>

        <form action="/food/{{ $record->id }}" method="POST" onsubmit="handleLogin(this)" class="space-y-6">
            @csrf
            @method('PUT')
            
            <input type="hidden" name="child_id" value="{{ $record->child_id }}">

            {{-- Info Profil Anak: Dibuat lebih compact di mobile --}}
            <div class="bg-slate-50 p-4 md:p-6 rounded-2xl border border-slate-100 mb-2">
                <div class="flex items-center space-x-4">
                    <div class="w-10 h-10 md:w-12 md:h-12 rounded-xl bg-white flex items-center justify-center text-rose-500 shadow-sm font-black text-lg md:text-xl border border-slate-100">
                        {{ substr($record->child->name, 0, 1) }}
                    </div>
                    <div>
                        <p class="text-[9px] md:text-xs font-black text-slate-400 uppercase tracking-widest leading-none mb-1">Memperbarui Data Untuk</p>
                        <p class="text-base md:text-lg font-bold text-slate-700 leading-tight">{{ $record->child->name }}</p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 md:gap-8">
                {{-- Tanggal Makan --}}
                <div class="space-y-2">
                    <label class="block text-[10px] md:text-xs font-black text-slate-400 uppercase tracking-widest ml-2 italic">Tanggal Makan</label>
                    <input type="date" name="record_date" value="{{ old('record_date', \Carbon\Carbon::parse($record->record_date)->format('Y-m-d')) }}"
                        class="w-full px-5 py-3.5 md:py-4 bg-slate-50 border-none rounded-xl md:rounded-2xl focus:ring-2 focus:ring-rose-200 font-bold text-slate-700 shadow-inner transition-all text-sm md:text-base">
                </div>

                {{-- Jam Makan --}}
                <div class="space-y-2">
                    <label class="block text-[10px] md:text-xs font-black text-slate-400 uppercase tracking-widest ml-2 italic">Jam Makan</label>
                    <div class="relative">
                        <select name="feeding_period" class="w-full px-5 py-3.5 md:py-4 bg-slate-50 border-none rounded-xl md:rounded-2xl focus:ring-2 focus:ring-rose-200 font-bold text-slate-700 shadow-inner transition-all text-sm md:text-base appearance-none">
                            <option value="Pagi" {{ old('feeding_period', $record->feeding_period) == 'Pagi' ? 'selected' : '' }}>Pagi</option>
                            <option value="Siang" {{ old('feeding_period', $record->feeding_period) == 'Siang' ? 'selected' : '' }}>Siang</option>
                            <option value="Sore" {{ old('feeding_period', $record->feeding_period) == 'Sore' ? 'selected' : '' }}>Sore</option>
                            <option value="Malam" {{ old('feeding_period', $record->feeding_period) == 'Malam' ? 'selected' : '' }}>Malam</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-slate-400">
                            <x-heroicon-m-chevron-down class="w-5 h-5" />
                        </div>
                    </div>
                </div>
            </div>

            {{-- Deskripsi Makanan --}}
            <div class="space-y-2">
                <label class="block text-[10px] md:text-xs font-black text-slate-400 uppercase tracking-widest ml-2 italic">Apa yang dimakan?</label>
                <textarea name="food_type" rows="3"
                    class="w-full px-5 py-4 bg-slate-50 border-none rounded-xl md:rounded-2xl focus:ring-2 focus:ring-rose-200 font-bold text-slate-700 shadow-inner transition-all text-sm md:text-base">{{ old('food_type', $record->food_type) }}</textarea>
                @error('food_type') <p class="text-rose-500 text-[10px] md:text-xs font-bold ml-2 mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Button Perbarui --}}
            <button id="registerBtn" type="submit" class="flex items-center justify-center gap-3 w-full mt-4 py-4 md:py-5 bg-amber-400 text-white font-black rounded-xl md:rounded-2xl shadow-xl shadow-amber-100 hover:bg-amber-500 active:scale-[0.98] transition-all uppercase tracking-widest text-xs md:text-sm cursor-pointer">
                <span id="btnText">Perbarui Catatan</span>
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