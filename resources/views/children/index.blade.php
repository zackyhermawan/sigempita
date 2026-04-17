@extends('layouts.app')

@section('title', 'Daftar Si Kecil')

@section('content')

{{-- HEADER: Responsif gap dan alignment --}}
<div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4 px-2">
    <div>
        <h3 class="text-slate-500 text-xs md:text-sm font-medium uppercase tracking-wider">Manajemen Data</h3>
        <p class="text-slate-800 font-extrabold text-base md:text-lg">Total Bunda memiliki <span class="text-rose-500">{{ $children->count() }}</span> data anak.</p>
    </div>
    <a href="/children/create" class="inline-flex items-center justify-center px-6 py-3.5 bg-rose-500 text-white font-black rounded-2xl shadow-lg shadow-rose-100 hover:bg-rose-600 active:scale-95 transition-all text-sm">
        <x-heroicon-o-plus class="w-5 h-5 mr-2" />
        Tambah Anak
    </a>
</div>

{{-- ALERT: Alert yang lebih manis di mobile --}}
@if(session('success'))
    <div class="bg-emerald-50 border border-emerald-100 text-emerald-600 p-4 mb-6 rounded-2xl flex items-center mx-2 shadow-sm">
        <x-heroicon-o-check-circle class="w-6 h-6 mr-3 shrink-0" />
        <span class="font-bold text-sm">{{ session('success') }}</span>
    </div>
@endif

{{-- TABEL CONTAINER: overflow-x-auto adalah kunci --}}
<div class="bg-white rounded-2xl md:rounded-3xl shadow-sm border border-rose-50 overflow-hidden mx-2">
    <div class="overflow-x-auto w-full">
        {{-- Set min-w-[800px] agar tabel tidak gepeng di layar kecil --}}
        <table class="w-full text-left border-collapse min-w-[800px]">
            <thead>
                <tr class="bg-rose-50/50">
                    <th class="px-6 py-5 text-rose-600 font-black text-[11px] md:text-xs uppercase tracking-widest">Nama Anak</th>
                    <th class="px-6 py-5 text-rose-600 font-black text-[11px] md:text-xs uppercase tracking-widest text-center">Tanggal Lahir</th>
                    <th class="px-6 py-5 text-rose-600 font-black text-[11px] md:text-xs uppercase tracking-widest text-center">Jenis Kelamin</th>
                    <th class="px-6 py-5 text-rose-600 font-black text-[11px] md:text-xs uppercase tracking-widest">Orang Tua</th>
                    <th class="px-6 py-5 text-rose-600 font-black text-[11px] md:text-xs uppercase tracking-widest text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-rose-50">
                @foreach($children as $child)
                <tr class="hover:bg-rose-50/20 transition-colors">
                    {{-- Nama Anak --}}
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-rose-100 to-rose-50 text-rose-500 flex items-center justify-center mr-3 shadow-sm border border-rose-100">
                                <x-heroicon-o-user class="w-6 h-6" />
                            </div>
                            <span class="font-bold text-slate-700 text-sm md:text-base">{{ $child->name }}</span>
                        </div>
                    </td>

                    {{-- Tgl Lahir --}}
                    <td class="px-6 py-4 text-center">
                        <span class="text-slate-600 font-bold text-xs md:text-sm whitespace-nowrap">
                            {{ \Carbon\Carbon::parse($child->date_of_birth)->format('d F Y') }}
                        </span>
                    </td>

                    {{-- Kelamin --}}
                    <td class="px-6 py-4 text-center">
                        <span class="px-3 py-1 bg-slate-100 text-slate-600 rounded-lg text-[10px] md:text-xs font-black uppercase tracking-tight">
                            {{ $child->gender }}
                        </span>
                    </td>

                    {{-- Orang Tua --}}
                    <td class="px-6 py-4">
                        <span class="text-slate-500 text-xs md:text-sm font-medium italic">
                            Bunda {{ $child->parent_name }}
                        </span>
                    </td>

                    {{-- Aksi --}}
                    <td class="px-6 py-4">
                        <div class="flex justify-center items-center gap-3">
                            <a href="/children/{{ $child->id }}/edit" 
                               class="p-2.5 bg-amber-50 text-amber-600 rounded-xl hover:bg-amber-100 active:scale-90 transition-all shadow-sm border border-amber-100"
                               title="Edit Data">
                                <x-heroicon-o-pencil-square class="w-5 h-5" />
                            </a>

                            <form action="/children/{{ $child->id }}" method="POST" onsubmit="return confirm('Apakah Bunda yakin ingin menghapus data ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="p-2.5 bg-rose-50 text-rose-500 rounded-xl hover:bg-rose-100 active:scale-90 transition-all shadow-sm border border-rose-100 cursor-pointer"
                                        title="Hapus Data">
                                    <x-heroicon-o-trash class="w-5 h-5" />
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    {{-- FOOTER INFO: Muncul jika data kosong --}}
    @if($children->isEmpty())
        <div class="py-12 text-center text-slate-400 italic text-sm">
            Belum ada data anak yang terdaftar.
        </div>
    @endif
</div>

@endsection