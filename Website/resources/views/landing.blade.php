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
        /* Custom styles for accordion animation */
        .accordion-content {
            max-height: 0; /* Awalnya tersembunyi */
            overflow: hidden;
            /* Transisi untuk max-height dan padding agar animasi lebih mulus */
            transition: max-height 0.4s ease-in-out, padding 0.4s ease-in-out;
            padding-top: 0; /* Pastikan padding atas 0 saat tersembunyi */
            padding-bottom: 0; /* Pastikan padding bawah 0 saat tersembunyi */
        }
        .accordion-content.active {
            max-height: 500px; /* Cukup tinggi untuk menampung konten */
            /* Mengaktifkan kembali padding saat aktif */
            padding-top: 1.5rem; /* px-6 sama dengan 1.5rem */
            padding-bottom: 1.5rem; /* pb-6 sama dengan 1.5rem */
            transition: max-height 0.4s ease-in-out, padding 0.4s ease-in-out;
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
            <a href="{{ route('diagnosa.cek') }}" class="hover:underline">Cek Diagnosa</a>
            <div class="relative group cursor-pointer">
                <button class="flex items-center space-x-1 hover:underline">
                    <span>Kontak</span>
                    <i class="fas fa-chevron-down text-xs"></i>
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
            class="flex flex-col md:flex-row items-center md:items-start justify-between gap-6"
        >
            <div class="max-w-xl md:max-w-lg">
                <h1
                    class="text-[#0A1A4F] font-extrabold text-3xl md:text-4xl leading-[44px] mb-4 select-none"
                >
                    Diagnosa Dini untuk<br />Kesehatan Mental Anda
                </h1>
                <p
                    class="text-[#0A1A4F] font-semibold text-xs leading-5 mb-6 select-none max-w-[400px]"
                >
                    Khawatir dengan kondisi kesehatan mental Anda? Alat bantu terpercaya
                    kami memudahkan Anda untuk mengenali gejala, memahami kondisi
                    emosional, dan mendapatkan dukungan kapan saja, di mana saja.
                </p>
                <div class="flex flex-wrap gap-4">
                    <a
                        href="{{ route('diagnosa.cek') }}"
                        class="bg-[#7A9CC6] text-white text-xs font-semibold px-4 py-2 rounded-md flex items-center space-x-2 select-none"
                    >
                        <span>Mulai Cek Kesehatan Mental</span>
                        <i class="fas fa-arrow-right"></i>
                    </a>
                    <button
                        type="button"
                        class="border border-[#0A1A4F] text-[#0A1A4F] text-xs font-semibold px-4 py-2 rounded-md select-none"
                    >
                        Unduh Aplikasi Diagnosa
                    </button>
                </div>
            </div>
            <div class="flex-shrink-0">
                <img
                    src="{{ asset('assets/ilustrasions.png') }}"
                    alt="Illustration"
                    width="400"
                    height="280"
                    class="w-full max-w-[400px] h-auto select-none"
                    draggable="false"
                />
            </div>
        </section>
    </main>

    {{-- Home Section (SISTEM PAKAR) --}}
    <section id="home" class="text-center py-8 px-4 bg-white">
        <h2 class="font-bold text-base md:text-lg max-w-md mx-auto text-[#0A1A4F]">
            SISTEM PAKAR
        </h2>
    </section>

    {{-- Dashboard Section (Kutipan) --}}
    <section id="dashboard" class="bg-black text-white px-6 py-12">
        <div class="max-w-4xl mx-auto">
            <p class="font-bold text-lg md:text-xl max-w-3xl mx-auto leading-snug text-center">
                “Kami membuat Aplikasi Diagnosa sebagai proyek akhir Tahun untuk membantu teman-teman kami yang mungkin mengalami depresi untuk mengetahui tingkat depresi mereka dan menemukan solusi yang sesuai”
            </p>
        </div>
    </section>

    {{-- FAQ Section --}}
    <main class="max-w-4xl mx-auto px-6 py-16">
        <h1 class="text-center text-[#000c3b] text-lg font-normal mb-10">
            Pertanyaan Yang Sering Diajukan - FAQ
        </h1>
        <section class="space-y-6">
            {{-- FAQ Item 1 --}}
            <div class="bg-[#f0f7fa] rounded-md shadow">
                <button class="accordion-header w-full text-left px-6 py-6 text-xs text-[#000c3b] font-semibold flex justify-between items-center cursor-pointer">
                    <span>Apa itu Diagnosa?</span>
                    <i class="fas fa-chevron-down transition-transform duration-300"></i>
                </button>
                <div class="accordion-content">
                    <p class="px-6 pb-6 text-xs text-[#000c3b] leading-relaxed">
                        Diagnosa adalah sebuah aplikasi sistem pakar yang dirancang untuk membantu pengguna dalam mengidentifikasi tingkat depresi berdasarkan gejala-gejala yang dialami. Aplikasi ini bertujuan untuk memberikan informasi awal dan rekomendasi solusi yang sesuai, serta menjadi langkah pertama dalam mencari dukungan kesehatan mental.
                    </p>
                </div>
            </div>

            {{-- FAQ Item 2 --}}
            <div class="bg-[#f0f7fa] rounded-md shadow">
                <button class="accordion-header w-full text-left px-6 py-6 text-xs text-[#000c3b] font-semibold flex justify-between items-center cursor-pointer">
                    <span>Siapa yang bisa mengakses Diagnosa?</span>
                    <i class="fas fa-chevron-down transition-transform duration-300"></i>
                </button>
                <div class="accordion-content">
                    <p class="px-6 pb-6 text-xs text-[#000c3b] leading-relaxed">
                        Diagnosa dapat diakses oleh siapa saja yang ingin memahami lebih lanjut tentang kondisi kesehatan mental mereka, khususnya terkait depresi. Aplikasi ini terbuka untuk umum dan dirancang agar mudah digunakan oleh berbagai kalangan.
                    </p>
                </div>
            </div>

            {{-- FAQ Item 3 --}}
            <div class="bg-[#f0f7fa] rounded-md shadow">
                <button class="accordion-header w-full text-left px-6 py-6 text-xs text-[#000c3b] font-semibold flex justify-between items-center cursor-pointer">
                    <span>Apakah hasil dari Diagnosa dapat diandalkan?</span>
                    <i class="fas fa-chevron-down transition-transform duration-300"></i>
                </button>
                <div class="accordion-content">
                    <p class="px-6 pb-6 text-xs text-[#000c3b] leading-relaxed">
                        Hasil dari Diagnosa didasarkan pada sistem pakar yang telah dirancang untuk memberikan estimasi awal. Namun, penting untuk diingat bahwa aplikasi ini bukan pengganti diagnosis medis profesional. Untuk diagnosis dan penanganan yang akurat, selalu konsultasikan dengan profesional kesehatan mental atau dokter.
                    </p>
                </div>
            </div>
        </section>
    </main>

    {{-- Seksi Unggulan Gangguan Mood --}}
    @if(isset($featuredDisorder))
    <section class="py-12 md:py-16 bg-slate-50">
        <div class="container mx-auto px-4 md:px-6">
            <div class="text-center mb-8 md:mb-12">
                <h2 class="text-2xl md:text-3xl font-semibold text-[#0A1A4F]">Pelajari Lebih Lanjut Tentang</h2>
                <p class="text-slate-600 mt-2">Informasi singkat mengenai salah satu kondisi yang kami tangani.</p>
            </div>

            <div class="max-w-4xl mx-auto">
                {{-- Bagian Header Informasi Gangguan --}}
                <div class="bg-gray-100 p-4 md:p-6 rounded-t-lg shadow-md">
                    <h3 class="text-lg md:text-xl font-semibold text-[#0A1A4F]">
                        {{ $featuredDisorder['kode'] ?? 'PXXX' }} | {{ $featuredDisorder['nama_gangguan'] ?? 'Nama Gangguan Tidak Tersedia' }}
                    </h3>
                    @if(isset($featuredDisorder['kesimpulan']) && !empty($featuredDisorder['kesimpulan']))
                    <p class="mt-1 text-xs md:text-sm text-gray-700 italic">
                        {{ $featuredDisorder['kesimpulan'] }}
                    </p>
                    @endif
                </div>

                {{-- Kartu Konten Utama (Gambar dan Deskripsi Detail) --}}
                <div class="bg-white shadow-md rounded-b-lg p-6 md:p-8">
                    <div class="text-gray-700">
                        <h4 class="text-xl md:text-2xl font-semibold text-[#0A1A4F] mb-4 text-center">
                            {{ $featuredDisorder['nama_gangguan'] ?? 'Detail Gangguan' }}
                        </h4>

                        {{-- Gambar Ilustrasi --}}
                        @if(isset($featuredDisorder['path_gambar']) && file_exists(public_path($featuredDisorder['path_gambar'])))
                            <img src="{{ asset($featuredDisorder['path_gambar']) }}" alt="Ilustrasi {{ $featuredDisorder['nama_gangguan'] ?? 'Gangguan' }}" class="w-full max-w-sm mx-auto h-auto rounded-lg shadow mb-6 border border-gray-200">
                        @else
                            <div class="text-center text-red-500 my-4 p-3 bg-red-100 rounded-md">
                                <i class="fas fa-image mr-2"></i>Gambar ilustrasi tidak ditemukan.
                            </div>
                        @endif

                        {{-- Deskripsi Gangguan --}}
                        <div class="prose max-w-none"> {{-- Kelas 'prose' dari Tailwind untuk styling teks dasar --}}
                            @if(isset($featuredDisorder['deskripsi_gangguan_intro']) && !empty($featuredDisorder['deskripsi_gangguan_intro']))
                            <p class="mb-3 text-base leading-relaxed">
                                {{ $featuredDisorder['deskripsi_gangguan_intro'] }}
                            </p>
                            @endif

                            @if(!empty($featuredDisorder['poin_utama_deskripsi']))
                                <ul class="list-disc pl-5 space-y-1">
                                    @foreach($featuredDisorder['poin_utama_deskripsi'] as $poin)
                                        <li class="text-base leading-relaxed">
                                            @if(is_string($poin) && str_contains($poin, ':'))
                                                <strong>{{ Illuminate\Support\Str::before($poin, ':') }}:</strong> {{ Illuminate\Support\Str::after($poin, ':') }}
                                            @else
                                                {{ $poin }}
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>

                        {{-- Tombol Baca Selengkapnya --}}
                        <div class="mt-6 text-center">
                            <a href="{{ $featuredDisorder['link_detail'] ?? '#' }}"
                               class="inline-block bg-[#7A9CC6] text-white text-sm font-semibold px-5 py-3 rounded-lg flex items-center justify-center gap-2 select-none hover:bg-opacity-80 transition duration-300">
                               <span>Baca Selengkapnya</span>
                               <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif

    {{-- Menu & Cek Diagnosa Section (Hidden) --}}
    <section id="menu" class="hidden">
        {{-- Konten untuk Menu --}}
    </section>
    <section id="cek-diagnosa" class="hidden">
        {{-- Konten untuk Cek Diagnosa --}}
    </section>

    {{-- Smooth Scroll Script --}}
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

        // FAQ Accordion Script
        document.addEventListener('DOMContentLoaded', function() {
            const accordionHeaders = document.querySelectorAll('.accordion-header');

            accordionHeaders.forEach(header => {
                header.addEventListener('click', () => {
                    const content = header.nextElementSibling; // Dapatkan elemen .accordion-content berikutnya
                    const icon = header.querySelector('i'); // Dapatkan ikon chevron

                    // Toggle class 'active' pada konten
                    content.classList.toggle('active');

                    // Toggle rotasi ikon
                    icon.classList.toggle('rotate-180');
                });
            });
        });
    </script>
</body>
</html>