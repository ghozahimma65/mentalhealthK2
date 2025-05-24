@extends('layouts.base') {{-- Meng-extend layout publik baru --}}

@section('title', 'Diagnosa Dini Kesehatan Mental') {{-- Mengatur judul halaman --}}

@section('content')
    {{-- Hero Section --}}
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
                    href="{{ route('diagnosis.form') }}"
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

    {{-- FAQ Section --}}
    <section class="max-w-4xl mx-auto px-6 py-16"> {{-- Hapus main tag di sini --}}
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
    </section>

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
                        <div class="prose max-w-none">
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
@endsection

{{-- Script untuk FAQ Accordion dan Smooth Scroll tidak perlu di sini lagi, karena sudah di public.blade.php --}}
