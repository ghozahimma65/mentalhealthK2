<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Diagnosa</title>
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
    </style>
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
            <a href="#" class="hover:underline">Dashboard</a>
            <a href="#" class="hover:underline">Menu</a>
            <a href="{{ route('diagnosis.form') }}" class="hover:underline">Cek Diagnosa</a>
            <div class="relative cursor-pointer group">
                <button class="flex items-center space-x-1 hover:underline">
                    <span>Kontak</span>
                    <i class="text-xs fas fa-chevron-down"></i>
                </button>
                {{-- Anda bisa menambahkan dropdown kontak di sini --}}
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
    <main class="max-w-[1200px] mx-auto px-6 mt-6 md:mt-12">
        <section
            class="flex flex-col items-center justify-between gap-8 md:flex-row md:items-center"
        >
            <div class="max-w-xl text-center md:max-w-lg md:text-left">
                <h1
                    class="text-[#0A1A4F] font-extrabold text-4xl md:text-5xl leading-tight mb-6 select-none"
                >
                    Diagnosa Dini untuk<br />Kesehatan Mental Anda
                </h1>
                <p
                    class="text-[#0A1A4F] font-semibold text-lg leading-relaxed mb-8 select-none max-w-[450px] mx-auto md:mx-0"
                >
                    Khawatir dengan kondisi kesehatan mental Anda? Alat bantu terpercaya
                    kami memudahkan Anda untuk mengenali gejala, memahami kondisi
                    emosional, dan mendapatkan dukungan kapan saja, di mana saja.
                </p>
              <div class="flex flex-wrap justify-center gap-4 md:justify-start">
    <a
        href="{{ route('diagnosis.form') }}" {{-- DISESUAIKAN: Mengarahkan ke route form diagnosis --}}
        class="bg-[#7A9CC6] text-white text-lg font-semibold px-6 py-3 rounded-md flex items-center space-x-3 select-none hover:bg-opacity-80 transition duration-300"
    >
        <span>Mulai Cek Kesehatan Mental</span>
        <i class="fas fa-arrow-right"></i>
    </a>
</div>

                    <button
                        type="button"
                        class="border border-[#0A1A4F] text-[#0A1A4F] text-lg font-semibold px-6 py-3 rounded-md select-none hover:bg-[#E0E7FF] transition duration-300"
                    >
                        Unduh Aplikasi Diagnosa
                    </button>
                </div>
            </div>
            <div class="flex-shrink-0 w-full max-w-md md:max-w-lg">
                <img
                    src="{{ asset('assets/ilustrasions.png') }}"
                    alt="Illustration"
                    class="w-full h-auto rounded-lg shadow-xl select-none"
                    draggable="false"
                />
            </div>
        </section>

        {{-- Dashboard Section (Kutipan) --}}
        <section id="dashboard" class="py-12 mt-12 text-white bg-black rounded-lg shadow-md">
            <div class="max-w-4xl px-6 mx-auto text-center">
                <p class="text-xl font-bold leading-relaxed md:text-2xl">
                    “Kami membuat Aplikasi Diagnosa sebagai proyek akhir Tahun untuk membantu teman-teman kami yang mungkin mengalami depresi untuk mengetahui tingkat depresi mereka dan menemukan solusi yang sesuai”
                </p>
            </div>
        </section>

        <section class="max-w-4xl px-6 py-16 mx-auto">
            <h1 class="text-center text-[#000c3b] text-2xl font-semibold mb-10">
                Pertanyaan Yang Sering Diajukan - FAQ
            </h1>
            <div class="space-y-6">
                <div class="bg-[#f0f7fa] px-6 py-6 text-base text-[#000c3b] rounded-md shadow">
                    Apa itu Diagnosa?
                </div>
                <div class="bg-[#f0f7fa] px-6 py-6 text-base text-[#000c3b] rounded-md shadow">
                    Siapa yang bisa mengakses Diagnosa?
                </div>
                <div class="bg-[#f0f7fa] px-6 py-6 text-base text-[#000c3b] rounded-md shadow">
                    Apakah hasil dari Diagnosa dapat diandalkan?
                </div>
            </div>
        </section>

    </main>

    <script>

        // Pastikan tidak ada ID stickyMenu ganda jika file ini digabung atau di-include
        // Jika ada, pastikan script ini hanya dieksekusi sekali atau gunakan ID yang unik
        const stickyMenu = document.getElementById('stickyMenu'); // Jika ada elemen dengan ID ini
        if (stickyMenu) {
            const header = document.querySelector('header');
            if (header) {
                const headerHeight = header.offsetHeight;
                window.addEventListener('scroll', () => {
                    if (window.scrollY > headerHeight) {
                        stickyMenu.classList.remove('hidden');
                    } else {
                        stickyMenu.classList.add('hidden');
                    }
                });
            }
        }
    </script>
    </script>

</body>
</html>