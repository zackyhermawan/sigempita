<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gradient-to-br from-rose-100 via-white to-rose-50 antialiased">

    {{-- KUNCI PERBAIKAN DI SINI:
         - items-center justify-center: agar card selalu tepat di tengah layar.
         - p-4 md:p-10: padding luar agar card tidak mepet pinggir layar di mobile. --}}
    <div class="min-h-screen flex items-center justify-center p-4 sm:p-6 md:p-10 transition-all">

        {{-- 
            PERBAIKAN TOTAL PADA CARD:
            1. w-full: Lebar penuh di mobile.
            2. md:max-w-[420px] !! KUNCI !! : Di tablet/laptop, lebar dipaksa MAKSIMAL 420px. Gak bakal melar lagi!
            3. min-h-[580px]: Di mobile dia akan tinggi dan lega.
            4. md:min-h-0: Di laptop tinggi akan menyesuaikan konten (tidak maksa tinggi).
            5. p-8 md:p-10: Padding dalam yang pas.
        --}}
        <div class="w-full lg:max-w-md min-h-[580px] md:min-h-0 bg-white/80 backdrop-blur-xl border border-rose-100 shadow-2xl rounded-[2.5rem] p-8 md:p-10 flex flex-col justify-center transition-all">

            {{-- HEADER --}}
            <div class="text-center mb-10 transition-all">
                <div class="w-16 h-16 mx-auto bg-rose-100 text-rose-500 rounded-2xl flex items-center justify-center shadow-inner mb-6 transition-transform hover:scale-105">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5.121 17.804A9 9 0 1118.364 4.56 9 9 0 015.12 17.804z" />
                    </svg>
                </div>

                <h2 class="text-3xl md:text-2xl font-black text-slate-800 tracking-tight transition-all">
                    Selamat Datang
                </h2>
                <p class="text-base md:text-sm text-slate-400 font-medium mt-2 transition-all">
                    Silakan login untuk melanjutkan
                </p>
            </div>
            
            {{-- Letakkan di bawah teks "Silakan login untuk melanjutkan" --}}
@error('login')
    <div class="bg-red-50 border-l-4 border-red-500 p-3 mb-4 rounded-lg">
        <p class="text-red-700 text-xs font-bold">{{ $message }}</p>
    </div>
@enderror

            {{-- FORM --}}
            <form method="POST" action="/login" onsubmit="handleLogin(this)" class="space-y-6 md:space-y-5">
                @csrf
            
                {{-- USERNAME --}}
                <div class="relative group">
                    <div class="relative">
                        <input type="text" name="username" value="{{ old('username') }}"
                            placeholder="Username"
                            class="w-full pl-12 pr-4 py-4 md:py-3.5 bg-slate-50 border @error('username') border-red-500 @else border-slate-100 @enderror rounded-2xl text-base md:text-sm font-bold text-slate-700 focus:ring-4 focus:ring-rose-200 shadow-inner outline-none transition-all focus:bg-white focus:border-rose-100">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-xl md:text-lg opacity-60 group-focus-within:opacity-100 transition-opacity">ðŸ‘¤</span>
                    </div>
                    {{-- Pesan Error Username --}}
                    @error('username')
                        <p class="text-red-500 text-xs mt-1.5 ml-2 font-bold animate-pulse">{{ $message }}</p>
                    @enderror
                </div>
            
                {{-- PASSWORD --}}
                <div class="relative group">
                    <div class="relative">
                        <input type="password" name="password"
                            placeholder="Password"
                            class="w-full pl-12 pr-4 py-4 md:py-3.5 bg-slate-50 border @error('password') border-red-500 @else border-slate-100 @enderror rounded-2xl text-base md:text-sm font-bold text-slate-700 focus:ring-4 focus:ring-rose-200 shadow-inner outline-none transition-all focus:bg-white focus:border-rose-100">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-xl md:text-lg opacity-60 group-focus-within:opacity-100 transition-opacity">ðŸ”’</span>
                    </div>
                    {{-- Pesan Error Password --}}
                    @error('password')
                        <p class="text-red-500 text-xs mt-1.5 ml-2 font-bold animate-pulse">{{ $message }}</p>
                    @enderror
                </div>
            
                {{-- BUTTON --}}
                <button type="submit" id="loginBtn"
                    class="w-full py-4 bg-rose-500 text-white font-black rounded-2xl shadow-xl shadow-rose-200 hover:bg-rose-600 hover:-translate-y-0.5 active:scale-[0.98] transition-all flex items-center justify-center gap-3">
                    
                    <span id="btnText" class="text-lg md:text-base transition-all">Masuk Sekarang</span>
            
                    <svg id="spinner" class="hidden animate-spin h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </button>
            </form>

            {{-- FOOTER --}}
            <div class="mt-10 md:mt-8 transition-all">
                <p class="text-sm md:text-xs text-center text-slate-400 font-medium uppercase tracking-widest transition-all">
                    Belum punya akun?
                    <a href="/register" class="text-rose-500 font-black hover:text-rose-600 ml-1 transition-colors hover:underline">
                        Daftar
                    </a>
                </p>
            </div>
        </div>
    </div>

    <script>
        function handleLogin(form) {
            const btn = document.getElementById('loginBtn');
            const text = document.getElementById('btnText');
            const spinner = document.getElementById('spinner');

            btn.disabled = true;
            btn.classList.add('opacity-80', 'cursor-not-allowed');

            text.innerText = 'Menghubungkan...'; 
            spinner.classList.remove('hidden');

            return true;
        }
    </script>
</body>
</html>