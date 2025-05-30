<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'Diagnosa')</title> {{-- Judul halaman dinamis --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap"
        rel="stylesheet"
    />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        /* Custom styles for accordion animation (jika diperlukan di halaman lain yang extend ini) */
        .accordion-content {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.4s ease-in-out, padding 0.4s ease-in-out;
            padding-top: 0;
            padding-bottom: 0;
        }
        .accordion-content.active {
            max-height: 500px;
            padding-top: 1.5rem;
            padding-bottom: 1.5rem;
            transition: max-height 0.4s ease-in-out, padding 0.4s ease-in-out;
        }
    </style>
    @stack('styles') {{-- Untuk style tambahan dari child views --}}
</head>
<body class="bg-[#F5F9FF]"> {{-- Warna latar belakang umum --}}
    {{-- HEADER (Navbar) --}}
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
            <a href="#" class="hover:underline">Dashboard</a>
            <a href="#" class="hover:underline">Menu</a>
            <a href="{{ route('diagnosis.form') }}" class="hover:underline">Cek Diagnosa</a>
            <div class="relative cursor-pointer group">
                <button class="flex items-center space-x-1 hover:underline">
                    <span>Kontak</span>
                    <i class="text-xs fas fa-chevron-down"></i>
                </button>
            </div>
            <button
                type="button"
                class="bg-[#7A9CC6] text-white text-sm font-semibold px-4 py-2 rounded-md select-none"
                onclick="window.location.href='{{ route('login') }}'"
            >
                Login
            </button>
        </nav>
    </header>

    {{-- Main content area --}}
    <main class="max-w-[1200px] mx-auto px-6 mt-6 md:mt-12 flex-grow"> {{-- flex-grow agar main mengisi sisa ruang --}}
        @yield('content') {{-- Konten spesifik halaman akan disuntikkan di sini --}}
    </main>

    {{-- FOOTER PUBLIK (Opsional, bisa juga di partial terpisah jika banyak halaman) --}}
    <footer class="bg-gray-100 py-4 text-center text-gray-600 text-sm mt-auto"> {{-- mt-auto agar footer di bawah --}}
        <div class="container mx-auto">
            &copy; {{ date('Y') }} Website Diagnosa
        </div>
    </footer>

    @stack('scripts') {{-- Untuk script tambahan dari child views --}}

    {{-- Smooth Scroll Script (jika ini adalah fitur umum untuk semua halaman publik) --}}
    <script>
        document.querySelectorAll('a[href^="#"]').forEach(link => {
            link.addEventListener('click', e => {
                e.preventDefault();
                const target = document.querySelector(link.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth' });
                }
            });
        });

        // FAQ Accordion Script (jika ini adalah fitur umum untuk semua halaman publik)
        document.addEventListener('DOMContentLoaded', function() {
            const accordionHeaders = document.querySelectorAll('.accordion-header');

            accordionHeaders.forEach(header => {
                header.addEventListener('click', () => {
                    const content = header.nextElementSibling;
                    const icon = header.querySelector('i');

                    content.classList.toggle('active');
                    icon.classList.toggle('rotate-180');
                });
            });
        });
    </script>
</body>
</html>
