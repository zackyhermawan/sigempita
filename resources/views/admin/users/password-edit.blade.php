@extends('layouts.app')

@section('title', 'Reset Password User')

@section('content')

<div class="max-w-2xl mx-auto py-2 md:py-4">

    {{-- BACK BUTTON --}}
    <a href="{{ route('admin.users.password.index') }}"
       class="inline-flex items-center text-rose-500 font-bold mb-4 md:mb-6 hover:translate-x-1 transition-transform text-sm md:text-base">
        <x-heroicon-o-arrow-left class="w-4 h-4 md:w-5 md:h-5 mr-2" />
        Kembali
    </a>

    {{-- CARD --}}
    <div class="bg-white rounded-xl md:rounded-xl p-6 md:p-10 shadow-sm border border-rose-50 relative overflow-hidden">

        {{-- HEADER --}}
        <div class="mb-8 md:mb-10">
            <div class="flex items-center justify-between gap-4">

                <div>
                    <h2 class="text-2xl md:text-3xl font-black text-slate-800 leading-tight">
                        Reset Password User
                    </h2>
                    <p class="text-xs md:text-sm text-slate-400 font-medium mt-1">
                        User: <span class="font-bold text-slate-600">{{ $user->name }}</span>
                    </p>
                </div>

                <div class="w-12 h-12 md:w-16 md:h-16 bg-rose-50 text-rose-500 rounded-xl flex items-center justify-center shadow-inner flex-shrink-0">
                    <x-heroicon-o-key class="w-6 h-6 md:w-8 md:h-8" />
                </div>

            </div>
        </div>

        {{-- FORM --}}
        <form action="{{ route('admin.users.password.update', $user->id) }}"
            onsubmit="handleLogin(this)"
              method="POST"
              class="space-y-5 md:space-y-8">

            @csrf
            @method('PUT')

            {{-- PASSWORD BARU --}}
            <div class="space-y-1 md:space-y-2">
                <label class="block text-xs md:text-sm font-bold text-slate-700 mb-1 ml-1">
                    Password Baru
                </label>

                <input type="password" name="password" required
                    class="w-full px-5 py-4 bg-slate-50 border-none rounded-xl md:rounded-2xl
                    focus:ring-2 focus:ring-rose-400 font-bold text-slate-700 shadow-inner
                    transition-all text-xs md:text-sm">

                @error('password')
                    <p class="text-rose-500 text-[10px] font-black ml-3 uppercase mt-1">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- KONFIRMASI PASSWORD --}}
            <div class="space-y-1 md:space-y-2">
                <label class="block text-xs md:text-sm font-bold text-slate-700 mb-1 ml-1">
                    Konfirmasi Password
                </label>

                <input type="password" name="password_confirmation" required
                    class="w-full px-5 py-4 bg-slate-50 border-none rounded-xl md:rounded-2xl
                    focus:ring-2 focus:ring-rose-400 font-bold text-slate-700 shadow-inner
                    transition-all text-xs md:text-sm">
            </div>

            {{-- BUTTON --}}
            <div class="pt-4 md:pt-6">
                <button id="updateBtn" type="submit"
                    class="flex items-center justify-center gap-3 w-full py-4 md:py-5 bg-rose-500 text-white font-black rounded-xl md:rounded-2xl
                    shadow-xl shadow-rose-100 hover:bg-rose-600 active:scale-[0.98]
                    transition-all uppercase tracking-widest text-xs md:text-sm cursor-pointer">
                    <span id="btnText">Reset Password</span>
                    <div id="spinner" class="hidden animate-spin rounded-full h-5 w-5 border-2 border-white border-t-transparent"></div>
                </button>
            </div>

        </form>

    </div>
</div>

<script>
    function handleLogin(form) {
        const btn = document.getElementById('updateBtn');
        const text = document.getElementById('btnText');
        const spinner = document.getElementById('spinner');

        // 1. Matikan tombol biar gak di-klik dua kali
        btn.disabled = true;
        
        // 2. Ubah tampilan tombol (agak transparan & kursor berubah)
        btn.classList.add('opacity-80', 'cursor-not-allowed');

        // 3. Ganti teks & munculkan spinner
        text.innerText = 'Memuat...'; 
        spinner.classList.remove('hidden');

        return true; // Biarkan form lanjut kirim data ke server
    }
</script>
@endsection