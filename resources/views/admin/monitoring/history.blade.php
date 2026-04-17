@extends('layouts.app')

@section('title', 'Riwayat Validasi Data Anak')

@section('content')
<div class="mb-6 md:mb-8 px-2">
    <a href="/admin/monitoring" class="inline-flex items-center text-rose-500 font-bold mb-4 md:mb-6 hover:translate-x-1 transition-transform text-sm md:text-base">
        <x-heroicon-o-arrow-left class="w-4 h-4 md:w-5 md:h-5 mr-2" />
        Kembali
    </a>
    <h2 class="text-xl md:text-2xl font-black text-slate-800 uppercase tracking-tight">Riwayat Validasi</h2>
    <p class="text-sm md:text-base text-slate-500 font-medium">
        Data validasi resmi untuk anak: 
        <span class="text-rose-500 font-bold">{{ $child->name }}</span>
    </p>
</div>

<div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden mx-2">
    {{-- Tambahkan min-width pada tabel agar scroll horizontal muncul di HP --}}
    <div class="overflow-x-auto w-full">
        <table class="w-full text-left min-w-[650px] border-collapse">
            <thead>
                <tr class="bg-rose-50/50">
                    <th class="px-4 md:px-6 py-4 text-rose-600 font-bold text-[11px] md:text-sm uppercase tracking-wider">Nama Anak & Ibu</th>
                    <th class="px-4 md:px-6 py-4 text-rose-600 font-bold text-[11px] md:text-sm uppercase tracking-wider text-center">BB/TB</th>
                    <th class="px-4 md:px-6 py-4 text-rose-600 font-bold text-[11px] md:text-sm uppercase tracking-wider text-center">Status Gizi</th>
                    <th class="px-4 md:px-6 py-4 text-rose-600 font-bold text-[11px] md:text-sm uppercase tracking-wider text-center">Tgl Validasi</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-slate-50">
                @forelse($monitorings as $item)
                <tr class="hover:bg-slate-50/50 transition-colors">

                    {{-- Anak --}}
                    <td class="px-4 md:px-6 py-4">
                        <p class="font-bold text-slate-700 text-xs md:text-sm leading-tight">
                            {{ $item->child->name }}
                        </p>
                        <p class="text-[10px] md:text-xs text-slate-400 font-bold italic mt-0.5">
                            Ibu: {{ $item->child->parent_name }}
                        </p>
                    </td>

                    {{-- BB/TB --}}
                    <td class="px-4 md:px-6 py-4 text-center">
                        @if($item->growth)
                            <span class="text-xs md:text-sm font-black text-slate-600 tracking-tight whitespace-nowrap">
                                {{ $item->growth->weight }}kg / {{ $item->growth->height }}cm
                            </span>
                        @else
                            <span class="text-[10px] md:text-xs text-slate-400 italic">
                                Tidak ada data
                            </span>
                        @endif
                    </td>

                    {{-- STATUS GIZI --}}
                    @php
                        $status = $item->nutritional_status;
                        $color = match($status) {
                            'Gizi Baik' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                            'Gizi Kurang' => 'bg-amber-50 text-amber-600 border-amber-100',
                            'Gizi Lebih' => 'bg-orange-50 text-orange-600 border-orange-100',
                            'Obesitas' => 'bg-rose-50 text-rose-600 border-rose-100',
                            'Stunting' => 'bg-blue-50 text-blue-600 border-blue-100',
                            default => 'bg-slate-50 text-slate-600 border-slate-100',
                        };
                    @endphp

                    <td class="px-4 md:px-6 py-4 text-center">
                        <span class="inline-block px-3 md:px-4 py-1.5 rounded-lg text-[9px] md:text-[10px] font-black uppercase border shadow-sm whitespace-nowrap {{ $color }}">
                            {{ $status ?? '-' }}
                        </span>
                    </td>

                    {{-- TANGGAL --}}
                    <td class="px-4 md:px-6 py-4 text-center">
                        <div class="flex flex-col whitespace-nowrap">
                            <span class="text-xs md:text-sm font-black text-slate-700 italic uppercase">
                                {{ \Carbon\Carbon::parse($item->created_at)->format('d F Y') }}
                            </span>
                            <span class="text-[9px] md:text-[11px] font-bold text-slate-400">
                                {{ $item->created_at->diffForHumans() }}
                            </span>
                        </div>
                    </td>

                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center py-10 text-slate-400 font-semibold italic text-sm">
                        Belum ada riwayat validasi ditemukan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-6 px-4">
    {{ $monitorings->links() }}
</div>
@endsection