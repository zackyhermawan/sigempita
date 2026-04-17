@extends('layouts.app')

@section('title', 'Kelola Anak')

@section('content')

{{-- Header: Menyesuaikan tata letak tombol di mobile --}}
<div class="mb-6 md:mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
    <div>
        <h2 class="text-xl md:text-2xl lg:text-3xl font-black text-slate-800 tracking-tighter uppercase">Semua Anak</h2>
        <p class="text-sm md:text-base text-slate-500 font-medium">Monitoring dan kelola {{ $children->total() }} data permata hati.</p>
    </div>
    <a href="/admin/children/create" class="inline-flex items-center justify-center px-6 py-3.5 bg-rose-500 text-white font-black rounded-2xl shadow-lg shadow-rose-100 hover:bg-rose-600 active:scale-95 transition-all text-sm">
        <x-heroicon-o-plus-circle class="w-5 h-5 mr-2" />
        Tambah Data
    </a>
</div>

{{-- SECTION FILTER: Input full width di mobile --}}
<div class="bg-white p-4 md:p-6 rounded-xl shadow-sm border border-rose-50 mb-6 md:mb-8">
    <form action="/admin/children" method="GET" class="flex flex-col md:flex-row gap-3 md:gap-4">
        <div class="flex-1 relative">
            <x-heroicon-o-magnifying-glass class="w-5 h-5 text-slate-400 absolute left-4 top-1/2 -translate-y-1/2" />
            <input type="text" name="search" value="{{ request('search') }}" 
                   placeholder="Cari nama anak atau nama ibu..." 
                   class="w-full pl-11 pr-4 py-3 bg-slate-50 border-none rounded-2xl text-xs md:text-sm font-bold text-slate-700 focus:ring-2 focus:ring-rose-100 transition-all">
        </div>
        <div class="flex gap-2 w-full md:w-auto">
            <button type="submit" class="flex-1 md:flex-none px-6 md:px-8 py-3 bg-slate-800 text-white font-black rounded-2xl uppercase text-[10px] md:text-xs tracking-widest hover:bg-slate-700 transition-all">
                Cari
            </button>
            @if(request('search'))
                <a href="/admin/children" class="px-4 py-3 bg-slate-100 text-slate-400 rounded-2xl flex items-center justify-center hover:bg-slate-200 transition-all">
                    <x-heroicon-o-arrow-path class="w-5 h-5" />
                </a>
            @endif
        </div>
    </form>
</div>

{{-- TABEL DATA: Pengaturan padding responsif --}}
<div class="bg-white rounded-xl shadow-sm border border-rose-50 overflow-hidden mb-6">
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-rose-50/50">
                    <th class="px-4 md:px-6 py-4 text-rose-600 font-bold text-[11px] md:text-sm uppercase tracking-wider">Nama Anak & Ibu</th>
                    <th class="px-4 md:px-6 py-4 text-rose-600 font-bold text-[11px] md:text-sm uppercase tracking-wider">Jenis Kelamin</th>
                    <th class="px-4 md:px-6 py-4 text-rose-600 font-bold text-[11px] md:text-sm uppercase tracking-wider text-center">Tanggal Lahir</th>
                    <th class="px-4 md:px-6 py-4 text-rose-600 font-bold text-[11px] md:text-sm uppercase tracking-wider text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-rose-50/50">
                @forelse($children as $child)
                <tr class="hover:bg-rose-50/20 transition-colors">
                    <td class="px-4 md:px-6 py-4">
                        <div class="flex items-center">
                            <div class="hidden xs:flex w-8 h-8 md:w-10 md:h-10 rounded-full bg-rose-100 text-rose-500 items-center justify-center mr-2 md:mr-3 font-black shadow-inner text-xs md:text-base">
                                {{ substr($child->name, 0, 1) }}
                            </div>
                            <div class="min-w-0">
                                <p class="font-bold text-slate-700 text-xs md:text-sm leading-tight truncate">{{ $child->name }}</p>
                                <p class="text-[9px] md:text-[10px] text-slate-400 font-bold mt-1 italic leading-none truncate">Ibu: {{ $child->parent_name }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-4 md:px-6 py-4">
                        <span class="px-2 py-1 bg-slate-50 text-slate-500 rounded-lg text-[9px] md:text-xs font-black uppercase whitespace-nowrap">
                            {{ $child->gender }}
                        </span>
                    </td>

                    <td class="px-4 md:px-6 py-4 text-center">
                        <span class="inline-block px-2 md:px-3 py-1 bg-slate-50 text-slate-500 rounded-lg text-[9px] md:text-[11px] font-black border border-slate-100 italic whitespace-nowrap">
                            {{ \Carbon\Carbon::parse($child->date_of_birth)->format('d M Y') }}
                        </span>
                    </td>
                    <td class="px-4 md:px-6 py-4">
                        <div class="flex justify-center gap-1 md:gap-2">
                            <a href="/admin/children/{{ $child->id }}/edit" class="p-2.5 bg-amber-50 text-amber-600 rounded-xl hover:bg-amber-100 active:scale-90 transition-all shadow-sm border border-amber-100">
                                <x-heroicon-o-pencil-square class="w-4 h-4 md:w-5 md:h-5" />
                            </a>
                            <form action="/admin/children/{{ $child->id }}" method="POST" onsubmit="return confirm('Hapus data?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="p-2.5 bg-rose-50 text-rose-500 rounded-xl hover:bg-rose-100 active:scale-90 transition-all shadow-sm border border-rose-100 cursor-pointer">
                                    <x-heroicon-o-trash class="w-4 h-4 md:w-5 md:h-5" />
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="px-6 py-16 text-center">
                        <p class="text-slate-400 font-bold italic text-sm">Data anak tidak ditemukan.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- PAGINATION: Menghilangkan padding berlebih di mobile --}}
<div class="px-2 md:px-4">
    {{ $children->links() }}
</div>

@endsection