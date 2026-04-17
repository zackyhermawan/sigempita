@extends('layouts.app')

@section('title', 'Monitoring Validasi ')

@section('content')
<div class="mb-6 md:mb-8">
    <h2 class="text-xl md:text-2xl lg:text-3xl font-black text-slate-800 tracking-tighter uppercase">Monitoring Data Anak</h2>
    <p class="text-sm md:text-base text-slate-500 font-medium">Pantau dan validasi kondisi pertumbuhan anak.</p>
</div>

<div class="bg-white rounded-xl shadow-sm border border-rose-50 overflow-hidden">
    {{-- Container untuk scroll horizontal di mobile --}}
    <div class="overflow-x-auto w-full">
        <table class="min-w-[700px] w-full text-left">
            <thead>
                <tr class="bg-rose-50/50">
                    <th class="px-4 md:px-6 py-4 text-rose-600 font-bold text-[11px] md:text-sm uppercase tracking-wider">Nama Anak & Ibu</th>
                    <th class="px-4 md:px-6 py-4 text-rose-600 font-bold text-[11px] md:text-sm uppercase tracking-wider text-center">Pertumbuhan Terakhir</th>
                    <th class="px-4 md:px-6 py-4 text-rose-600 font-bold text-[11px] md:text-sm uppercase tracking-wider text-center">Status</th>
                    <th class="px-4 md:px-6 py-4 text-rose-600 font-bold text-[11px] md:text-sm uppercase tracking-wider text-center">Aksi</th>
                    <th class="px-4 md:px-6 py-4 text-rose-600 font-bold text-[11px] md:text-sm uppercase tracking-wider text-center">Riwayat</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-rose-50/50">
                @forelse($data as $item)

                @php
                    $lastGrowth = $item['last_growth'];
                    $lastMonitoring = $item['monitoring'];
                    $isNewData = false;

                    if($lastGrowth && $lastMonitoring){
                        $isNewData = \Carbon\Carbon::parse($lastGrowth->record_date)
                            ->gt(\Carbon\Carbon::parse($lastMonitoring->created_at));
                    }
                @endphp

                <tr class="hover:bg-rose-50/10 transition-colors">

                    {{-- Anak --}}
                    <td class="px-4 md:px-6 py-4">
                        <div class="flex items-center min-w-[150px]">
                            <div class="hidden sm:flex w-8 h-8 md:w-10 md:h-10 rounded-full bg-slate-100 items-center justify-center mr-3 font-black text-slate-400 text-xs md:text-base">
                                {{ substr($item['child']->name, 0, 1) }}
                            </div>
                            <div>
                                <p class="font-black text-slate-700 text-xs md:text-sm leading-tight">
                                    {{ $item['child']->name }}
                                </p>
                                <p class="text-[9px] md:text-[10px] text-slate-400 font-bold uppercase italic mt-0.5">
                                    Ibu: {{ $item['child']->parent_name }}
                                </p>

                                @if($isNewData)
                                    <span class="inline-block mt-1 text-[7px] md:text-[8px] bg-amber-200 text-amber-700 px-2 py-0.5 rounded-full font-black uppercase">
                                        Data Baru
                                    </span>
                                @endif
                            </div>
                        </div>
                    </td>

                    {{-- Data terakhir --}}
                    <td class="px-4 md:px-6 py-4 text-center">
                        @if($lastGrowth)
                            <span class="text-xs md:text-sm font-black text-slate-700 whitespace-nowrap">
                                {{ $lastGrowth->weight }}kg / {{ $lastGrowth->height }}cm
                            </span>
                        @else
                            <span class="text-[10px] md:text-xs text-slate-400 italic">Belum ada data</span>
                        @endif
                    </td>

                    {{-- STATUS --}}
                    <td class="px-4 md:px-6 py-4 text-center">
                        @php
                            $badgeClass = 'text-[9px] md:text-[10px] px-3 py-1 rounded-full font-black uppercase whitespace-nowrap ';
                            if($item['status'] == 'warning') $badgeClass .= 'bg-rose-100 text-rose-600';
                            elseif($isNewData) $badgeClass .= 'bg-amber-100 text-amber-600';
                            elseif($item['status'] == 'reviewed') $badgeClass .= 'bg-emerald-100 text-emerald-600';
                            else $badgeClass .= 'bg-amber-100 text-amber-600';
                        @endphp
                        
                        <span class="{{ $badgeClass }}">
                            @if($item['status'] == 'warning') Tidak Update
                            @elseif($isNewData) Perlu Validasi
                            @elseif($item['status'] == 'reviewed') Sudah Dinilai
                            @else Pending
                            @endif
                        </span>
                    </td>

                    {{-- AKSI --}}
                    <td class="px-4 md:px-6 py-4 text-center">
                        <a href="/admin/monitoring/{{ $item['child']->id }}/edit"
                           class="inline-block px-4 md:px-6 py-2 bg-rose-500 text-white text-[9px] md:text-[10px] font-black uppercase rounded-lg md:rounded-xl hover:bg-rose-600 active:scale-[0.98] transition-all shadow-md whitespace-nowrap">
                            Tanggapi
                        </a>
                    </td>

                    {{-- RIWAYAT --}}
                    <td class="px-4 md:px-6 py-4 text-center">
                        <a href="/admin/monitoring/history/{{ $item['child']->id }}"
                           class="inline-block px-4 md:px-6 py-2 bg-blue-500 text-white text-[9px] md:text-[10px] font-black uppercase rounded-lg md:rounded-xl hover:bg-blue-600 active:scale-[0.98] transition-all shadow-md whitespace-nowrap">
                            Riwayat
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-10 text-slate-400 font-semibold italic text-sm">
                        Tidak ada data monitoring ditemukan.
                    </td>
                </tr>
                @endforelse

            </tbody>
        </table>
    </div>
</div>

<div class="mt-6 md:mt-8 px-4">
    {{ $data->links() }}
</div>
@endsection