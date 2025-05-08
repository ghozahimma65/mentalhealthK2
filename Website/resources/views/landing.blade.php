<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Diagnosa</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet" />
    {{-- Tambahkan Font Awesome jika belum ada di navbar atau app.blade.php Anda --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="bg-[#F5F9FF]">

    {{-- Navbar --}}
    {{-- Pastikan Anda memiliki file resources/views/components/navbar.blade.php --}}
    @include('components.navbar')

    {{-- Hero Section --}}
    <main class="w-full min-h-screen px-6 py-32 md:py-150 bg-white">
        <section class="flex flex-col md:flex-row items-center justify-between gap-12 w-full h-full">
            <div class="w-full md:w-1/2">
                <h1 class="text-[#0A1A4F] font-extrabold text-4xl md:text-5xl leading-tight mb-6 select-none">
                    Diagnosa Dini untuk<br />Kesehatan Mental Anda
                </h1>
                <p class="text-[#0A1A4F] font-medium text-base leading-relaxed mb-8 max-w-[500px] select-none">
                    Khawatir dengan kondisi kesehatan mental Anda? Alat bantu terpercaya kami memudahkan Anda untuk mengenali gejala, memahami kondisi emosional, dan mendapatkan dukungan kapan saja, di mana saja.
                </p>
                <div class="flex flex-wrap gap-4">
                    {{-- Tombol ini mungkin perlu link ke halaman diagnosa Anda --}}
                    <a href="#" class="bg-[#7A9CC6] text-white text-sm font-semibold px-5 py-3 rounded-lg flex items-center gap-2 select-none">
                        <span>Mulai Cek Kesehatan Mental</span>
                        <i class="fas fa-arrow-right"></i>
                    </a>
                    {{-- Tombol ini mungkin perlu link ke halaman unduh --}}
                    <a href="#" class="border border-[#0A1A4F] text-[#0A1A4F] text-sm font-semibold px-5 py-3 rounded-lg select-none">
                        Unduh Aplikasi Diagnosa
                    </a>
                </div>
            </div>
            <div class="w-full md:w-1/2 flex justify-center">
                {{-- Pastikan path ke aset gambar Anda benar --}}
                <img src="{{ asset('assets/ilustrasions.png') }}" alt="Ilustrasi Kesehatan Mental" class="max-w-[500px] w-full h-auto select-none" draggable="false" />
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

    {{-- Awal Seksi Unggulan Gangguan Mood --}}
    {{-- Seksi ini ditempatkan SETELAH Kutipan dan SEBELUM FAQ --}}
    @if(isset($featuredDisorder))
    <section class="py-12 md:py-16 bg-slate-50"> {{-- Anda bisa mengganti bg-slate-50 dengan bg-[#F5F9FF] jika ingin sama dengan body --}}
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
    {{-- Akhir Seksi Unggulan Gangguan Mood --}}

    {{-- FAQ Section --}}
    <section class="max-w-4xl mx-auto px-6 py-16" id="faq">
        <h2 class="text-center text-[#000c3b] text-lg font-normal mb-10">
            Pertanyaan Yang Sering Diajukan - FAQ
        </h2>
        <div class="space-y-6">
            <div class="bg-[#f0f7fa] px-6 py-6 text-xs text-[#000c3b] rounded-md shadow">
                Apa itu Diagnosa?
            </div>
            <div class="bg-[#f0f7fa] px-6 py-6 text-xs text-[#000c3b] rounded-md shadow">
                Siapa yang bisa mengakses Diagnosa
            </div>
            <div class="bg-[#f0f7fa] px-6 py-6 text-xs text-[#000c3b] rounded-md shadow">
                Apakah hasil dari Diagnosa dapat diandalkan?
            </div>
        </div>
    </section>

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
    </script>

</body>
</html>
