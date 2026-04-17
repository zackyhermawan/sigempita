@extends('layouts.app')

@section('title', 'Beranda Bunda')

@section('content')

{{-- EMPTY STATE: Dibuat lebih ringkas di mobile --}}
@if($children->isEmpty())
    <div class="bg-white border-2 border-dashed border-rose-200 p-6 md:p-10 rounded-2xl text-center mb-8 mx-2">
        <div class="bg-rose-50 w-16 h-16 md:w-20 md:h-20 rounded-full flex items-center justify-center mx-auto mb-4">
            <x-heroicon-o-face-smile class="w-10 h-10 md:w-12 md:h-12 text-rose-300" />
        </div>
        <h3 class="text-lg md:text-xl font-bold text-slate-700">Halo Bunda!</h3>
        <p class="text-sm text-slate-500 mb-6 italic">Sepertinya Bunda belum mendaftarkan data si kecil.</p>
        <a href="/children" class="bg-rose-500 text-white px-6 py-3 rounded-2xl shadow-lg shadow-rose-100 hover:bg-rose-600 transition-all font-bold inline-block text-sm">
            + Tambah Data Anak
        </a>
    </div>
@endif

{{-- GRID ANAK: Menggunakan sistem grid yang adaptif --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6 px-2">

@foreach($children as $child)
@php
    $lastMonitoring = $child->monitorings->first();
    $status = $lastMonitoring->nutritional_status ?? null;

    $color = match($status) {
        'Gizi Baik' => 'bg-green-50 text-green-600 border-green-100',
        'Gizi Kurang' => 'bg-yellow-50 text-yellow-600 border-yellow-100',
        'Gizi Lebih' => 'bg-orange-50 text-orange-600 border-orange-100',
        'Obesitas' => 'bg-red-50 text-red-600 border-red-100',
        'Stunting' => 'bg-blue-50 text-blue-600 border-blue-100',
        default => 'bg-gray-50 text-gray-500 border-gray-100',
    };
@endphp

<div class="bg-white rounded-3xl p-5 md:p-6 shadow-sm border border-rose-50 hover:shadow-md transition-all relative overflow-hidden group">
    
    <div class="absolute top-0 right-0 w-20 h-20 bg-rose-50 rounded-full -mr-8 -mt-8 group-hover:bg-rose-100 transition-colors"></div>

    <div class="relative">
        
        {{-- HEADER --}}
        <div class="flex items-center space-x-3 md:space-x-4 mb-5">
            <div class="w-12 h-12 md:w-14 md:h-14 rounded-2xl bg-gradient-to-br from-rose-400 to-pink-500 flex items-center justify-center text-white shadow-md">
                <x-heroicon-o-user class="w-6 h-6 md:w-8 md:h-8" />
            </div>
            <div>
                <h2 class="text-lg md:text-xl font-extrabold text-slate-800 leading-tight">{{ $child->name }}</h2>
                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-0.5">Data Terkini</p>
            </div>
        </div>
        
        {{-- BB & TB --}}
        <div class="grid grid-cols-2 gap-3 md:gap-4">
            <div class="bg-slate-50/80 p-3 md:p-4 rounded-2xl border border-slate-100">
                <p class="text-[9px] md:text-[10px] uppercase tracking-wider text-slate-400 font-black mb-1">Berat</p>
                <p class="text-lg md:text-xl font-black text-slate-700">
                    {{ $child->latestGrowthRecord ? $child->latestGrowthRecord->weight . ' kg' : '--' }}
                </p>
            </div>

            <div class="bg-slate-50/80 p-3 md:p-4 rounded-2xl border border-slate-100">
                <p class="text-[9px] md:text-[10px] uppercase tracking-wider text-slate-400 font-black mb-1">Tinggi</p>
                <p class="text-lg md:text-xl font-black text-slate-700">
                    {{ $child->latestGrowthRecord ? $child->latestGrowthRecord->height . ' cm' : '--' }}
                </p>
            </div>
        </div>

        {{-- STATUS GIZI --}}
        <div class="mt-4 p-4 rounded-2xl border {{ $color }}">
            <div class="flex items-center mb-1">
                <x-heroicon-o-heart class="w-4 h-4 mr-2" />
                <span class="text-[10px] md:text-xs font-black uppercase tracking-wider">Status Gizi</span>
            </div>

            <p class="text-base md:text-lg font-black">
                @if($status)
                    {{ $status }}
                @else
                    <span class="text-slate-400 italic font-medium">Menunggu Penilaian</span>
                @endif
            </p>
        </div>

    </div>
</div>
@endforeach

</div>

{{-- ================== LOG MAKAN ================== --}}
<div class="mt-10 px-2">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-xl md:text-2xl font-black text-slate-800 flex items-center leading-tight tracking-tight">
            <span class="w-1.5 h-6 md:h-8 bg-rose-500 rounded-full mr-3"></span>
            Log Makan Si Kecil
        </h2>
        <a href="/food" class="text-rose-500 font-bold text-xs md:text-sm hover:underline decoration-2 underline-offset-4">Lihat Semua</a>
    </div>

    @if($latestFood->isEmpty())
        <div class="bg-white p-8 rounded-[2rem] text-center text-slate-400 shadow-sm border border-rose-50 italic text-sm">
            Bunda belum mencatat menu makan hari ini.
        </div>
    @else
        <div class="grid gap-3">
            @foreach($latestFood as $item)
            <div class="bg-white p-3 md:p-4 rounded-2xl md:rounded-3xl shadow-sm border border-rose-50 flex items-center hover:bg-rose-50/20 transition-all group">
                
                <div class="w-10 h-10 md:w-12 md:h-12 rounded-xl md:rounded-2xl bg-amber-100 text-amber-600 flex items-center justify-center mr-3 md:mr-4 group-hover:scale-110 transition-transform">
                    <x-heroicon-o-cake class="w-5 h-5 md:w-6 md:h-6" />
                </div>

                <div class="flex-1">
                    <h4 class="font-bold text-slate-800 text-sm md:text-base leading-tight">{{ $item->food_type }}</h4>
                    <p class="text-[10px] md:text-xs text-slate-400 font-medium tracking-wide mt-1">
                        <span class="text-rose-400 font-bold capitalize">{{ $item->child->name }}</span> 
                        <span class="mx-1">•</span> {{ $item->feeding_period }}
                    </p>
                </div>

                <div class="text-right ml-2">
                    <span class="px-3 py-1.5 bg-slate-50 text-slate-500 rounded-lg md:rounded-xl text-[9px] md:text-xs font-bold whitespace-nowrap">
                        {{ \Carbon\Carbon::parse($item->record_date)->format('d M') }}
                    </span>
                </div>
            </div>
            @endforeach
        </div>
    @endif
</div>

@endsection