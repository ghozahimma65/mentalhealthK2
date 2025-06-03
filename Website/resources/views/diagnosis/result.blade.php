@extends('layouts.main') {{-- Menggunakan layout utama aplikasi Anda --}}

@section('title', 'Hasil Diagnosis Kesehatan Mental') {{-- Mengatur judul halaman --}}

{{-- @push('styles') --}}
{{-- Anda bisa memindahkan CSS kustom dari sini ke file CSS utama Anda (app.css) atau menggunakan @stack('styles') jika perlu --}}
<style>
    /* Make images responsive */
    .diagnosis-image {
        max-width: 100%;
        height: auto;
        margin-top: 1.5rem;
        border-radius: 0.5rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    /* Tambahkan gaya untuk warna teks diagnosis jika diinginkan, misal: */
    /* .text-bipolar { color: #8a2be2; } /* Biru keunguan */
    /* .text-anxiety { color: #ff8c00; } /* Oranye gelap */
    /* .text-depressive { color: #1e90ff; } /* Biru terang */
    /* .text-panic { color: #dc143c; } /* Merah crimson */
</style>
{{-- @endpush --}}

@section('content') {{-- Konten utama halaman ini --}}
    <div class="flex items-center justify-center min-h-screen p-4">
        {{-- Kontainer utama hasil diagnosis diperbesar --}}
        <div class="w-full max-w-2xl p-10 text-center bg-white border border-gray-200 rounded-lg shadow-xl">
            <h1 class="mb-6 text-4xl font-extrabold text-gray-800">Hasil Diagnosis Anda</h1> {{-- Judul diperbesar --}}
            <p class="mb-8 text-xl text-gray-600">Berdasarkan data yang Anda berikan, diagnosis awal adalah:</p> {{-- Paragraf diperbesar --}}

            @if (isset($diagnosis))
                {{-- Kotak hasil diagnosis diperbesar padding dan margin-nya --}}
                <div class="px-8 py-6 mb-10 text-blue-800 border border-blue-200 rounded-lg bg-blue-50">
                    <p class="text-5xl font-extrabold 
                        @if ($diagnosis == 0) text-bipolar
                        @elseif ($diagnosis == 1) text-anxiety
                        @elseif ($diagnosis == 2) text-depressive
                        @elseif ($diagnosis == 3) text-panic
                        @else text-gray-800 @endif
                    ">
                        {{-- Menampilkan Nama Diagnosis --}}
                        @if ($diagnosis == 0)
                            Gangguan Bipolar
                        @elseif ($diagnosis == 1)
                            Gangguan Kecemasan Umum
                        @elseif ($diagnosis == 2)
                            Gangguan Depresi Mayor
                        @elseif ($diagnosis == 3)
                            Gangguan Panik
                        @else
                            Diagnosis Tidak Diketahui
                        @endif
                    </p>
                    <p class="mt-3 text-lg"> {{-- Ukuran teks diperbesar --}}
                        {{-- Keterangan Singkat dan Kode Diagnosis --}}
                        (@if ($diagnosis == 0)
                            **Bipolar Disorder**
                        @elseif ($diagnosis == 1)
                            **Generalized Anxiety**
                        @elseif ($diagnosis == 2)
                            **Major Depressive Disorder**
                        @elseif ($diagnosis == 3)
                            **Panic Disorder**
                        @else
                            Perlu pemeriksaan lebih lanjut
                        @endif
                        - Kode: {{ $diagnosis }}
                        )
                    </p>
                    
                    {{-- Gambar yang menggambarkan diagnosis --}}
                    {{-- Anda bisa menggunakan asset() helper untuk gambar lokal Anda --}}
                    @if ($diagnosis == 0)
                        <img src="https://placehold.co/400x250/A0B9D9/ffffff?text=Bipolar+Disorder" alt="Gambar Gangguan Bipolar" class="mx-auto diagnosis-image"> {{-- Ukuran gambar diperbesar --}}
                    @elseif ($diagnosis == 1)
                        <img src="https://placehold.co/400x250/D9A0B9/ffffff?text=Generalized+Anxiety" alt="Gambar Gangguan Kecemasan Umum" class="mx-auto diagnosis-image">
                    @elseif ($diagnosis == 2)
                        <img src="https://placehold.co/400x250/B9D9A0/ffffff?text=Major+Depressive+Disorder" alt="Gambar Gangguan Depresi Mayor" class="mx-auto diagnosis-image">
                    @elseif ($diagnosis == 3)
                        <img src="https://placehold.co/400x250/D9B9A0/ffffff?text=Panic+Disorder" alt="Gambar Gangguan Panik" class="mx-auto diagnosis-image">
                    @else
                        <img src="https://placehold.co/400x250/CCCCCC/ffffff?text=Diagnosis+Tidak+Diketahui" alt="Gambar Diagnosis Tidak Diketahui" class="mx-auto diagnosis-image">
                    @endif
                </div>
                <p class="leading-relaxed text-gray-700 text-md"> {{-- Ukuran teks diperbesar dan leading --}}
                    *Diagnosis ini adalah hasil klasifikasi awal dan tidak menggantikan konsultasi profesional.
                    Jika Anda merasa membutuhkan bantuan, silakan hubungi ahli kesehatan mental.
                </p>
            @else
                <div class="relative px-4 py-3 mb-4 text-red-700 bg-red-100 border border-red-400 rounded" role="alert">
                    <strong class="font-bold">Maaf!</strong>
                    <span class="block sm:inline">Tidak dapat menampilkan hasil diagnosis.</span>
                </div>
            @endif

            {{-- BAGIAN ADAPTIF: Opsi Setelah Diagnosis --}}
            <div class="flex flex-col mt-10 space-y-5"> {{-- Margin-top dan space-y diperbesar --}}
                @if (isset($user_is_guest) && $user_is_guest)
                    {{-- Opsi untuk Pengguna Belum Login --}}
                    <div class="p-5 text-yellow-700 bg-yellow-100 border-l-4 border-yellow-500 rounded"> {{-- Padding diperbesar --}}
                        <p class="text-lg">Ingin menyimpan riwayat diagnosis ini dan melacak perkembangan Anda? <a href="{{ route('register') }}" class="font-bold underline">Daftar sekarang</a> atau <a href="{{ route('login') }}" class="font-bold underline">Login</a>!</p> {{-- Teks diperbesar --}}
                    </div>
                    <a href="{{ route('diagnosis.form') }}"
                       class="inline-flex items-center justify-center px-8 py-4 text-lg font-medium text-white transition duration-200 ease-in-out bg-gray-600 border border-transparent rounded-md shadow-sm hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500"> {{-- Padding dan font diperbesar --}}
                        <i class="mr-3 fas fa-redo-alt"></i> Lakukan Diagnosa Lain
                    </a>
                @else
                    {{-- Opsi untuk Pengguna Sudah Login --}}
                    <a href="{{ route('diagnosis.form') }}"
                       class="inline-flex items-center justify-center px-8 py-4 text-lg font-medium text-white transition duration-200 ease-in-out bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"> {{-- Padding dan font diperbesar --}}
                        <i class="mr-3 fas fa-plus-circle"></i> Lakukan Diagnosa Baru
                    </a>
                    <a href="{{ route('predictions.history') }}"
                       class="inline-flex items-center justify-center px-8 py-4 text-lg font-medium text-blue-700 transition duration-200 ease-in-out bg-blue-100 border border-transparent rounded-md shadow-sm hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"> {{-- Padding dan font diperbesar --}}
                        <i class="mr-3 fas fa-history"></i> Lihat Riwayat Diagnosis Saya
                    </a>
                    <a href="{{ route('dashboard') }}"
                       class="inline-flex items-center justify-center px-8 py-4 text-lg font-medium text-gray-700 transition duration-200 ease-in-out bg-gray-200 border border-transparent rounded-md shadow-sm hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500"> {{-- Padding dan font diperbesar --}}
                        <i class="mr-3 fas fa-tachometer-alt"></i> Kembali ke Dashboard
                    </a>
                @endif
            </div>
            {{-- AKHIR BAGIAN ADAPTIF --}}

        </div>
    </div>
@endsection