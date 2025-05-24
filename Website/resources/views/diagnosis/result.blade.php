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
</style>
{{-- @endpush --}}

@section('content') {{-- Konten utama halaman ini --}}
    <div class="flex items-center justify-center min-h-screen p-4"> {{-- Tambahkan kelas ini agar kontainer berada di tengah --}}
        <div class="w-full max-w-md p-8 text-center bg-white border border-gray-200 rounded-lg shadow-xl">
            <h1 class="mb-4 text-3xl font-bold text-gray-800">Hasil Diagnosis Anda</h1>
            <p class="mb-6 text-gray-600">Berdasarkan data yang Anda berikan, diagnosis awal adalah:</p>

            @if (isset($diagnosis))
                <div class="px-6 py-4 mb-8 text-blue-800 border border-blue-200 rounded-lg bg-blue-50">
                    <p class="text-4xl font-extrabold">{{ $diagnosis }}</p>
                    <p class="mt-2 text-sm">
                        @if ($diagnosis == 0)
                            (Gangguan Bipolar)
                        @elseif ($diagnosis == 1)
                            (Gangguan Kecemasan Umum)
                        @elseif ($diagnosis == 2)
                            (Gangguan Depresi Mayor)
                        @elseif ($diagnosis == 3)
                            (Gangguan Panik)
                        @else
                            (Diagnosis tidak diketahui atau perlu pemeriksaan lebih lanjut)
                        @endif
                    </p>
                    {{-- Gambar yang menggambarkan diagnosis --}}
                    @if ($diagnosis == 0)
                        <img src="https://placehold.co/300x200/A0B9D9/ffffff?text=Bipolar+Disorder" alt="Gambar Gangguan Bipolar" class="mx-auto diagnosis-image">
                    @elseif ($diagnosis == 1)
                        <img src="https://placehold.co/300x200/D9A0B9/ffffff?text=Generalized+Anxiety" alt="Gambar Gangguan Kecemasan Umum" class="mx-auto diagnosis-image">
                    @elseif ($diagnosis == 2)
                        <img src="https://placehold.co/300x200/B9D9A0/ffffff?text=Major+Depressive+Disorder" alt="Gambar Gangguan Depresi Mayor" class="mx-auto diagnosis-image">
                        {{-- Menggunakan asset() helper jika gambar lokal, bukan placehold.co --}}
                        {{-- <img src="{{ asset('path/to/your/bipolar_image.png') }}" alt="Gambar Gangguan Bipolar" class="mx-auto diagnosis-image"> --}}
                    @elseif ($diagnosis == 3)
                        <img src="https://placehold.co/300x200/D9B9A0/ffffff?text=Panic+Disorder" alt="Gambar Gangguan Panik" class="mx-auto diagnosis-image">
                    @else
                        <img src="https://placehold.co/300x200/CCCCCC/ffffff?text=Diagnosis+Tidak+Diketahui" alt="Gambar Diagnosis Tidak Diketahui" class="mx-auto diagnosis-image">
                    @endif
                </div>
                <p class="text-sm text-gray-700">
                    *Diagnosis ini adalah hasil prediksi awal dan tidak menggantikan konsultasi profesional.
                    Jika Anda merasa membutuhkan bantuan, silakan hubungi ahli kesehatan mental.
                </p>
            @else
                <div class="relative px-4 py-3 mb-4 text-red-700 bg-red-100 border border-red-400 rounded" role="alert">
                    <strong class="font-bold">Maaf!</strong>
                    <span class="block sm:inline">Tidak dapat menampilkan hasil diagnosis.</span>
                </div>
            @endif

            {{-- BAGIAN ADAPTIF: Opsi Setelah Diagnosis --}}
            <div class="flex flex-col mt-8 space-y-4">
                @if (isset($user_is_guest) && $user_is_guest)
                    {{-- Opsi untuk Pengguna Belum Login --}}
                    <div class="p-4 text-yellow-700 bg-yellow-100 border-l-4 border-yellow-500 rounded">
                        <p>Ingin menyimpan riwayat diagnosis ini dan melacak perkembangan Anda? <a href="{{ route('register') }}" class="font-bold underline">Daftar sekarang</a> atau <a href="{{ route('login') }}" class="font-bold underline">Login</a>!</p>
                    </div>
                    <a href="{{ route('diagnosis.form') }}"
                       class="inline-flex items-center justify-center px-6 py-3 text-base font-medium text-white transition duration-200 ease-in-out bg-gray-600 border border-transparent rounded-md shadow-sm hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                        <i class="mr-2 fas fa-redo-alt"></i> Lakukan Diagnosa Lain
                    </a>
                @else
                    {{-- Opsi untuk Pengguna Sudah Login --}}
                    <a href="{{ route('diagnosis.form') }}"
                       class="inline-flex items-center justify-center px-6 py-3 text-base font-medium text-white transition duration-200 ease-in-out bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <i class="mr-2 fas fa-plus-circle"></i> Lakukan Diagnosa Baru
                    </a>
                    <a href="{{ route('predictions.history') }}"
                       class="inline-flex items-center justify-center px-6 py-3 text-base font-medium text-blue-700 transition duration-200 ease-in-out bg-blue-100 border border-transparent rounded-md shadow-sm hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <i class="mr-2 fas fa-history"></i> Lihat Riwayat Diagnosis Saya
                    </a>
                    <a href="{{ route('dashboard') }}"
                       class="inline-flex items-center justify-center px-6 py-3 text-base font-medium text-gray-700 transition duration-200 ease-in-out bg-gray-200 border border-transparent rounded-md shadow-sm hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                        <i class="mr-2 fas fa-tachometer-alt"></i> Kembali ke Dashboard
                    </a>
                @endif
            </div>
            {{-- AKHIR BAGIAN ADAPTIF --}}

        </div>
    </div>
@endsection