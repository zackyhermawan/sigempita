@extends('layouts.app')

@section('title', 'Kelola Password')

@section('content')

{{-- HEADER --}}
<div class="mb-6 md:mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
    <div>
        <h2 class="text-xl md:text-2xl lg:text-3xl font-black text-slate-800 tracking-tighter uppercase">
            Ganti Password User
        </h2>
        <p class="text-sm md:text-base text-slate-500 font-medium">
            Kelola dan reset password {{ $users->total() }} akun pengguna.
        </p>
    </div>
</div>

{{-- ALERT --}}
@if(session('success'))
    <div class="mb-6 p-4 bg-emerald-50 border border-emerald-100 text-emerald-600 rounded-2xl font-bold text-sm flex items-center">
        <x-heroicon-o-check-circle class="w-5 h-5 mr-2" />
        {{ session('success') }}
    </div>
@endif


{{-- TABLE --}}
<div class="bg-white rounded-xl shadow-sm border border-rose-50 overflow-hidden mb-6">
    <div class="overflow-x-auto">
        <table class="w-full text-left min-w-[700px]">
            <thead>
                <tr class="bg-rose-50/50">
                    <th class="px-4 md:px-6 py-4 text-rose-600 font-bold text-[11px] md:text-sm uppercase tracking-wider">
                        User
                    </th>
                    <th class="px-4 md:px-6 py-4 text-rose-600 font-bold text-[11px] md:text-sm uppercase tracking-wider">
                        Username
                    </th>
                    <th class="px-4 md:px-6 py-4 text-rose-600 font-bold text-[11px] md:text-sm uppercase tracking-wider text-center">
                        Role
                    </th>
                    <th class="px-4 md:px-6 py-4 text-rose-600 font-bold text-[11px] md:text-sm uppercase tracking-wider text-center">
                        Aksi
                    </th>
                </tr>
            </thead>

            <tbody class="divide-y divide-rose-50/50">
                @forelse($users as $user)
                <tr class="hover:bg-rose-50/20 transition-colors">

                    {{-- USER --}}
                    <td class="px-4 md:px-6 py-4">
                        <div class="flex items-center">
                            <div class="w-8 h-8 md:w-10 md:h-10 rounded-full bg-slate-100 text-slate-500 flex items-center justify-center mr-3 font-black shadow-inner text-xs md:text-sm">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                            <div>
                                <p class="font-bold text-slate-700 text-xs md:text-sm leading-tight">
                                    {{ $user->name }}
                                </p>
                            </div>
                        </div>
                    </td>

                    {{-- USERNAME --}}
                    <td class="px-4 md:px-6 py-4">
                        <span class="text-slate-500 text-xs md:text-sm font-medium">
                            {{ $user->username }}
                        </span>
                    </td>

                    {{-- ROLE --}}
                    <td class="px-4 md:px-6 py-4 text-center">
                        <span class="px-2 py-1 bg-slate-50 text-slate-500 rounded-lg text-[9px] md:text-xs font-black uppercase">
                            {{ $user->role ?? 'user' }}
                        </span>
                    </td>

                    {{-- AKSI --}}
                    <td class="px-4 md:px-6 py-4">
                        <div class="flex justify-center">
                            <a href="{{ route('admin.users.password.edit', $user->id) }}"
                               class="px-4 py-2 bg-blue-500 text-white text-[10px] md:text-xs font-black uppercase rounded-xl shadow-sm hover:bg-blue-600 active:scale-95 transition-all">
                                Reset Password
                            </a>
                        </div>
                    </td>

                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-16 text-center">
                        <p class="text-slate-400 font-bold italic text-sm">
                            Tidak ada user ditemukan.
                        </p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- PAGINATION --}}
<div class="px-2 md:px-4">
    {{ $users->links() }}
</div>

@endsection