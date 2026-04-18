@extends('layouts.app')

@section('title', 'Validasi Data Anak')

@section('content')
<div class="max-w-5xl mx-auto py-2 md:py-4 px-2">

    <a href="/admin/monitoring" class="inline-flex items-center text-rose-500 font-bold mb-4 md:mb-6 hover:translate-x-1 transition-transform text-sm md:text-base">
        <x-heroicon-o-arrow-left class="w-4 h-4 md:w-5 md:h-5 mr-2" />
        Kembali
    </a>

    {{-- HEADER --}}
    <div class="mb-6 md:mb-8 px-2">
        <h2 class="text-xl md:text-2xl font-black text-slate-800 uppercase italic leading-tight">
            Validasi Penilaian Gizi
        </h2>

        <p class="text-sm md:text-base text-slate-500 font-medium mt-1">
            Anak: <span class="text-rose-500 font-bold">{{ $child->name }}</span>
        </p>

        @if($lastMonitoring)
        <p class="text-[10px] md:text-xs text-slate-400 mt-1 uppercase tracking-wider">
            Status terakhir: 
            <span class="font-bold text-emerald-500">
                {{ $lastMonitoring->nutritional_status }}
            </span>
        </p>
        @endif
    </div>

    {{-- ALERT JIKA DATA KOSONG --}}
    @if(!$lastGrowth)
    <div class="mb-6 px-2">
        <div class="bg-amber-50 border-2 border-dashed border-amber-200 p-6 rounded-xl flex flex-col items-center text-center">
            <div class="w-12 h-12 bg-amber-100 rounded-full flex items-center justify-center mb-3">
                <x-heroicon-o-exclamation-triangle class="w-6 h-6 text-amber-600" />
            </div>
            <h3 class="text-amber-800 font-black uppercase text-xs tracking-widest">Penilaian Dikunci</h3>
            <p class="text-amber-600/80 text-[11px] md:text-xs font-bold mt-1 leading-relaxed">
                Belum ada data pertumbuhan (Berat/Tinggi) yang diinput oleh orang tua.<br>
                Silakan hubungi Bunda untuk mengisi data pertumbuhan terlebih dahulu.
            </p>
        </div>
    </div>
    @endif

    {{-- GRID: Riwayat & Makanan --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 md:gap-8 mb-6 md:mb-8">

        {{-- ================== PERTUMBUHAN ================== --}}
        <div class="bg-white rounded-xl md:rounded-xl p-5 md:p-6 shadow-sm border border-slate-100">
            <h3 class="text-[10px] md:text-xs font-black text-slate-400 uppercase tracking-widest mb-4 md:mb-5 italic text-center">
                Riwayat Pertumbuhan
            </h3>

            <div class="space-y-3 md:space-y-4">
                @forelse($growthRecords as $index => $g)
                    <div class="relative p-3 md:p-4 rounded-xl md:rounded-2xl border 
                        {{ $index == 0 ? 'bg-rose-50 border-rose-200' : 'bg-slate-50 border-slate-100' }}">

                        @if($index == 0)
                            <span class="absolute -top-2 -right-1 bg-rose-500 text-white text-[7px] md:text-[8px] font-black px-2 py-0.5 md:py-1 rounded-md uppercase shadow-sm">
                                Terbaru
                            </span>
                        @endif

                        <div class="flex justify-between items-center">
                            <span class="text-[10px] md:text-xs font-bold text-slate-500">
                                {{ \Carbon\Carbon::parse($g->record_date)->format('d M Y') }}
                            </span>

                            <span class="text-xs md:text-sm font-black text-slate-700">
                                {{ $g->weight }}kg / {{ $g->height }}cm
                            </span>
                        </div>
                    </div>
                @empty
                    <p class="text-center text-slate-400 text-[11px] md:text-xs italic py-6">
                        Belum ada data pertumbuhan
                    </p>
                @endforelse
            </div>

            @if(!is_null($weightDiff))
                <p class="text-center text-[10px] md:text-xs font-bold mt-4 md:mt-5
                    {{ $weightDiff > 0 ? 'text-emerald-500' : ($weightDiff < 0 ? 'text-rose-500' : 'text-slate-400') }}">
                    @if($weightDiff > 0)
                        ⬆ Berat naik {{ $weightDiff }} kg
                    @elseif($weightDiff < 0)
                        ⬇ Berat turun {{ abs($weightDiff) }} kg
                    @else
                        ➖ Tidak ada perubahan berat
                    @endif
                </p>
            @endif
        </div>

        {{-- ================== MAKANAN ================== --}}
        <div class="bg-white rounded-xl md:rounded-xl p-5 md:p-6 shadow-sm border border-slate-100">
            <h3 class="text-[10px] md:text-xs font-black text-blue-400 uppercase tracking-widest mb-4 md:mb-5 italic text-center">
                Catatan Makan Hari Ini
            </h3>

            <div class="space-y-2 md:space-y-3">
                @forelse($foodToday as $f)
                    <div class="flex justify-between items-center p-3 rounded-xl bg-blue-50/40 border border-blue-100 gap-2">
                        <span class="text-[9px] md:text-[11px] font-black text-blue-600 uppercase whitespace-nowrap">
                            {{ $f->feeding_period }}
                        </span>
                        <span class="text-[10px] md:text-xs text-slate-600 italic text-right truncate">
                            {{ $f->food_type }}
                        </span>
                    </div>
                @empty
                    <p class="text-center text-slate-400 text-[11px] md:text-xs italic py-6">
                        Tidak ada data makan hari ini
                    </p>
                @endforelse
            </div>

            @if($foodToday->count())
                <div class="mt-4 md:mt-5 text-center">
                    <span class="px-3 md:px-4 py-1.5 bg-blue-100 text-blue-600 text-[9px] md:text-[10px] font-black rounded-full uppercase">
                        Frekuensi: {{ $foodToday->count() }}x hari ini
                    </span>
                </div>
            @endif
        </div>
    </div>

    {{-- ================== FORM ================== --}}
    {{-- Kita tambahkan opacity-50 dan pointer-events-none jika data kosong --}}
    <div class="bg-white rounded-xl md:rounded-xl p-6 md:p-10 shadow-sm border border-rose-50 {{ !$lastGrowth ? 'opacity-50 pointer-events-none select-none' : '' }}">
        <form action="/admin/monitoring/{{ $child->id }}" onsubmit="handleLogin(this)"  method="POST">
            @csrf
            @method('PUT')

            <input type="hidden" name="growth_record_id" value="{{ $lastGrowth->id ?? '' }}">
            <input type="hidden" name="status" value="reviewed">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-8">

                {{-- STATUS GIZI --}}
                <div class="space-y-2">
                    <label class="text-[9px] md:text-[10px] font-black text-slate-400 uppercase ml-2 italic tracking-wider">
                        Tentukan Status Gizi
                    </label>

                    <select name="nutritional_status" required {{ !$lastGrowth ? 'disabled' : '' }}
                        class="w-full px-5 py-4 bg-slate-50 border-none rounded-xl md:rounded-2xl font-black text-slate-700 shadow-inner focus:ring-2 focus:ring-rose-200 text-xs md:text-sm appearance-none">
                        <option value="">-- Pilih Status --</option>
                        <option value="Gizi Baik">Gizi Baik</option>
                        <option value="Gizi Kurang">Gizi Kurang</option>
                        <option value="Gizi Lebih">Gizi Lebih</option>
                        <option value="Obesitas">Obesitas</option>
                        <option value="Stunting">Stunting</option>
                    </select>
                </div>

                {{-- CATATAN --}}
                <div class="space-y-2">
                    <label class="text-[9px] md:text-[10px] font-black text-slate-400 uppercase ml-2 italic tracking-wider">
                        Saran untuk Ibu
                    </label>

                    <textarea name="admin_notes" {{ !$lastGrowth ? 'disabled' : '' }}
                        class="w-full px-5 py-4 bg-slate-50 border-none rounded-xl md:rounded-2xl font-bold text-slate-700 shadow-inner focus:ring-2 focus:ring-rose-200 text-xs md:text-sm"
                        rows="3"
                        placeholder="Contoh: Tambah protein, perbanyak sayur..."></textarea>
                </div>
            </div>

            <button id="editBtn" type="submit" {{ !$lastGrowth ? 'disabled' : '' }}
                class="flex items-center justify-center gap-3 w-full mt-4 py-4 md:py-5 bg-rose-500 text-white font-black rounded-xl md:rounded-2xl shadow-xl shadow-rose-100 hover:bg-rose-600 active:scale-[0.98] transition-all uppercase tracking-widest text-xs md:text-sm cursor-pointer">
                <span id="btnText">{{ !$lastGrowth ? 'Penilaian Tidak Tersedia' : 'Simpan Penilaian' }}</span>
                <div id="spinner" class="hidden animate-spin rounded-full h-5 w-5 border-2 border-white border-t-transparent"></div>
            </button>
        </form>
    </div>
</div>

<script>
     function handleLogin(form) {
        const btn = document.getElementById('editBtn');
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