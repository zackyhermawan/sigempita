<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Akun Baru</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gradient-to-br from-rose-100 via-white to-rose-50 antialiased">

    <div class="min-h-screen flex items-center justify-center p-4 sm:p-6 md:p-10 transition-all">

        {{-- 
            CARD SETTINGS:
            - w-full: Lebar penuh di mobile.
            - md:max-w-[420px]: DI LAPTOP tetep kecil di tengah (maksimal 420px).
            - min-h-[620px]: Di mobile lebih tinggi dari login karena field lebih banyak.
            - md:min-h-0: Di laptop tinggi menyesuaikan konten.
        --}}
        <div class="w-full lg:max-w-md min-h-[620px] md:min-h-0 bg-white/80 backdrop-blur-xl border border-rose-100 shadow-2xl rounded-[2.5rem] p-8 md:p-10 flex flex-col justify-center transition-all">

            {{-- HEADER --}}
            <div class="text-center mb-8 md:mb-10 transition-all">
                <div class="w-16 h-16 mx-auto bg-rose-100 text-rose-500 rounded-2xl flex items-center justify-center shadow-inner mb-6 transition-transform hover:scale-105">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                    </svg>
                </div>

                <h2 class="text-3xl md:text-2xl font-black text-slate-800 tracking-tight transition-all">
                    Daftar Akun
                </h2>
                <p class="text-base md:text-sm text-slate-400 font-medium mt-2 transition-all">
                    Buat akun untuk mulai berkontribusi
                </p>
            </div>

            {{-- FORM --}}
            <form method="POST" action="/register" onsubmit="handleRegister(this)" class="space-y-5 md:space-y-4">
                @csrf

                {{-- INPUT NAMA --}}
                <div class="relative group">
                    <input type="text" name="name" placeholder="Nama Lengkap" required
                        class="w-full pl-12 pr-4 py-4 md:py-3.5 bg-slate-50 border border-slate-100 rounded-2xl text-base md:text-sm font-bold text-slate-700 focus:ring-4 focus:ring-rose-200 shadow-inner outline-none transition-all focus:bg-white">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-xl md:text-lg opacity-60 group-focus-within:opacity-100 transition-opacity">📝</span>
                </div>

                {{-- INPUT USERNAME --}}
                <div class="relative group">
                    <input type="text" name="username" placeholder="Username" required
                        class="w-full pl-12 pr-4 py-4 md:py-3.5 bg-slate-50 border border-slate-100 rounded-2xl text-base md:text-sm font-bold text-slate-700 focus:ring-4 focus:ring-rose-200 shadow-inner outline-none transition-all focus:bg-white">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-xl md:text-lg opacity-60 group-focus-within:opacity-100 transition-opacity">👤</span>
                </div>

                {{-- INPUT PASSWORD --}}
                <div class="relative group">
                    <input type="password" name="password" placeholder="Password" required
                        class="w-full pl-12 pr-4 py-4 md:py-3.5 bg-slate-50 border border-slate-100 rounded-2xl text-base md:text-sm font-bold text-slate-700 focus:ring-4 focus:ring-rose-200 shadow-inner outline-none transition-all focus:bg-white">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-xl md:text-lg opacity-60 group-focus-within:opacity-100 transition-opacity">🔒</span>
                </div>

                {{-- BUTTON REGISTER --}}
                <button type="submit" id="regBtn"
                    class="w-full py-3 md:py-4 bg-rose-500 text-white font-black rounded-2xl shadow-xl shadow-rose-200 hover:bg-rose-600 hover:-translate-y-0.5 active:scale-[0.98] transition-all flex items-center justify-center gap-3">
                    
                    <span id="regText" class="text-lg md:text-base">Daftar Sekarang</span>

                    <svg id="regSpinner" class="hidden animate-spin w-6 h-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </button>
            </form>

            {{-- FOOTER --}}
            <div class="mt-10 md:mt-8 transition-all">
                <p class="text-sm md:text-xs text-center text-slate-400 font-medium uppercase tracking-widest">
                    Sudah punya akun?
                    <a href="/" class="text-rose-500 font-black hover:text-rose-600 ml-1 transition-colors hover:underline underline-offset-4">
                        Login di sini
                    </a>
                </p>
            </div>
        </div>
    </div>

    {{-- SCRIPT LOADING --}}
    <script>
        function handleRegister(form) {
            const btn = document.getElementById('regBtn');
            const text = document.getElementById('regText');
            const spinner = document.getElementById('regSpinner');

            btn.disabled = true;
            btn.classList.add('opacity-70', 'cursor-not-allowed');

            text.innerText = 'Mendaftarkan...';
            spinner.classList.remove('hidden');

            return true;
        }
    </script>
</body>
</html>