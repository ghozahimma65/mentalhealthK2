<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin Panel - Aplikasi Diagnosa')</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>
<body class="flex flex-col min-h-screen font-sans antialiased bg-gray-100"> {{-- Tambahkan flex, flex-col, min-h-screen --}}
    {{-- Kontainer utama dengan flex untuk sidebar dan area konten --}}
    <div id="admin-app-layout" class="flex flex-1 overflow-hidden"> {{-- Gunakan flex-1 agar div ini memenuhi sisa ruang vertikal --}}

        <aside id="admin-layout-sidebar"
               class="fixed z-30 flex flex-col flex-shrink-0 w-64 h-full overflow-y-auto transition-transform duration-300 ease-in-out transform -translate-x-full bg-white border-r border-gray-200 md:translate-x-0 md:static">
            
            <div class="flex items-center justify-center flex-shrink-0 h-20 p-4 border-b border-gray-200">
                <div class="flex flex-col items-center justify-center w-auto h-auto text-xs font-semibold text-blue-600">
                    <img src="{{ asset('assets/logo.png') }}" width="35" height="29" class="mb-1" alt="Logo">
                    Admin Panel
                </div>
            </div>

            <nav class="flex flex-col flex-1 px-4 pb-4 mt-4 space-y-1 overflow-y-auto text-sm">
                <a href="{{ route('admin.dashboard') }}" class="block py-2.5 px-4 rounded transition duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-blue-500 text-white font-bold' : 'hover:bg-blue-50 text-gray-700 hover:text-blue-600 font-medium' }}">
                    <i class="mr-2 fas fa-tachometer-alt"></i> Dashboard
                </a>

                <span class="block px-4 mt-4 mb-1 text-xs font-semibold text-gray-400">MANAJEMEN PENGGUNA</span>
                {{-- PERBAIKAN: Menggunakan nama rute 'admin.detailpengguna' --}}
                <a href="{{ route('admin.detailpengguna') }}" class="block py-2.5 px-4 rounded transition duration-200 {{ request()->routeIs('admin.detailpengguna') || request()->routeIs('admin.detailpengguna.*') ? 'bg-blue-500 text-white font-bold' : 'hover:bg-blue-50 text-gray-700 hover:text-blue-600 font-medium' }}">
                    <i class="mr-2 fas fa-info-circle"></i> Detail Pengguna
                </a>
                <a href="{{ route('admin.dashboard') }}"
                    class="block py-2.5 px-4 rounded transition duration-200 hover:bg-blue-50 text-gray-700 hover:text-blue-600 font-medium">
                    <i class="mr-2 fas fa-chart-line"></i> Tren Hasil Klasifikasi
                </a>
                <span class="block px-4 mt-4 mb-1 text-xs font-semibold text-gray-400">Klasifikasi</span>
                {{-- PERBAIKAN: Menggunakan nama rute 'admin.diagnosis.pending' --}}
                <a href="{{ route('admin.diagnosis.pending') }}" class="block py-2.5 px-4 rounded transition duration-200 {{ request()->routeIs('admin.diagnosis.pending') ? 'bg-blue-500 text-white font-bold' : 'hover:bg-blue-50 text-gray-700 hover:text-blue-600 font-medium' }}">
                    <i class="mr-2 fas fa-hand-holding-heart"></i> Diagnosis
                </a>
                <a href="{{ route('admin.outcome.pending') }}"
                    class="block py-2.5 px-4 rounded transition duration-200 hover:bg-blue-50 text-gray-700 hover:text-blue-600 font-medium">
                    <i class="mr-2 fas fa-smile"></i> Outcome
                </a>
                <span class="block px-4 mt-4 mb-1 text-xs font-semibold text-gray-400">Riwayat</span>
                {{-- PERBAIKAN: Menggunakan nama rute 'admin.riwayatdiagnosis.index' --}}
                <a href="{{ route('admin.riwayatdiagnosis.index') }}" class="block py-2.5 px-4 rounded transition duration-200 {{ request()->routeIs('admin.riwayatdiagnosis.index') ? 'bg-blue-500 text-white font-bold' : 'hover:bg-blue-50 text-gray-700 hover:text-blue-600 font-medium' }}">
                    <i class="mr-2 fas fa-book-open"></i> Riwayat Diagnosis
                </a>
                <a href="{{ route('admin.riwayatoutcome.index') }}"
                    class="block py-2.5 px-4 rounded transition duration-200 hover:bg-blue-50 text-gray-700 hover:text-blue-600 font-medium">
                    <i class="mr-2 fas fa-scroll"></i> Riwayat Outcome
                </a>
                <span class="block px-4 mt-4 mb-1 text-xs font-semibold text-gray-400">DATA MASTER</span>
                <a href="{{ route('admin.meditations.index') }}" class="block py-2.5 px-4 rounded transition duration-200 {{ request()->routeIs('admin.meditations.*') ? 'bg-blue-500 text-white font-bold' : 'hover:bg-blue-50 text-gray-700 hover:text-blue-600 font-medium' }}">
                    <i class="mr-2 fas fa-leaf"></i> Meditasi
                </a> 
                <a href="{{ route('admin.quotes.index') }}" class="block py-2.5 px-4 rounded transition duration-200 {{ request()->routeIs('admin.quotes.*') ? 'bg-blue-500 text-white font-bold' : 'hover:bg-blue-50 text-gray-700 hover:text-blue-600 font-medium' }}">
                    <i class="mr-2 fas fa-quote-left"></i> Quotes & Affirmation
                </a>
                <span class="block px-4 mt-4 mb-1 text-xs font-semibold text-gray-400">PENGATURAN</span>
                <a href="#" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-blue-50 text-gray-700 hover:text-blue-600 font-medium">
                    <i class="mr-2 fas fa-user-plus"></i> Admin
                </a>       
                <form method="POST" action="{{ route('logout') }}" class="pt-4 mt-auto border-t border-gray-200">
                    @csrf
                    <a href="{{ route('logout') }}"
                       onclick="event.preventDefault(); this.closest('form').submit();"
                       class="block py-2.5 px-4 rounded transition duration-200 text-red-600 hover:bg-red-50 font-medium">
                        <i class="mr-2 fas fa-sign-out-alt"></i> Logout
                    </a>
                </form>
            </nav>
        </aside>

        <div class="flex flex-col flex-1 overflow-hidden">
            <header class="sticky top-0 z-20 flex items-center justify-between flex-shrink-0 h-20 px-4 py-4 bg-white border-b border-gray-200 shadow-sm sm:px-6">
                <div class="flex items-center">
                    <button id="admin-layout-sidebar-toggle" class="mr-3 text-gray-600 focus:outline-none md:hidden">
                        <i class="text-xl fas fa-bars"></i>
                    </button>
                    <h1 class="hidden text-xl font-semibold text-gray-700 md:block">@yield('header_title', 'Admin Panel')</h1>
                </div>

                <div class="flex justify-center flex-1 px-2 sm:px-6 lg:px-8">
                    @auth
                    <form class="relative hidden w-full max-w-md md:block" method="GET" action="#">
                        <input type="text" placeholder="Search..." class="w-full py-2 pl-10 pr-4 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" />
                        <span class="absolute text-gray-400 -translate-y-1/2 left-3 top-1/2"><i class="fas fa-search"></i></span>
                    </form>
                    @endauth
                </div>

                <div class="flex items-center space-x-2 sm:space-x-4">
                    @auth
                    <button class="relative text-xl text-gray-600 hover:text-blue-600 focus:outline-none"><i class="fas fa-bell"></i><span class="absolute flex items-center justify-center w-4 h-4 text-xs font-semibold text-white bg-red-500 rounded-full -top-1 -right-1">1</span></button>
                    <button class="text-xl text-gray-600 hover:text-blue-600 focus:outline-none"><i class="fas fa-comment-dots"></i></button>
                    <div class="flex items-center space-x-2">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'User') }}&background=0D8ABC&color=fff&size=32&rounded=true" alt="Profile" class="object-cover w-8 h-8 rounded-full">
                        <span class="hidden text-sm font-semibold text-gray-700 lowercase sm:inline">{{ Auth::user()->name ?? 'User' }}</span>
                    </div>
                    @else
                        <a href="{{ route('login') }}" class="px-3 py-2 text-sm font-semibold text-white bg-blue-500 rounded-md hover:bg-blue-600 sm:px-4 whitespace-nowrap">Login</a>
                    @endguest
                </div>
            </header>

            <main class="flex-1 p-6 overflow-y-auto">
                @yield('content')
            </main>
        </div>
    </div>

    @stack('scripts')
    <script>
        const adminSidebarToggleBtn = document.getElementById('admin-layout-sidebar-toggle');
        const adminLayoutSidebarEl = document.getElementById('admin-layout-sidebar');

        if (adminSidebarToggleBtn && adminLayoutSidebarEl) {
            adminSidebarToggleBtn.addEventListener('click', () => {
                adminLayoutSidebarEl.classList.toggle('-translate-x-full');
                adminLayoutSidebarEl.classList.toggle('translate-x-0');
            });
        }

        if (adminLayoutSidebarEl) {
            adminLayoutSidebarEl.querySelectorAll('nav a').forEach(link => {
                link.addEventListener('click', () => {
                    if (window.innerWidth < 768 && !adminLayoutSidebarEl.classList.contains('-translate-x-full')) {
                       adminLayoutSidebarEl.classList.add('-translate-x-full');
                       adminLayoutSidebarEl.classList.remove('translate-x-0');
                    }
                });
            });
        }
    </script>
</body>
</html>