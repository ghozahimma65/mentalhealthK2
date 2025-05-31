<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
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
        .dropdown-menu {
            display: none;
        }
        .dropdown-menu.active {
            display: block;
        }
        /* Style untuk tombol scroll-to-top */
        #scrollToTopBtn {
            display: none; /* Sembunyikan secara default */
            position: fixed; /* Posisi tetap di layar */
            bottom: 20px; /* Jarak dari bawah */
            right: 30px; /* Jarak dari kanan */
            z-index: 99; /* Pastikan di atas elemen lain */
            font-size: 18px; /* Ukuran ikon */
            border: none; /* Tanpa border */
            outline: none; /* Tanpa outline saat fokus */
            background-color: #7A9CC6; /* Warna latar belakang */
            color: white; /* Warna ikon */
            cursor: pointer; /* Indikator dapat diklik */
            padding: 15px; /* Padding */
            border-radius: 50%; /* Bentuk bulat */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Bayangan */
            transition: background-color 0.3s, transform 0.3s; /* Transisi halus */
        }

        #scrollToTopBtn:hover {
            background-color: #638cb6; /* Warna saat hover */
            transform: translateY(-2px); /* Efek sedikit terangkat */
        }
    </style>
    @stack('styles')
</head>
<body class="bg-[#F5F9FF] flex flex-col min-h-screen">
    <header
        class="sticky top-0 z-20 flex items-center justify-between w-full px-6 py-4 bg-white border-b border-gray-200 shadow-sm"
    >
        <div class="max-w-[1200px] mx-auto flex items-center justify-between w-full">
            <div class="flex items-center space-x-2">
                <div class="bg-[#7A9CC6] rounded-lg p-2">
                    <img
                        src="{{ asset('assets/logo.png') }}"
                        alt="Gambar logo Diagnosis"
                        width="32"
                        height="32"
                        class="block"
                    />
                </div>
                <span
                    class="text-[#2F4F7C] font-semibold text-xl leading-6 select-none drop-shadow-[1px_1px_1px_rgba(0,0,0,0.25)]"
                    >Diagnosis</span
                >
            </div>
            <nav
                class="hidden md:flex items-center space-x-8 text-[#0A1A4F] font-semibold text-sm leading-5 select-none"
            >
                <a href="{{ route('dashboard') }}" class="hover:underline">Beranda</a> 
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
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem" tabindex="-1" id="user-menu-item-0">Pengaturan Profil</a>
                                
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
        </div>
    </header>

    <main class="flex-grow">
        @yield('content')
    </main>
    
    @include('layouts.footer')
      
    @stack('scripts')

    {{-- Tombol Scroll to Top --}}
    <button onclick="topFunction()" id="scrollToTopBtn" title="Kembali ke atas">
        <i class="fas fa-arrow-up"></i>
    </button>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Script untuk dropdown user menu
            const userMenuButton = document.getElementById('user-menu-button');
            const userDropdownMenu = document.getElementById('user-dropdown-menu');

            if (userMenuButton && userDropdownMenu) {
                userMenuButton.addEventListener('click', function () {
                    userDropdownMenu.classList.toggle('active');
                });

                document.addEventListener('click', function (event) {
                    if (!userMenuButton.contains(event.target) && !userDropdownMenu.contains(event.target)) {
                        userDropdownMenu.classList.remove('active');
                    }
                });
            }

            // Script untuk tombol Scroll to Top
            const scrollToTopBtn = document.getElementById("scrollToTopBtn");

            // Tampilkan atau sembunyikan tombol berdasarkan posisi scroll
            window.onscroll = function() { scrollFunction() };

            function scrollFunction() {
                if (document.body.scrollTop > 300 || document.documentElement.scrollTop > 300) {
                    scrollToTopBtn.style.display = "block";
                } else {
                    scrollToTopBtn.style.display = "none";
                }
            }

            // Saat tombol diklik, gulir ke atas halaman
            function topFunction() {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth' // Untuk efek scroll yang halus
                });
            }
            // Assign function topFunction to global window scope for onclick
            window.topFunction = topFunction; 
        });
    </script>
</body>
</html>