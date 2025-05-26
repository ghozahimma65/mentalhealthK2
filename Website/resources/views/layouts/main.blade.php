<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Judul akan disesuaikan oleh setiap halaman anak --}}
    <title>@yield('title', config('app.name', 'Laravel App'))</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>
<body class="font-sans antialiased bg-gray-100">
    {{-- Kontainer utama dengan flex untuk sidebar (jika ada) dan area konten --}}
    <div id="app-layout" class="flex h-screen overflow-hidden">

        {{-- =============================================== --}}
        {{-- ========== SIDEBAR (HANYA UNTUK ADMIN) ============== --}}
        {{-- =============================================== --}}
        @auth
            @if(Auth::user()->isAdmin()) {{-- Pastikan user adalah admin --}}
                <aside id="admin-layout-sidebar"
                       class="fixed z-30 flex flex-col flex-shrink-0 w-64 h-full overflow-y-auto transition-transform duration-300 ease-in-out transform -translate-x-full bg-white border-r border-gray-200 md:translate-x-0 md:static">
                    
                    {{-- Logo/Branding di Sidebar --}}
                    <div class="flex items-center justify-center flex-shrink-0 h-20 p-4 border-b border-gray-200">
                        <div class="flex flex-col items-center justify-center w-auto h-auto text-xs font-semibold text-blue-600">
                            <img src="{{ asset('assets/logo.png') }}" width="35" height="29" class="mb-1" alt="Logo">
                            Diagnosa Panel
                        </div>
                    </div>

                    {{-- Navigasi Sidebar Admin --}}
                    <nav class="flex flex-col flex-1 px-4 pb-4 mt-4 space-y-1 overflow-y-auto text-sm">
                        <a href="{{ route('admin.dashboard') }}" class="block py-2.5 px-4 rounded transition duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-blue-500 text-white font-bold' : 'hover:bg-blue-50 text-gray-700 hover:text-blue-600 font-medium' }}">
                            <i class="mr-2 fas fa-tachometer-alt"></i> Dashboard
                        </a>

                        <span class="block px-4 mt-4 mb-1 text-xs font-semibold text-gray-400">MANAJEMEN PENGGUNA</span>
                        <a href="{{ route('admin.tambah') }}" class="block py-2.5 px-4 rounded transition duration-200 {{ request()->routeIs('admin.tambah') ? 'bg-blue-500 text-white font-bold' : 'hover:bg-blue-50 text-gray-700 hover:text-blue-600 font-medium' }}">
                            <i class="mr-2 fas fa-info-circle"></i> Detail Pengguna
                        </a>
                        
                        {{-- ===== MENU PREDIKSI BARU ===== --}}
                        <span class="block px-4 mt-6 mb-1 text-xs font-semibold text-gray-400">PREDIKSI</span>
                        {{-- Perbaiki route name di sini agar sesuai dengan web.php --}}
                        <a href="{{ route('predictions.create') }}" class="block py-2.5 px-4 rounded transition duration-200 {{ request()->routeIs('predictions.create') ? 'bg-blue-500 text-white font-bold' : 'hover:bg-blue-50 text-gray-700 hover:text-blue-600 font-medium' }}">
                            <i class="mr-2 fas fa-robot"></i> Prediksi
                        </a>
                        <a href="{{ route('predictions.history') }}" class="block py-2.5 px-4 rounded transition duration-200 {{ request()->routeIs('predictions.history') ? 'bg-blue-500 text-white font-bold' : 'hover:bg-blue-50 text-gray-700 hover:text-blue-600 font-medium' }}">
                            <i class="mr-2 fas fa-history"></i> Riwayat Prediksi
                        </a>
                        <a href="{{ route('admin.outcome.form') }}" {{-- Menggunakan route admin.outcome.form --}}
                           class="block py-2.5 px-4 rounded transition duration-200 {{ request()->routeIs('admin.outcome.form') ? 'bg-blue-500 text-white font-bold' : 'hover:bg-blue-50 text-gray-700 hover:text-blue-600 font-medium' }}">
                            <i class="mr-2 fas fa-chart-line"></i> Tren Hasil Klasifikasi
                        </a>

                        <span class="block px-4 mt-4 mb-1 text-xs font-semibold text-gray-400">PENGATURAN</span>
                        <a href="{{ route('admin.tambah') }}" class="block py-2.5 px-4 rounded transition duration-200 {{ request()->routeIs('admin.tambah') ? 'bg-blue-500 text-white font-bold' : 'hover:bg-blue-50 text-gray-700 hover:text-blue-600 font-medium' }}">
                            <i class="mr-2 fas fa-user-plus"></i> Admin
                        </a>
                        
                        {{-- Tombol Logout di Sidebar Admin --}}
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
            @endif
        @endauth

        {{-- Kontainer untuk Top Bar dan Konten Utama (sebelah kanan Sidebar atau memenuhi lebar jika tidak ada sidebar) --}}
        {{-- Tambahkan class 'w-full' jika tidak ada sidebar, atau biarkan flex-1 --}}
        <div class="flex flex-col flex-1 overflow-hidden {{ Auth::check() && Auth::user()->isAdmin() ? '' : 'w-full' }}">
            {{-- ==================================================================== --}}
            {{-- ===== TOP BAR (UMUM UNTUK SEMUA PENGGUNA) ===== --}}
            {{-- ==================================================================== --}}
            <header class="sticky top-0 z-20 flex items-center justify-between flex-shrink-0 h-20 px-4 py-4 bg-white border-b border-gray-200 shadow-sm sm:px-6">
                {{-- Sisi Kiri Top Bar: Tombol Toggle Sidebar untuk Mobile & Judul Halaman --}}
                <div class="flex items-center">
                    {{-- Tampilkan tombol toggle hanya jika user adalah admin dan ada sidebar --}}
                    @auth
                        @if(Auth::user()->isAdmin())
                            <button id="admin-layout-sidebar-toggle" class="mr-3 text-gray-600 focus:outline-none md:hidden">
                                <i class="text-xl fas fa-bars"></i>
                            </button>
                        @endif
                    @endauth
                    {{-- Judul Halaman --}}
                    <h1 class="text-xl font-semibold text-gray-700 md:block">@yield('header_title', 'Aplikasi Diagnosa')</h1>
                </div>

                {{-- Sisi Tengah Top Bar: Navigasi Utama (untuk user biasa) atau Search (untuk Admin) --}}
                <div class="flex justify-center flex-1 px-2 sm:px-6 lg:px-8">
                    @auth
                        @if(Auth::user()->isAdmin())
                            {{-- Search Bar untuk Admin --}}
                            <form class="relative hidden w-full max-w-md md:block" method="GET" action="#">
                                <input type="text" placeholder="Search..." class="w-full py-2 pl-10 pr-4 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" />
                                <span class="absolute text-gray-400 -translate-y-1/2 left-3 top-1/2"><i class="fas fa-search"></i></span>
                            </form>
                        @else
                            {{-- Navigasi untuk Pengguna Biasa --}}
                            <nav class="items-center hidden space-x-4 md:flex">
                                <a href="{{ route('dashboard') }}" class="text-gray-700 hover:text-blue-600 font-medium {{ request()->routeIs('dashboard') ? 'text-blue-600 font-bold' : '' }}">Dashboard</a>
                                <a href="{{ route('predictions.create') }}" class="text-gray-700 hover:text-blue-600 font-medium {{ request()->routeIs('predictions.create') ? 'text-blue-600 font-bold' : '' }}">Prediksi Baru</a>
                                <a href="{{ route('predictions.history') }}" class="text-gray-700 hover:text-blue-600 font-medium {{ request()->routeIs('predictions.history') ? 'text-blue-600 font-bold' : '' }}">Riwayat</a>
                                <a href="{{ route('diagnosis.form') }}" class="text-gray-700 hover:text-blue-600 font-medium {{ request()->routeIs('diagnosis.form') ? 'text-blue-600 font-bold' : '' }}">Diagnosis</a>
                            </nav>
                        @endif
                    @endauth
                </div>

                {{-- Sisi Kanan Top Bar: Notifikasi, Profil, dll. --}}
                <div class="flex items-center space-x-2 sm:space-x-4">
                    @auth
                        <button class="relative text-xl text-gray-600 hover:text-blue-600 focus:outline-none"><i class="fas fa-bell"></i><span class="absolute flex items-center justify-center w-4 h-4 text-xs font-semibold text-white bg-red-500 rounded-full -top-1 -right-1">1</span></button>
                        <button class="text-xl text-gray-600 hover:text-blue-600 focus:outline-none"><i class="fas fa-comment-dots"></i></button>
                        <div class="flex items-center space-x-2">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'User') }}&background=0D8ABC&color=fff&size=32&rounded=true" alt="Profile" class="object-cover w-8 h-8 rounded-full">
                            <span class="hidden text-sm font-semibold text-gray-700 lowercase sm:inline">{{ Auth::user()->name ?? 'User' }}</span>
                        </div>
                        
                        {{-- Tombol Logout di Top Bar (jika tidak ada di sidebar atau sebagai alternatif) --}}
                        {{-- Ini akan selalu ditampilkan jika user login, baik admin maupun user biasa --}}
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <a href="{{ route('logout') }}"
                               onclick="event.preventDefault(); this.closest('form').submit();"
                               class="text-xl text-gray-600 hover:text-blue-600 focus:outline-none" title="Logout">
                                <i class="fas fa-sign-out-alt"></i>
                            </a>
                        </form>
                    @else
                        {{-- Tautan Login/Register jika belum login --}}
                        <a href="{{ route('login') }}" class="px-3 py-2 text-sm font-semibold text-white bg-blue-500 rounded-md hover:bg-blue-600 sm:px-4 whitespace-nowrap">Login</a>
                        <a href="{{ route('register') }}" class="px-3 py-2 text-sm font-semibold text-blue-500 border border-blue-500 rounded-md hover:bg-blue-50 sm:px-4 whitespace-nowrap">Register</a>
                    @endguest
                </div>
            </header>

            {{-- Konten Utama Halaman (diisi oleh @section('content') dari child view) --}}
            <main class="flex-1 p-6 overflow-y-auto">
                @yield('content')
            </main>
        </div>
    </div>

    @stack('scripts')
    <script>
        // Script untuk toggle sidebar, hanya akan berfungsi jika sidebar admin ditampilkan
        const adminSidebarToggleBtn = document.getElementById('admin-layout-sidebar-toggle');
        const adminLayoutSidebarEl = document.getElementById('admin-layout-sidebar');

        if (adminSidebarToggleBtn && adminLayoutSidebarEl) {
            adminSidebarToggleBtn.addEventListener('click', () => {
                adminLayoutSidebarEl.classList.toggle('-translate-x-full');
                adminLayoutSidebarEl.classList.toggle('translate-x-0');
            });
        }

        // Opsional: Tutup sidebar di mobile saat link navigasi di sidebar diklik
        if (adminLayoutSidebarEl) {
            adminLayoutSidebarEl.querySelectorAll('nav a').forEach(link => {
                link.addEventListener('click', () => {
                    if (window.innerWidth < 768 && !adminLayoutSidebarEl.classList.contains('-translate-x-full')) { // md breakpoint
                        adminLayoutSidebarEl.classList.add('-translate-x-full');
                        adminLayoutSidebarEl.classList.remove('translate-x-0');
                    }
                });
            });
        }
    </script>
</body>
</html>