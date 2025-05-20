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
            <a href="{{ route('diagnosa.cek') }}" class="hover:underline">Cek Diagnosa</a>
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
                        href="{{ route('diagnosa.cek') }}"
                        class="bg-[#7A9CC6] text-white text-lg font-semibold px-6 py-3 rounded-md flex items-center space-x-3 select-none hover:bg-opacity-80 transition duration-300"
                    >
                        <span>Mulai Cek Kesehatan Mental</span>
                        <i class="fas fa-arrow-right"></i>
                    </a>
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

        {{-- Seksi Unggulan Gangguan Mood --}}
        @if(isset($featuredDisorder))
        <section class="py-16 mt-12 rounded-lg shadow-md bg-slate-50">
            <div class="container px-4 mx-auto md:px-6">
                <div class="mb-10 text-center md:mb-14">
                    <h2 class="text-3xl md:text-4xl font-semibold text-[#0A1A4F]">Pelajari Lebih Lanjut Tentang</h2>
                    <p class="mt-3 text-lg text-slate-600">Informasi singkat mengenai salah satu kondisi yang kami tangani.</p>
                </div>

                <div class="max-w-4xl mx-auto">
                    {{-- Bagian Header Informasi Gangguan --}}
                    <div class="p-5 bg-gray-100 rounded-t-lg shadow-inner md:p-7">
                        <h3 class="text-xl md:text-2xl font-semibold text-[#0A1A4F]">
                            {{ $featuredDisorder['kode'] ?? 'PXXX' }} | {{ $featuredDisorder['nama_gangguan'] ?? 'Nama Gangguan Tidak Tersedia' }}
                        </h3>
                        @if(isset($featuredDisorder['kesimpulan']) && !empty($featuredDisorder['kesimpulan']))
                        <p class="mt-1 text-sm italic text-gray-700 md:text-base">
                            {{ $featuredDisorder['kesimpulan'] }}
                        </p>
                        @endif
                    </div>

                    {{-- Kartu Konten Utama (Gambar dan Deskripsi Detail) --}}
                    <div class="p-8 bg-white rounded-b-lg shadow-md md:p-10">
                        <div class="text-gray-700">
                            <h4 class="text-2xl md:text-3xl font-semibold text-[#0A1A4F] mb-5 text-center">
                                {{ $featuredDisorder['nama_gangguan'] ?? 'Detail Gangguan' }}
                            </h4>

                            {{-- Gambar Ilustrasi --}}
                            @if(isset($featuredDisorder['path_gambar']) && file_exists(public_path($featuredDisorder['path_gambar'])))
                                <img src="{{ asset($featuredDisorder['path_gambar']) }}" alt="Ilustrasi {{ $featuredDisorder['nama_gangguan'] ?? 'Gangguan' }}" class="w-full h-auto max-w-md mx-auto mb-8 border border-gray-200 rounded-lg shadow-sm">
                            @else
                                <div class="p-4 my-6 text-center text-red-500 bg-red-100 rounded-md">
                                    <i class="mr-2 fas fa-image"></i>Gambar ilustrasi tidak ditemukan.
                                </div>
                            @endif

                            {{-- Deskripsi Gangguan --}}
                            <div class="text-lg prose max-w-none"> {{-- Kelas 'prose' dari Tailwind untuk styling teks dasar --}}
                                @if(isset($featuredDisorder['deskripsi_gangguan_intro']) && !empty($featuredDisorder['deskripsi_gangguan_intro']))
                                <p class="mb-4 leading-relaxed">
                                    {{ $featuredDisorder['deskripsi_gangguan_intro'] }}
                                </p>
                                @endif

                                @if(!empty($featuredDisorder['poin_utama_deskripsi']))
                                    <ul class="pl-6 space-y-2 list-disc">
                                        @foreach($featuredDisorder['poin_utama_deskripsi'] as $poin)
                                            <li class="leading-relaxed">
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
                            <div class="mt-8 text-center">
                                <a href="{{ $featuredDisorder['link_detail'] ?? '#' }}"
                                   class="inline-block bg-[#7A9CC6] text-white text-lg font-semibold px-6 py-3 rounded-lg flex items-center justify-center gap-3 select-none hover:bg-opacity-80 transition duration-300">
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

        {{-- FAQ Section --}}
        <section class="max-w-4xl px-6 py-16 mx-auto" id="faq">
            <h2 class="text-center text-[#000c3b] text-2xl font-semibold mb-10">
                Pertanyaan Yang Sering Diajukan - FAQ
            </h2>
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