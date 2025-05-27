@extends('layouts.main') {{-- Menggunakan layout utama Anda --}}

@section('title', 'Diagnosa Dini untuk Kesehatan Mental Anda') {{-- Judul halaman --}}

@push('styles')
<style>
    /* Styling for body (background-color, color, display, justify-content, align-items, min-height, margin)
       should ideally be handled by layouts.main's body or a wrapper div */
    /* Contoh: body { background-color: #EDF6F9; color: #2C3E70; } */

    /* Tailwind CSS sudah dimuat, jadi kelas-kelas seperti text-2xl, font-bold, mb-6, text-center, bg-white, shadow-md, rounded-lg, p-6, mx-auto, max-w-lg
       sudah bisa langsung digunakan. */

    /* Anda bisa menaruh CSS kustom lainnya di sini atau di app.css */
    .form-label {
        display: block;
        font-weight: bold;
        margin-bottom: 0.5rem;
        color: #2C3E70;
    }
    .form-input, .form-select {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid #CBD5E0;
        border-radius: 0.25rem;
        box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        margin-bottom: 1rem;
        color: #4A5568;
    }
    .form-select option {
        color: #4A5568;
    }
    .radio-group {
        display: flex;
        align-items: center;
        margin-bottom: 1rem;
    }
    .radio-group label {
        margin-right: 1.5rem;
        color: #4A5568;
    }
    .radio-group input[type="radio"] {
        margin-right: 0.5rem;
    }
    .submit-button {
        background-color: #80CBC4;
        color: white;
        font-weight: bold;
        padding: 0.75rem 1.5rem;
        border-radius: 0.25rem;
        cursor: pointer;
        transition: background-color 0.2s ease-in-out;
    }
    .submit-button:hover {
        background-color: #009688;
    }
    .back-button {
        background-color: #6B7280;
        color: white;
        font-weight: bold;
        padding: 0.75rem 1.5rem;
        border-radius: 0.25rem;
        cursor: pointer;
        transition: background-color 0.2s ease-in-out;
        text-decoration: none;
        display: inline-block;
    }
    .back-button:hover {
        background-color: #4B5563;
    }
    /* Mengubah .text-[#80CBC4] menjadi kelas Tailwind */
    .text-teal-400 { /* Contoh warna Teal-400 */
        color: #80CBC4;
    }
</style>
@endpush

@section('content') {{-- Memulai bagian konten utama halaman --}}
    <main class="max-w-[1200px] mx-auto px-6 mt-6 md:mt-12">
        <section
            class="flex flex-col items-center justify-between gap-8 md:flex-row md:items-center"
        >
            <div class="max-w-xl text-center md:max-w-lg md:text-left">
                <h1
                    class="text-[#0A1A4F] font-extrabold text-4xl md:text-5xl leading-tight mb-6 select-none"
                >
                    Diagnosis Dini untuk<br />Kesehatan Mental Anda
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
                    <button
                        type="button"
                        class="border border-[#0A1A4F] text-[#0A1A4F] text-lg font-semibold px-6 py-3 rounded-md select-none hover:bg-[#E0E7FF] transition duration-300"
                    >
                        Unduh Aplikasi Diagnosa
                    </button>
                </div> {{-- DIV INI SEBELUMNYA TIDAK TERTUTUP --}}
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
                    “Kami membuat Aplikasi Diagnosis sebagai Proyek Akhir Semester untuk membantu teman-teman kami yang mungkin mengalami depresi untuk mengetahui tingkat depresi mereka dan menemukan solusi yang sesuai”
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

    </main>
@endsection {{-- Mengakhiri bagian konten utama halaman --}}

@push('scripts')
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
@endpush