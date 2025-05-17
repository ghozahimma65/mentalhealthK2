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
<body class="font-sans antialiased bg-gray-100">
    {{-- Kontainer utama dengan flex untuk sidebar dan area konten --}}
    <div id="admin-app-layout" class="flex h-screen overflow-hidden">

        {{-- =============================================== --}}
        {{-- ========== SIDEBAR ADMIN (BAGIAN TETAP DARI LAYOUT INI) ============== --}}
        {{-- =============================================== --}}
        <aside id="admin-layout-sidebar"
               class="bg-white w-64 flex-shrink-0 flex flex-col border-r border-gray-200
                      transform -translate-x-full md:translate-x-0
                      transition-transform duration-300 ease-in-out
                      fixed md:static h-full z-30 overflow-y-auto">
            
            {{-- Logo/Branding di Sidebar --}}
            <div class="flex items-center justify-center border-b border-gray-200 p-4 h-20 flex-shrink-0">
                <div class="w-auto h-auto flex flex-col items-center justify-center text-blue-600 text-xs font-semibold">
                    <img src="{{ asset('assets/logo.png') }}" width="35" height="29" class="mb-1" alt="Logo">
                    Diagnosa Panel
                </div>
            </div>

            {{-- Navigasi Sidebar --}}
            <nav class="flex-1 flex flex-col mt-4 px-4 space-y-1 text-sm overflow-y-auto pb-4">
                <a href="{{ route('admin.dashboard') }}" class="block py-2.5 px-4 rounded transition duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-blue-500 text-white font-bold' : 'hover:bg-blue-50 text-gray-700 hover:text-blue-600 font-medium' }}">
                    <i class="fas fa-tachometer-alt mr-2"></i> Dashboard
                </a>

                <span class="block px-4 mt-4 mb-1 text-xs font-semibold text-gray-400">MANAJEMEN PENGGUNA</span>
                <a href="{{ route('admin.tambah') }}" class="block py-2.5 px-4 rounded transition duration-200 {{ request()->routeIs('admin.tambah') ? 'bg-blue-500 text-white font-bold' : 'hover:bg-blue-50 text-gray-700 hover:text-blue-600 font-medium' }}">
                    <i class="mr-2 fas fa-info-circle"></i> Detail Pengguna
                </a>
                
                <span class="block px-4 mt-4 mb-1 text-xs font-semibold text-gray-400">MANAJEMEN KUESIONER</span>
                <a href="#" {{-- Ganti # dengan route('admin.diagnosa.index') jika sudah ada --}}
                    class="block py-2.5 px-4 rounded transition duration-200 hover:bg-blue-50 text-gray-700 hover:text-blue-600 font-medium">
                    <i class="mr-2 fas fa-list-ul"></i> Daftar Kuesioner
                </a>
                <a href="#" {{-- Ganti # dengan route('admin.diagnosa.index') jika sudah ada --}}
                    class="block py-2.5 px-4 rounded transition duration-200 hover:bg-blue-50 text-gray-700 hover:text-blue-600 font-medium">
                    <i class="mr-2 fas fa-cog"></i> Kelola Kuesioner
                </a>
                <a href="#" {{-- Ganti # dengan route('admin.gejala.index') jika sudah ada --}}
                   class="block py-2.5 px-4 rounded transition duration-200 hover:bg-blue-50 text-gray-700 hover:text-blue-600 font-medium">
                    <i class="fas fa-notes-medical mr-2"></i> Gejala
                </a>
                <a href="#" {{-- Ganti # dengan route('admin.depresi.index') jika sudah ada --}}
                   class="block py-2.5 px-4 rounded transition duration-200 hover:bg-blue-50 text-gray-700 hover:text-blue-600 font-medium">
                    <i class="fas fa-brain mr-2"></i> Depresi
                </a>
                <a href="#" {{-- Ganti # dengan route('admin.hasil.index') jika sudah ada --}}
                   class="block py-2.5 px-4 rounded transition duration-200 hover:bg-blue-50 text-gray-700 hover:text-blue-600 font-medium">
                    <i class="fas fa-poll mr-2"></i> Hasil Diagnosa
                </a>

                <span class="text-gray-400 font-semibold text-xs mt-4 mb-1 block px-4">PENGATURAN</span>
                <a href="{{ route('admin.tambah') }}" class="block py-2.5 px-4 rounded transition duration-200 {{ request()->routeIs('admin.tambah') ? 'bg-blue-500 text-white font-bold' : 'hover:bg-blue-50 text-gray-700 hover:text-blue-600 font-medium' }}">
                    <i class="fas fa-user-plus mr-2"></i> Admin
                </a>

                <span class="block px-4 mt-4 mb-1 text-xs font-semibold text-gray-400">ANALISIS DATA</span>
               <a href="#" {{-- Ganti # dengan route('admin.hasil.index') jika sudah ada --}}
                    class="block py-2.5 px-4 rounded transition duration-200 hover:bg-blue-50 text-gray-700 hover:text-blue-600 font-medium">
                    <i class="mr-2 fas fa-map-marked-alt"></i> Persebaran Hasil
                </a>
                <a href="#" {{-- Ganti # dengan route('admin.hasil.index') jika sudah ada --}}
                    class="block py-2.5 px-4 rounded transition duration-200 hover:bg-blue-50 text-gray-700 hover:text-blue-600 font-medium">
                    <i class="mr-2 fas fa-chart-line"></i> Tren Hasil Klasifikasi
                </a>
                                
                {{-- Tombol Logout bisa juga ada di sini sebagai alternatif atau tambahan dari top bar --}}
                 <form method="POST" action="{{ route('logout') }}" class="mt-auto pt-4 border-t border-gray-200">
                    @csrf
                    <a href="{{ route('logout') }}"
                       onclick="event.preventDefault(); this.closest('form').submit();"
                       class="block py-2.5 px-4 rounded transition duration-200 text-red-600 hover:bg-red-50 font-medium">
                       <i class="fas fa-sign-out-alt mr-2"></i> Logout
                    </a>
                </form>
            </nav>
        </aside>

        {{-- Kontainer untuk Top Bar dan Konten Utama (sebelah kanan Sidebar) --}}
        <div class="flex-1 flex flex-col overflow-hidden">
            {{-- ==================================================================== --}}
            {{-- ===== TOP BAR ADMIN (BAGIAN TETAP DARI LAYOUT INI) ===== --}}
            {{-- ==================================================================== --}}
            <header class="flex items-center justify-between border-b border-gray-200 bg-white px-4 sm:px-6 py-4 h-20 shadow-sm sticky top-0 z-20 flex-shrink-0">
                {{-- Sisi Kiri Top Bar: Tombol Toggle Sidebar untuk Mobile & Judul Halaman --}}
                <div class="flex items-center">
                    <button id="admin-layout-sidebar-toggle" class="text-gray-600 focus:outline-none md:hidden mr-3">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                    <h1 class="text-xl font-semibold text-gray-700 hidden md:block">@yield('header_title', 'Admin Panel')</h1>
                </div>

                {{-- Sisi Tengah Top Bar: Search (Opsional) --}}
                <div class="flex-1 flex justify-center px-2 sm:px-6 lg:px-8">
                    @auth
                    <form class="relative w-full max-w-md hidden md:block" method="GET" action="#">
                        <input type="text" placeholder="Search..." class="pl-10 pr-4 py-2 w-full rounded-lg text-sm font-medium text-gray-700 bg-gray-100 border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" />
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"><i class="fas fa-search"></i></span>
                    </form>
                    @endauth
                </div>

                {{-- Sisi Kanan Top Bar: Notifikasi, Profil, dll. --}}
                <div class="flex items-center space-x-2 sm:space-x-4">
                    @auth
                    <button class="relative text-gray-600 hover:text-blue-600 focus:outline-none text-xl"><i class="fas fa-bell"></i><span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-4 h-4 flex items-center justify-center font-semibold">1</span></button>
                    <button class="text-gray-600 hover:text-blue-600 focus:outline-none text-xl"><i class="fas fa-comment-dots"></i></button>
                    <div class="flex items-center space-x-2">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'User') }}&background=0D8ABC&color=fff&size=32&rounded=true" alt="Profile" class="w-8 h-8 rounded-full object-cover">
                        <span class="hidden sm:inline text-sm font-semibold text-gray-700 lowercase">{{ Auth::user()->name ?? 'User' }}</span>
                    </div>
                    {{-- Tombol logout di Top Bar bisa dihilangkan jika sudah ada di sidebar --}}
                    {{-- <form method="POST" action="{{ route('logout') }}" class="inline"> @csrf <button type="submit" class="text-gray-600 hover:text-blue-600 focus:outline-none text-xl" title="Logout"><i class="fas fa-sign-out-alt"></i></button></form> --}}
                    @else
                        <a href="{{ route('login') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold px-3 py-2 sm:px-4 rounded-md text-sm whitespace-nowrap">Login</a>
                    @endguest
                </div>
            </header>

            {{-- Konten Utama Halaman Admin (akan diisi oleh @section('content') dari child view) --}}
            <main class="flex-1 overflow-y-auto p-6">
                @yield('content')
            </main>
        </div>
    </div>

    @stack('scripts')
    <script>
        // Script untuk toggle sidebar, sekarang menjadi bagian dari layouts.main
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