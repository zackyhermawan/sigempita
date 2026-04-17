<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gradient-to-br from-rose-100 via-white to-rose-50">

    <div class="min-h-screen flex items-center justify-center p-4">

        {{-- CARD --}}
        <div class="w-full lg:max-w-md bg-white/80 backdrop-blur-xl border border-rose-100 shadow-xl rounded-[2.5rem] p-8 md:p-10">

            {{-- HEADER --}}
            <div class="text-center mb-8">
                <div class="w-16 h-16 mx-auto bg-rose-100 text-rose-500 rounded-2xl flex items-center justify-center shadow-inner mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5.121 17.804A9 9 0 1118.364 4.56 9 9 0 015.12 17.804z" />
                    </svg>
                </div>

                <h2 class="text-2xl font-black text-slate-800 tracking-tight">
                    Selamat Datang
                </h2>
                <p class="text-sm text-slate-400 font-medium">
                    Silakan login untuk melanjutkan
                </p>
            </div>

            {{-- FORM --}}
            <form method="POST" action="/login" onsubmit="handleLogin(this)" class="space-y-5">
                @csrf

                {{-- USERNAME --}}
                <div class="relative">
                    <input type="text" name="username"
                        placeholder="Username"
                        value="{{ old('username') }}"
                        class="w-full pl-12 pr-4 py-3.5 bg-slate-50 border-none rounded-2xl text-sm font-bold text-slate-700 focus:ring-2 focus:ring-rose-200 shadow-inner">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-lg">👤</span>
                </div>

                {{-- PASSWORD --}}
                <div class="relative">
                    <input type="password" name="password"
                        placeholder="Password"
                        class="w-full pl-12 pr-4 py-3.5 bg-slate-50 border-none rounded-2xl text-sm font-bold text-slate-700 focus:ring-2 focus:ring-rose-200 shadow-inner">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-lg">🔒</span>
                </div>

                {{-- BUTTON --}}
                <button type="submit" id="loginBtn"
    class="w-full py-4 bg-rose-500 text-white font-black rounded-2xl shadow-lg transition-all flex items-center justify-center gap-3">
    
    <span id="btnText">Masuk Sekarang</span>

    <svg id="spinner" class="hidden animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
    </svg>
</button>
            </form>

            {{-- FOOTER --}}
            <p class="text-xs text-center mt-8 text-slate-400 font-medium">
                Belum punya akun?
                <a href="/register" class="text-rose-500 font-extrabold hover:underline ml-1">
                    Daftar
                </a>
            </p>
        </div>
    </div>
    <script>
    function handleLogin(form) {
        const btn = document.getElementById('loginBtn');
        const text = document.getElementById('btnText');
        const spinner = document.getElementById('spinner');

        // 1. Matikan tombol biar gak di-klik dua kali
        btn.disabled = true;
        
        // 2. Ubah tampilan tombol (agak transparan & kursor berubah)
        btn.classList.add('opacity-80', 'cursor-not-allowed');

        // 3. Ganti teks & munculkan spinner
        text.innerText = 'Menghubungkan...'; 
        spinner.classList.remove('hidden');

        return true; // Biarkan form lanjut kirim data ke server
    }
</script>
</body>
</html>