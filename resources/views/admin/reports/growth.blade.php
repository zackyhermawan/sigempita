@extends('layouts.app')

@section('title', 'Laporan Pertumbuhan')

@section('content')
<div class="mb-8">
    <h2 class="text-2xl font-black text-slate-800 uppercase">Laporan Pertumbuhan Anak</h2>
    <p class="text-slate-500 font-medium">Data perkembangan anak yang telah divalidasi.</p>
</div>

{{-- Filter Box --}}
<div class="bg-white p-6 rounded-xl shadow-sm border border-slate-100 mb-6">
    <form action="{{ route('admin.reports.growth') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="flex flex-col">
            <label class="text-xs font-bold text-slate-400 uppercase ml-2 mb-1">Anak</label>
            <select name="child_id" class="w-full px-4 py-3 bg-slate-100 border-none rounded-xl text-sm font-bold focus:ring-2 focus:ring-rose-100">
                <option value="">Semua Anak</option>
                @foreach($children as $c)
                    <option value="{{ $c->id }}" {{ request('child_id') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="flex flex-col">
            <label class="text-xs font-bold text-slate-400 uppercase ml-2 mb-1">Status Gizi</label>
            <select name="status" class="w-full px-4 py-3 bg-slate-100 border-none rounded-xl text-sm font-bold focus:ring-2 focus:ring-rose-100">
                <option value="">Semua Status</option>
                <option value="Gizi Baik" {{ request('status') == 'Gizi Baik' ? 'selected' : '' }}>Gizi Baik</option>
                <option value="Gizi Kurang" {{ request('status') == 'Gizi Kurang' ? 'selected' : '' }}>Gizi Kurang</option>
                <option value="Gizi Lebih" {{ request('status') == 'Gizi Lebih' ? 'selected' : '' }}>Gizi Lebih</option>
                <option value="Obesitas" {{ request('status') == 'Obesitas' ? 'selected' : '' }}>Obesitas</option>
                <option value="Stunting" {{ request('status') == 'Stunting' ? 'selected' : '' }}>Stunting</option>
            </select>
        </div>
        
        {{-- Tombol Aksi --}}
        <div class="md:col-span-2 flex items-end gap-2">
            <button type="submit" class="flex-1 py-3 bg-rose-500 text-white font-bold rounded-xl uppercase text-xs tracking-widest shadow-lg shadow-rose-100 hover:bg-rose-600 transition-all">
                Filter Data
            </button>
            <a href="{{ route('admin.reports.growth') }}" class="px-6 py-3 bg-slate-100 text-slate-500 font-bold rounded-xl uppercase text-xs tracking-widest hover:bg-slate-200 transition-all text-center flex items-center justify-center">
                Reset
            </a>
        </div>
    </form>
</div>

<div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
    <table class="w-full text-left">
        <thead >
            <tr class="bg-rose-50/50">
                <th class="px-6 py-4 text-rose-600 font-bold text-sm uppercase tracking-wider">Nama Anak</th>
                <th class="px-6 py-4 text-rose-600 font-bold text-sm uppercase tracking-wider text-center">BB/TB</th>
                <th class="px-6 py-4 text-rose-600 font-bold text-sm uppercase tracking-wider text-center">Status Gizi</th>
                <th class="px-6 py-4 text-rose-600 font-bold text-sm uppercase tracking-wider text-center">Tgl Penilaian</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-rose-50/30">
            @forelse($growthRecords as $g)
            <tr class="hover:bg-rose-50/10 transition-colors">
                <td class="px-6 py-4 font-bold text-slate-700 text-sm">{{ $g->child->name }}</td>
                <td class="px-6 py-4 text-center font-black text-slate-500 text-sm">{{ $g->weight }}kg / {{ $g->height }}cm</td>
                @php
                    $status = $g->child->latestGrowthRecord->nutritional_status ?? null;

                    $color = match($status) {
                        'Gizi Baik' => 'bg-emerald-50 text-emerald-600',
                        'Gizi Kurang' => 'bg-yellow-50 text-yellow-600',
                        'Gizi Lebih' => 'bg-orange-50 text-orange-600',
                        'Obesitas' => 'bg-red-50 text-red-600',
                        'Stunting' => 'bg-blue-50 text-blue-600',
                        default => 'bg-gray-50 text-gray-600',
                    };
                @endphp
                <td class="px-6 py-4 text-center">
                    <span class="px-3 py-1 {{ $color }} rounded-lg text-xs font-black uppercase border border-emerald-100">
                        {{ $g->nutritional_status }}
                    </span>
                </td>
                <td class="px-6 py-4 text-center text-sm font-bold text-slate-400 italic">
                    {{ \Carbon\Carbon::parse($g->record_date)->format('d F Y') }}
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="px-6 py-10 text-center text-slate-400 italic text-sm">
                    Tidak ada data pertumbuhan yang ditemukan.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-6">
    {{ $growthRecords->links() }}
</div>
@endsection