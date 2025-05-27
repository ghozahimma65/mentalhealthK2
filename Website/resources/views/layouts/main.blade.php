<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Diagnosa')</title>

    <script src="https://cdn.tailwindcss.com"></script> 
    
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap"
        rel="stylesheet"
    />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    
    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        /* Style untuk dropdown (opsional, Tailwind mungkin sudah cukup) */
        .dropdown-menu {
            display: none;
        }
        .dropdown-menu.active {
            display: block;
        }
    </style>
    @stack('styles')
</head>
<body class="bg-[#F5F9FF]">
    <header
        class="flex items-center justify-between px-6 py-4 max-w-[1200px] mx-auto"
    >
        <div class="flex items-center space-x-2">
            <div class="bg-[#7A9CC6] rounded-lg p-2">
                <img
                    src="{{ asset('assets/logo.png') }}"
                    alt="Gambar logo Diagnosa"
                    width="32"
                    height="32"
                    class="block"
                />
            </div>
            <span
                class="text-[#2F4F7C] font-semibold text-xl leading-6 select-none drop-shadow-[1px_1px_1px_rgba(0,0,0,0.25)]"
                >Diagnosa</span
            >
        </div>
        <nav
            class="hidden md:flex items-center space-x-8 text-[#0A1A4F] font-semibold text-sm leading-5 select-none"
        >
            <a href="{{ url('dashboard') }}" class="hover:underline">Beranda</a> 
            <a href="{{ route('diagnosis.form') }}" class="hover:underline">Cek Diagnosis</a>
            
            <div class="relative cursor-pointer group">
                <button class="flex items-center space-x-1 hover:underline">
                    <span>Kontak</span>
                    <i class="text-xs fas fa-chevron-down"></i>
                </button>
            </div>

            @auth
                {{-- Dropdown Profil Pengguna --}}
                <div class="relative inline-block text-left">
                    <button type="button" id="user-menu-button" class="flex items-center space-x-2 focus:outline-none" aria-expanded="true" aria-haspopup="true">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'User') }}&background=0D8ABC&color=fff&size=32&rounded=true" alt="Profile" class="object-cover w-8 h-8 rounded-full">
                        <span class="hidden text-sm font-semibold text-gray-700 lowercase sm:inline">{{ Auth::user()->name ?? 'User' }}</span>
                        <i class="text-xs text-gray-500 fas fa-chevron-down"></i>
                    </button>

                    {{-- Dropdown menu --}}
                    <div id="user-dropdown-menu" class="absolute right-0 z-50 w-48 mt-2 origin-top-right bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none dropdown-menu" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
                        <div class="py-1" role="none">
                            {{-- Item-item dropdown lainnya bisa ditambahkan di sini, contoh: --}}
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem" tabindex="-1" id="user-menu-item-0">Pengaturan Profil</a>
                            {{-- <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem" tabindex="-1" id="user-menu-item-1">Item Lain</a> --}}
                            
                            <form method="POST" action="{{ route('logout') }}" role="none">
                                @csrf
                                <button type="submit" class="block w-full px-4 py-2 text-sm text-left text-red-600 hover:bg-red-50" role="menuitem" tabindex="-1" id="user-menu-item-2">
                                    <i class="mr-2 fas fa-sign-out-alt"></i> Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @else
                <a href="{{ route('login') }}" class="px-3 py-2 text-sm font-semibold text-white bg-[#7A9CC6] rounded-md hover:bg-[#638cb6] sm:px-4 whitespace-nowrap">Login</a>
               <a href="{{ route('register') }}" class="px-3 py-2 text-sm font-semibold text-[#7A9CC6] border border-[#7A9CC6] rounded-md hover:bg-[#E0E7FF] sm:px-4 whitespace-nowrap">Register</a>
            @endguest
        </nav>
    </header>

    <main>
        @yield('content')
    </main>
     @include('layouts.footer')
     
    @stack('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const userMenuButton = document.getElementById('user-menu-button');
            const userDropdownMenu = document.getElementById('user-dropdown-menu');

            if (userMenuButton && userDropdownMenu) {
                userMenuButton.addEventListener('click', function () {
                    userDropdownMenu.classList.toggle('active');
                });

                // Tutup dropdown jika klik di luar area dropdown
                document.addEventListener('click', function (event) {
                    if (!userMenuButton.contains(event.target) && !userDropdownMenu.contains(event.target)) {
                        userDropdownMenu.classList.remove('active');
                    }
                });
            }
        });
    </script>
</body>
</html>