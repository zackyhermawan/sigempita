<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monitoring Balita - @yield('title')</title>
    
    <style>
        [x-cloak] { display: none !important; }
        
        h-screen {
            height: 100vh; 
            height: 100dvh; 
        }
        
        /* Opsional: Mempercantik scrollbar di area konten */
        .content-scrollbar::-webkit-scrollbar { width: 6px; }
        .content-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .content-scrollbar::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
    </style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-rose-50/30 text-slate-700 font-sans min-h-screen overflow-hidden" x-data="{ isOpen: false }">

<div class="flex h-full">
    <div x-cloak x-show="isOpen" 
        x-transition:enter="transition opacity ease-out duration-300"
        @click="isOpen = false" 
        class="fixed inset-0 z-40 bg-black/50 lg:hidden">
    </div>

    <aside x-cloak
        :class="isOpen ? 'translate-x-0' : '-translate-x-full'" 
        class="fixed inset-y-0 left-0 z-50 w-64 bg-white shadow-xl transition-transform duration-300 transform lg:translate-x-0 lg:static lg:inset-y-0 flex flex-col h-screen border-r border-rose-100 flex-shrink-0">
        
        <div class="p-6 text-center border-b border-rose-100 flex-shrink-0">
            <div class="inline-flex items-center justify-center w-12 h-12 mb-2 rounded-full bg-rose-100 text-rose-500">
                <x-heroicon-o-face-smile class="w-8 h-8" />
            </div>
            <h1 class="block font-bold text-rose-600 tracking-tight">E-Monitoring Balita</h1>
        </div>

        <nav class="p-4 space-y-1 flex-1 overflow-y-auto content-scrollbar">
            @php
                $navItems = auth()->user()->role === 'user' ? [
                    ['url' => '/dashboard', 'icon' => 'o-home', 'label' => 'Beranda'],
                    ['url' => '/children', 'icon' => 'o-user-group', 'label' => 'Data Anak'],
                    ['url' => '/food', 'icon' => 'o-cake', 'label' => 'Catatan Makan'],
                    ['url' => '/growth', 'icon' => 'o-chart-bar', 'label' => 'Pertumbuhan'],
                    ['url' => '/growth/history', 'icon' => 'o-clock', 'label' => 'Riwayat Validasi'],
                ] : [
                    ['url' => '/admin/dashboard', 'icon' => 'o-presentation-chart-line', 'label' => 'Admin Panel'],
                    ['url' => '/admin/children', 'icon' => 'o-users', 'label' => 'Semua Anak'],
                    ['url' => '/admin/reports/food', 'icon' => 'o-document-text', 'label' => 'Laporan Konsumsi'],
                    ['url' => '/admin/monitoring', 'icon' => 'o-computer-desktop', 'label' => 'Monitoring Validasi'],
                    ['url' => '/users/password', 'icon' => 'o-lock-closed', 'label' => 'Ubah Password'],
                ];
            @endphp

            @foreach($navItems as $item)
            <a href="{{ $item['url'] }}" 
               class="flex items-center px-4 py-3 text-sm font-medium transition-colors rounded-2xl group {{ Request::is(ltrim($item['url'], '/')) ? 'bg-rose-500 text-white shadow-lg shadow-rose-200' : 'text-slate-500 hover:bg-rose-50 hover:text-rose-500' }}">
                <x-dynamic-component :component="'heroicon-'.$item['icon']" class="w-6 h-6 mr-3" />
                {{ $item['label'] }}
            </a>
            @endforeach

            <div class="pt-6 mt-6 border-t border-rose-50">
                <form action="/logout" method="POST">
                    @csrf
                    <button class="flex items-center w-full px-4 py-3 text-sm font-medium text-red-400 transition-colors rounded-2xl hover:bg-red-50">
                        <x-heroicon-o-arrow-left-on-rectangle class="w-6 h-6 mr-3" />
                        Keluar Sistem
                    </button>
                </form>
            </div>
        </nav>
    </aside>

    <div class="flex-1 flex flex-col min-w-0 h-screen overflow-hidden">
        
        <header class="flex-shrink-0 flex items-center justify-between px-6 py-4 bg-white border-b border-rose-100 z-30">
            <div class="flex items-center gap-4">
                <button @click="isOpen = true" class="p-2 -ml-2 rounded-lg lg:hidden hover:bg-rose-50 text-rose-500">
                    <x-heroicon-o-bars-3-bottom-left class="w-6 h-6" />
                </button>
                <h2 class="text-xl font-bold text-slate-800">@yield('title')</h2>
            </div>

            <div class="flex items-center space-x-3">
                <div class="hidden sm:block text-right">
                    <p class="text-sm font-bold text-slate-700 leading-none">{{ Auth::user()->name }}</p>
                    <p class="text-[10px] uppercase text-rose-400 font-bold">Orang Tua</p>
                </div>
                <div class="w-10 h-10 rounded-full bg-rose-200 flex items-center justify-center text-rose-600 font-bold border-2 border-white shadow-sm">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
            </div>
        </header>

        <main class="flex-1 overflow-y-auto content-scrollbar bg-rose-50/30">
            <div class="p-4 md:p-8 pb-40 md:pb-16"> 
                <div class="w-full mx-auto">
                    @yield('content')
                    
                    <div class="h-20 lg:hidden"></div>
                </div>
            </div>
        </main>
    </div>
</div>

</body>
</html>