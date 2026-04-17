@extends('layouts.app')

@section('title', 'Laporan Konsumsi')

@section('content')
{{-- Header responsif --}}
<div class="mb-6 md:mb-8 flex flex-col md:flex-row md:items-end justify-between gap-4">
    <div>
        <h2 class="text-xl md:text-2xl lg:text-3xl font-black text-slate-800 uppercase tracking-tighter">Laporan Konsumsi</h2>
        <p class="text-sm md:text-base text-slate-500 font-medium">Monitoring pola makan seluruh anak.</p>
    </div>
</div>

{{-- SECTION FILTER: Menyesuaikan grid untuk mobile --}}
<div class="bg-white p-4 md:p-6 rounded-xl shadow-sm border border-slate-100 mb-6">
    <form action="{{ route('admin.reports.food') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="flex flex-col">
            <label class="text-[10px] md:text-xs font-bold text-slate-400 uppercase ml-2 mb-1">Anak</label>
            <select name="child_id" class="px-4 py-3 bg-slate-50 border-none rounded-xl text-xs md:text-sm font-bold text-slate-700 focus:ring-2 focus:ring-rose-100 transition-all">
                <option value="">Semua Anak</option>
                @foreach($children as $c)
                    <option value="{{ $c->id }}" {{ request('child_id') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="flex flex-col">
            <label class="text-[10px] md:text-xs font-bold text-slate-400 uppercase ml-2 mb-1">Tanggal</label>
            <input type="date" name="date" value="{{ request('date') }}" class="px-4 py-3 bg-slate-50 border-none rounded-xl text-xs md:text-sm font-bold text-slate-700 focus:ring-2 focus:ring-rose-100 transition-all">
        </div>
        <div class="sm:col-span-2 flex items-end gap-2">
            <button type="submit" class="flex-1 py-3 bg-slate-800 text-white font-bold rounded-xl uppercase text-[10px] md:text-xs tracking-widest shadow-lg hover:bg-slate-700 transition-all">
                Filter
            </button>
            <a href="{{ route('admin.reports.food') }}" class="px-4 md:px-6 py-3 bg-slate-100 text-slate-500 font-bold rounded-xl uppercase text-[10px] md:text-xs tracking-widest hover:bg-slate-200 transition-all text-center flex items-center justify-center">
                Reset
            </a>
        </div>
    </form>
</div>

{{-- TABEL DATA: Dengan overflow horizontal untuk layar sempit --}}
<div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden mb-6">
    <div class="overflow-x-auto w-full">
        <table class="min-w-[700px] w-full text-left">
            <thead>
                <tr class="bg-rose-50/50">
                    <th class="px-4 md:px-6 py-4 text-rose-600 font-bold text-[11px] md:text-sm uppercase tracking-wider">Nama Anak</th>
                    <th class="px-4 md:px-6 py-4 text-rose-600 font-bold text-[11px] md:text-sm uppercase tracking-wider text-center">Waktu</th>
                    <th class="px-4 md:px-6 py-4 text-rose-600 font-bold text-[11px] md:text-sm uppercase tracking-wider">Menu</th>
                    <th class="px-4 md:px-6 py-4 text-rose-600 font-bold text-[11px] md:text-sm uppercase tracking-wider text-center">Tanggal</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($foodRecords as $f)
                <tr class="hover:bg-slate-50/50 transition-colors">
                    <td class="px-4 md:px-6 py-4">
                        <p class="font-bold text-slate-700 text-xs md:text-sm">{{ $f->child->name }}</p>
                    </td>
                    <td class="px-4 md:px-6 py-4 text-center">
                        <span class="px-2 py-1 bg-slate-100 text-slate-600 rounded text-[9px] md:text-xs font-black uppercase whitespace-nowrap">
                            {{ $f->feeding_period }}
                        </span>
                    </td>
                    <td class="px-4 md:px-6 py-4">
                        <p class="text-[11px] md:text-sm italic text-slate-500 leading-tight">"{{ $f->food_type }}"</p>
                    </td>
                    <td class="px-4 md:px-6 py-4 text-center">
                        <p class="text-[10px] md:text-sm font-bold text-slate-400 whitespace-nowrap">
                            {{ \Carbon\Carbon::parse($f->record_date)->format('d M Y') }}
                        </p>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-12 text-center text-slate-400 text-sm italic">
                        Belum ada rekaman data konsumsi.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- PAGINATION --}}
<div class="mt-4 px-2">
    {{ $foodRecords->links() }}
</div>
@endsection