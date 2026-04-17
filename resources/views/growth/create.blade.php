@extends('layouts.app')

@section('title', 'Input Pertumbuhan')

@section('content')
<div class="max-w-2xl mx-auto px-2">
    {{-- Tombol Kembali --}}
    <a href="/growth" class="inline-flex items-center text-rose-500 font-bold mb-4 md:mb-6 hover:translate-x-1 transition-transform text-sm md:text-base px-2">
        <x-heroicon-o-arrow-left class="w-4 h-4 md:w-5 md:h-5 mr-2" />
        Kembali
    </a>

    {{-- CARD FORM --}}
    <div class="bg-white rounded-2xl md:rounded-3xl p-6 md:p-10 shadow-sm border border-rose-50">
        {{-- Header Form --}}
        <div class="flex items-center mb-6 md:mb-8">
            <div class="w-10 h-10 md:w-12 md:h-12 bg-rose-50 rounded-xl flex items-center justify-center mr-3 md:mr-4">
                <x-heroicon-o-chart-bar class="w-6 h-6 md:w-8 md:h-8 text-rose-500" />
            </div>
            <div>
                <h2 class="text-xl md:text-2xl font-black text-slate-800 leading-tight">Catat Pertumbuhan</h2>
                <p class="text-[10px] md:text-xs text-slate-400 font-bold uppercase tracking-widest mt-0.5">Pantau Perkembangan Fisik</p>
            </div>
        </div>

        <form action="/growth" method="POST" class="space-y-5 md:space-y-6">
            @csrf
            
            {{-- Pilih Anak --}}
            <div>
                <label class="block text-[10px] md:text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-2 italic">Pilih Anak</label>
                <div class="relative">
                    <select name="child_id" class="w-full px-5 py-3.5 md:py-4 bg-slate-50 border-none rounded-xl md:rounded-2xl focus:ring-2 focus:ring-rose-200 font-bold text-slate-700 shadow-inner transition-all text-sm md:text-base appearance-none">
                        <option value="" disabled selected>-- Pilih Nama Si Kecil --</option>
                        @foreach($children as $child)
                            <option value="{{ $child->id }}" {{ old('child_id') == $child->id ? 'selected' : '' }}>
                                {{ $child->name }}
                            </option>
                        @endforeach
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-slate-400">
                        <x-heroicon-m-chevron-down class="w-5 h-5" />
                    </div>
                </div>
                @error('child_id') <p class="text-rose-500 text-[10px] md:text-xs mt-1 ml-2 font-bold">{{ $message }}</p> @enderror
            </div>

            {{-- Tanggal Periksa --}}
            <div>
                <label class="block text-[10px] md:text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-2 italic">Tanggal Periksa</label>
                <input type="date" name="record_date" value="{{ old('record_date', date('Y-m-d')) }}"
                    class="w-full px-5 py-3.5 md:py-4 bg-slate-50 border-none rounded-xl md:rounded-2xl focus:ring-2 focus:ring-rose-200 font-bold text-slate-700 shadow-inner transition-all text-sm md:text-base">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 md:gap-6">
                {{-- Berat Badan --}}
                <div class="relative">
                    <label class="block text-[10px] md:text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-2 italic">Berat Badan (kg)</label>
                    <div class="relative">
                        <input type="number" step="0.01" inputmode="decimal" name="weight" value="{{ old('weight') }}"
                            class="w-full pl-5 pr-12 py-3.5 md:py-4 bg-slate-50 border-none rounded-xl md:rounded-2xl focus:ring-2 focus:ring-rose-200 font-bold text-slate-700 shadow-inner transition-all text-sm md:text-base"
                            placeholder="0.00">
                        <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-slate-300 font-bold text-xs uppercase">
                            kg
                        </div>
                    </div>
                    @error('weight') <p class="text-rose-500 text-[10px] md:text-xs mt-1 ml-2 font-bold">{{ $message }}</p> @enderror
                </div>

                {{-- Tinggi Badan --}}
                <div class="relative">
                    <label class="block text-[10px] md:text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-2 italic">Tinggi Badan (cm)</label>
                    <div class="relative">
                        <input type="number" step="0.01" inputmode="decimal" name="height" value="{{ old('height') }}"
                            class="w-full pl-5 pr-12 py-3.5 md:py-4 bg-slate-50 border-none rounded-xl md:rounded-2xl focus:ring-2 focus:ring-rose-200 font-bold text-slate-700 shadow-inner transition-all text-sm md:text-base"
                            placeholder="0.00">
                        <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-slate-300 font-bold text-xs uppercase">
                            cm
                        </div>
                    </div>
                    @error('height') <p class="text-rose-500 text-[10px] md:text-xs mt-1 ml-2 font-bold">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- Tombol Simpan --}}
            <button type="submit" class="w-full py-4 md:py-5 bg-rose-500 text-white font-black rounded-xl md:rounded-2xl shadow-xl shadow-rose-100 hover:bg-rose-600 active:scale-[0.98] transition-all uppercase tracking-[0.2em] text-xs">
                Simpan Data
            </button>
        </form>
    </div>
</div>
@endsection