@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')

{{-- Header dengan teks responsif --}}
<div class="mb-6 md:mb-8">
    <h2 class="text-xl md:text-2xl lg:text-3xl font-black text-slate-800 uppercase tracking-tighter">
        Ringkasan Sistem
    </h2>
    <p class="text-sm md:text-base text-slate-500 font-medium">
        Ringkasan statistik dan aktivitas sistem.
    </p>
</div>

{{-- ================= CARD: Grid Responsif ================= --}}
{{-- 1 kolom di HP, 2 kolom di Tablet, 3 kolom di Laptop --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6 mb-8 md:mb-10">

    {{-- Total Anak --}}
    <div class="bg-white p-5 md:p-6 rounded-xl border border-blue-50 shadow-sm transition-all hover:shadow-md">
        <div class="w-10 h-10 md:w-12 md:h-12 bg-blue-100 text-blue-600 rounded-2xl flex items-center justify-center mb-3 md:mb-4">
            <x-heroicon-o-users class="w-5 h-5 md:w-6 md:h-6" />
        </div>
        <p class="text-slate-400 text-[10px] md:text-xs font-black uppercase tracking-widest">
            Total Anak
        </p>
        <h3 class="text-xl md:text-2xl font-black text-slate-800">
            {{ $totalChildren }}
        </h3>
    </div>

    {{-- Total Bunda --}}
    <div class="bg-white p-5 md:p-6 rounded-xl border border-rose-50 shadow-sm transition-all hover:shadow-md">
        <div class="w-10 h-10 md:w-12 md:h-12 bg-rose-100 text-rose-600 rounded-2xl flex items-center justify-center mb-3 md:mb-4">
            <x-heroicon-o-heart class="w-5 h-5 md:w-6 md:h-6" />
        </div>
        <p class="text-slate-400 text-[10px] md:text-xs font-black uppercase tracking-widest">
            Total Bunda
        </p>
        <h3 class="text-xl md:text-2xl font-black text-slate-800">
            {{ $totalParents }}
        </h3>
    </div>

    {{-- Perlu Validasi --}}
    <div class="bg-white p-5 md:p-6 rounded-xl border border-amber-50 shadow-sm transition-all hover:shadow-md sm:col-span-2 lg:col-span-1">
        <div class="w-10 h-10 md:w-12 md:h-12 bg-amber-100 text-amber-600 rounded-2xl flex items-center justify-center mb-3 md:mb-4">
            <x-heroicon-o-clock class="w-5 h-5 md:w-6 md:h-6" />
        </div>
        <p class="text-slate-400 text-[10px] md:text-xs font-black uppercase tracking-widest">
            Perlu Validasi
        </p>
        <h3 class="text-xl md:text-2xl font-black text-amber-600">
            {{ $needValidation }}
        </h3>
    </div>

</div>

{{-- ================= MONITORING TERBARU ================= --}}
<div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden mb-10">

    <div class="p-5 md:p-6 border-b border-slate-50 flex justify-between items-center">
        <h3 class="text-sm md:text-base font-black text-slate-800 uppercase tracking-tighter">
            Monitoring Terbaru
        </h3>
        <span class="text-[10px] md:text-xs bg-slate-100 px-3 py-1 rounded-full font-bold text-slate-500">
            Validasi Admin
        </span>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-4 md:px-6 py-4 text-slate-400 font-black text-[9px] md:text-[10px] uppercase">
                        Anak & Ibu
                    </th>
                    <th class="px-4 md:px-6 py-4 text-slate-400 font-black text-[9px] md:text-[10px] uppercase text-center">
                        Status Gizi
                    </th>
                    <th class="px-4 md:px-6 py-4 text-slate-400 font-black text-[9px] md:text-[10px] uppercase text-center">
                        Tanggal
                    </th>
                </tr>
            </thead>

            <tbody class="divide-y divide-slate-50">
                @forelse($latestMonitoring as $item)
                <tr class="hover:bg-slate-50 transition-colors">
                    <td class="px-4 md:px-6 py-4">
                        <p class="text-sm md:text-base font-bold text-slate-700 leading-tight">
                            {{ $item->child->name }}
                        </p>
                        <p class="text-[10px] md:text-xs text-slate-400 italic">
                            Ibu: {{ $item->child->parent_name }}
                        </p>
                    </td>

                    <td class="px-4 md:px-6 py-4 text-center">
                        <span class="text-xs md:text-sm font-bold text-slate-600">
                            {{ $item->nutritional_status ?? '-' }}
                        </span>
                    </td>

                    <td class="px-4 md:px-6 py-4 text-center">
                        <span class="text-[10px] md:text-xs text-slate-400 font-bold whitespace-nowrap">
                            {{ $item->created_at->diffForHumans() }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="text-center py-10 text-slate-400 text-sm">
                        Belum ada data monitoring
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection