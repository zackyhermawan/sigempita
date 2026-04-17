@extends('layouts.app')

@section('title', 'Ubah Riwayat Pertumbuhan')

@section('content')
<div class="max-w-2xl mx-auto px-2">
    {{-- Tombol Kembali --}}
    <a href="/growth" class="inline-flex items-center text-rose-500 font-bold mb-4 md:mb-6 hover:translate-x-1 transition-transform text-sm md:text-base px-2">
        <x-heroicon-o-arrow-left class="w-4 h-4 md:w-5 md:h-5 mr-2" />
        Kembali ke Riwayat
    </a>

    {{-- CARD FORM --}}
    <div class="bg-white rounded-3xl p-6 md:p-10 shadow-sm border border-rose-50 relative overflow-hidden">
        
        {{-- Header Form --}}
        <div class="mb-6 md:mb-8 flex items-center">
            <div class="w-10 h-10 md:w-12 md:h-12 bg-amber-50 text-amber-500 rounded-xl flex items-center justify-center mr-3 md:mr-4 shrink-0">
                <x-heroicon-o-pencil-square class="w-6 h-6 md:w-7 md:h-7" />
            </div>
            <div>
                <h2 class="text-lg md:text-2xl font-black text-slate-800 leading-tight">
                    Edit Pertumbuhan
                </h2>
                <p class="text-[10px] md:text-xs text-slate-400 font-bold uppercase tracking-widest mt-0.5">Perbarui data</p>
            </div>
        </div>

        <form action="/growth/{{ $record->id }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            
            <input type="hidden" name="child_id" value="{{ $record->child_id }}">

            {{-- Info Profil Anak --}}
            <div class="bg-slate-50 p-4 md:p-6 rounded-2xl border border-slate-100 mb-2">
                <div class="flex items-center space-x-4">
                    <div class="w-10 h-10 md:w-12 md:h-12 rounded-xl bg-white flex items-center justify-center text-rose-500 shadow-sm font-black text-lg md:text-xl border border-slate-100 shrink-0">
                        {{ substr($record->child->name, 0, 1) }}
                    </div>
                    <div>
                        <p class="text-[9px] md:text-xs font-black text-slate-400 uppercase tracking-widest leading-none mb-1 italic">Data Untuk</p>
                        <p class="text-base md:text-lg font-bold text-slate-700 leading-tight">{{ $record->child->name }}</p>
                    </div>
                </div>
            </div>

            {{-- Tanggal --}}
            <div class="space-y-2">
                <label class="block text-[10px] md:text-xs font-black text-slate-400 uppercase tracking-widest ml-2 italic">Tanggal Pemeriksaan</label>
                <input type="date" name="record_date" value="{{ old('record_date', \Carbon\Carbon::parse($record->record_date)->format('Y-m-d')) }}"
                    class="w-full px-5 py-3.5 md:py-4 bg-slate-50 border-none rounded-xl md:rounded-2xl focus:ring-2 focus:ring-amber-200 transition-all font-bold text-slate-700 shadow-inner text-sm md:text-base">
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 md:gap-6">
                {{-- Berat Badan --}}
                <div class="space-y-2">
                    <label class="block text-[10px] md:text-xs font-black text-slate-400 uppercase tracking-widest ml-2 italic">Berat Badan (kg)</label>
                    <div class="relative">
                        <input type="number" step="0.01" inputmode="decimal" name="weight" value="{{ old('weight', $record->weight) }}"
                            class="w-full pl-5 pr-12 py-3.5 md:py-4 bg-slate-50 border-none rounded-xl md:rounded-2xl focus:ring-2 focus:ring-amber-200 transition-all font-bold text-slate-700 shadow-inner text-sm md:text-base"
                            placeholder="0.00">
                        <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-slate-300 font-bold text-xs uppercase">
                            kg
                        </div>
                    </div>
                    @error('weight') <p class="text-rose-500 text-[10px] md:text-xs font-bold ml-2 mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Tinggi Badan --}}
                <div class="space-y-2">
                    <label class="block text-[10px] md:text-xs font-black text-slate-400 uppercase tracking-widest ml-2 italic">Tinggi Badan (cm)</label>
                    <div class="relative">
                        <input type="number" step="0.01" inputmode="decimal" name="height" value="{{ old('height', $record->height) }}"
                            class="w-full pl-5 pr-12 py-3.5 md:py-4 bg-slate-50 border-none rounded-xl md:rounded-2xl focus:ring-2 focus:ring-amber-200 transition-all font-bold text-slate-700 shadow-inner text-sm md:text-base"
                            placeholder="0.00">
                        <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-slate-300 font-bold text-xs uppercase">
                            cm
                        </div>
                    </div>
                    @error('height') <p class="text-rose-500 text-[10px] md:text-xs font-bold ml-2 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- Button Aksi --}}
            <div class="pt-4 md:pt-6">
                <button type="submit" class="w-full py-4 md:py-5 bg-amber-400 text-white font-black rounded-xl md:rounded-2xl shadow-xl shadow-amber-100 hover:bg-amber-500 active:scale-[0.98] transition-all uppercase tracking-widest text-xs md:text-sm">
                    Perbarui Data
                </button>
            </div>
        </form>
    </div>
</div>
@endsection