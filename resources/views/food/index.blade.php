@extends('layouts.app')

@section('title', 'Catatan Makan')

@section('content')

{{-- HEADER: Responsif layout --}}
<div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4 px-2">
    <div>
        <h3 class="text-slate-500 text-xs md:text-sm font-medium uppercase tracking-wider">Nutrisi Si Kecil</h3>
    </div>
    <a href="/food/create" class="inline-flex items-center justify-center px-6 py-3.5 bg-rose-500 text-white font-black rounded-2xl shadow-lg shadow-rose-100 hover:bg-rose-600 active:scale-95 transition-all text-sm">
        <x-heroicon-o-plus class="w-5 h-5 mr-2" />
        Tambah Makanan
    </a>
</div>

{{-- SECTION FILTER: Diperbaiki agar tidak terlalu rapat di HP --}}
<div class="bg-white p-5 md:p-6 rounded-2xl md:rounded-3xl shadow-sm border border-amber-100 mb-6 mx-2">
    <form action="/food" method="GET" class="space-y-4 md:space-y-0 md:grid md:grid-cols-4 md:gap-4">
        {{-- Filter Anak --}}
        <div>
            <label class="text-[10px] font-black text-slate-400 uppercase mb-1.5 block ml-1 tracking-widest italic">Pilih Anak</label>
            <select name="child_id" class="w-full px-4 py-3 bg-slate-100 border-none rounded-xl text-sm font-bold text-slate-700 focus:ring-2 focus:ring-rose-200 transition-all appearance-none bg-no-repeat bg-[right_1rem_center]">
                <option value="">Semua Anak</option>
                @foreach($children as $child)
                    <option value="{{ $child->id }}" {{ request('child_id') == $child->id ? 'selected' : '' }}>{{ $child->name }}</option>
                @endforeach
            </select>
        </div>

        {{-- Filter Waktu Makan --}}
        <div>
            <label class="text-[10px] font-black text-slate-400 uppercase mb-1.5 block ml-1 tracking-widest italic">Waktu Makan</label>
            <select name="feeding_period" class="w-full px-4 py-3 bg-slate-100 border-none rounded-xl text-sm font-bold text-slate-700 focus:ring-2 focus:ring-rose-200 transition-all">
                <option value="">Semua Waktu</option>
                @foreach(['Pagi', 'Siang', 'Sore', 'Malam'] as $period)
                    <option value="{{ $period }}" {{ request('feeding_period') == $period ? 'selected' : '' }}>{{ $period }}</option>
                @endforeach
            </select>
        </div>

        {{-- Filter Tanggal --}}
        <div>
            <label class="text-[10px] font-black text-slate-400 uppercase mb-1.5 block ml-1 tracking-widest italic">Tanggal</label>
            <input type="date" name="date" value="{{ request('date') }}" class="w-full px-4 py-3 bg-slate-100 border-none rounded-xl text-sm font-bold text-slate-700 focus:ring-2 focus:ring-rose-200 transition-all">
        </div>

        {{-- Tombol Aksi: Flex-col di HP agar tombol lebar --}}
        <div class="flex items-end gap-2 pt-2 md:pt-0">
            <button type="submit" class="flex-1 py-3 bg-slate-800 text-white font-black rounded-xl text-xs uppercase tracking-widest hover:bg-slate-700 transition-all shadow-md active:scale-95">
                Filter
            </button>
            <a href="/food" class="px-4 py-3 bg-slate-100 text-slate-500 font-bold rounded-xl text-xs uppercase tracking-widest flex items-center justify-center hover:bg-slate-200 transition-all active:scale-95">
                Reset
            </a>
        </div>
    </form>
</div>

@if(session('success'))
    <div class="bg-emerald-50 border border-emerald-100 text-emerald-600 p-4 mb-6 rounded-2xl flex items-center mx-2 shadow-sm">
        <x-heroicon-o-check-circle class="w-6 h-6 mr-3 shrink-0" />
        <span class="font-bold text-sm">{{ session('success') }}</span>
    </div>
@endif

{{-- TABEL: min-width untuk scroll horizontal --}}
<div class="bg-white rounded-2xl md:rounded-3xl shadow-sm border border-amber-50 overflow-hidden mx-2">
    <div class="overflow-x-auto w-full">
        <table class="w-full text-left border-collapse min-w-[750px]">
            <thead>
                <tr class="bg-rose-50/50">
                    <th class="px-6 py-5 text-rose-600 font-black text-[11px] md:text-xs uppercase tracking-widest">Anak</th>
                    <th class="px-6 py-5 text-rose-600 font-black text-[11px] md:text-xs uppercase tracking-widest text-center">Tanggal</th>
                    <th class="px-6 py-5 text-rose-600 font-black text-[11px] md:text-xs uppercase tracking-widest">Menu Makanan</th>
                    <th class="px-6 py-5 text-rose-600 font-black text-[11px] md:text-xs uppercase tracking-widest text-center">Jam Makan</th>
                    <th class="px-6 py-5 text-rose-600 font-black text-[11px] md:text-xs uppercase tracking-widest text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-amber-50">
                @forelse($records as $item)
                <tr class="hover:bg-amber-50/10 transition-colors">
                    <td class="px-6 py-4">
                        <span class="font-black text-slate-700 text-sm md:text-base">{{ $item->child->name }}</span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <span class="text-slate-600 font-bold text-xs md:text-sm whitespace-nowrap bg-slate-50 px-3 py-1.5 rounded-lg border border-slate-100">
                            {{ \Carbon\Carbon::parse($item->record_date)->locale('id')->translatedFormat('d F Y') }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            <div class="p-2.5 bg-rose-100/50 rounded-xl mr-3 border border-rose-100">
                                <x-heroicon-o-cake class="w-4 h-4 text-rose-600" />
                            </div>
                            <span class="text-slate-700 font-extrabold text-sm md:text-base leading-tight">{{ $item->food_type }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <span class="text-[10px] md:text-xs font-black uppercase px-3 py-1 bg-amber-50 text-amber-600 rounded-full border border-amber-100">
                            {{ $item->feeding_period }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex justify-center items-center gap-2">
                            <a href="/food/{{ $item->id }}/edit" class="p-2.5 bg-amber-50 text-amber-600 rounded-xl hover:bg-amber-100 active:scale-90 transition-all border border-amber-100 shadow-sm" title="Edit Data">
                                <x-heroicon-o-pencil-square class="w-5 h-5" />
                            </a>
                            <form action="/food/{{ $item->id }}" method="POST" onsubmit="return confirm('Hapus catatan makan ini?')">
                                @csrf @method('DELETE')
                                <button class="p-2.5 bg-rose-50 text-rose-500 rounded-xl hover:bg-rose-100 active:scale-90 transition-all border border-rose-100 shadow-sm cursor-pointer" title="Hapus Data">
                                    <x-heroicon-o-trash class="w-5 h-5" />
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-16 text-center">
                        <div class="flex flex-col items-center">
                            <x-heroicon-o-clipboard-document-list class="w-12 h-12 text-slate-200 mb-3" />
                            <p class="text-slate-400 italic text-sm font-medium">Belum ada catatan makanan yang ditemukan.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Pagination --}}
<div class="mt-8 px-4">
    {{ $records->links() }}
</div>

@endsection