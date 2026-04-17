<!DOCTYPE html>
<html>
<head>
    <title>Register - Akun Baru</title>
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
                            d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                    </svg>
                </div>

                <h2 class="text-2xl font-black text-slate-800 tracking-tight">Daftar Akun</h2>
                <p class="text-sm text-slate-400 font-medium">Buat akun untuk mulai berkontribusi</p>
            </div>

            {{-- FORM --}}
            <form method="POST" action="/register" onsubmit="handleRegister(this)" class="space-y-4">
                @csrf

                {{-- INPUT NAMA --}}
                <div class="relative">
                    <input type="text" name="name" placeholder="Nama Lengkap" required
                        class="w-full pl-12 pr-4 py-3.5 bg-slate-50 border-none rounded-2xl text-sm font-bold text-slate-700 focus:ring-2 focus:ring-rose-200 shadow-inner">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-lg">📝</span>
                </div>

                {{-- INPUT USERNAME --}}
                <div class="relative">
                    <input type="text" name="username" placeholder="Username" required
                        class="w-full pl-12 pr-4 py-3.5 bg-slate-50 border-none rounded-2xl text-sm font-bold text-slate-700 focus:ring-2 focus:ring-rose-200 shadow-inner">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-lg">👤</span>
                </div>

                {{-- INPUT PASSWORD --}}
                <div class="relative">
                    <input type="password" name="password" placeholder="Password" required
                        class="w-full pl-12 pr-4 py-3.5 bg-slate-50 border-none rounded-2xl text-sm font-bold text-slate-700 focus:ring-2 focus:ring-rose-200 shadow-inner">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-lg">🔒</span>
                </div>

                {{-- BUTTON REGISTER --}}
                <button type="submit" id="regBtn"
                    class="w-full py-4 bg-rose-500 text-white font-black rounded-2xl shadow-lg shadow-rose-200 hover:bg-rose-600 active:scale-95 transition-all uppercase text-xs tracking-[0.2em] flex items-center justify-center gap-3">
                    
                    <span id="regText">Daftar Sekarang</span>

                    {{-- SPINNER --}}
                    <svg id="regSpinner" class="hidden animate-spin w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </button>
            </form>

            {{-- FOOTER --}}
            <p class="text-xs text-center mt-8 text-slate-400 font-medium">
                Sudah punya akun?
                <a href="/login" class="text-rose-500 font-extrabold hover:underline ml-1">Login di sini</a>
            </p>
        </div>
    </div>

    {{-- SCRIPT LOADING --}}
    <script>
        function handleRegister(form) {
            const btn = document.getElementById('regBtn');
            const text = document.getElementById('regText');
            const spinner = document.getElementById('regSpinner');

            // Disable button
            btn.disabled = true;
            btn.classList.add('opacity-70', 'cursor-not-allowed');

            // Change UI
            text.innerText = 'Mendaftarkan...';
            spinner.classList.remove('hidden');

            return true;
        }
    </script>
</body>
</html>