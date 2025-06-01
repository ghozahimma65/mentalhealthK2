@extends('layouts.main') {{-- Menggunakan layout utama Anda --}}

@section('title', 'Hasil Prediksi Perkembangan') {{-- Judul halaman --}}

{{-- @push('styles') --}}
{{-- Anda bisa memindahkan CSS kustom dari sini ke file CSS utama Anda (app.css) atau menggunakan @stack('styles') jika perlu --}}
<style>
    .result-box {
        background-color: #e0f2f7; /* Light blue background */
        border: 1px solid #b2ebf2; /* Border matching the color */
        color: #00838f; /* Darker teal text */
        padding: 2.5rem; /* Padding diperbesar */
        border-radius: 0.75rem; /* Sudut lebih melengkung */
        font-size: 1.625rem; /* Ukuran font diperbesar */
        font-weight: bold;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); /* Bayangan */
    }
    /* Tambahkan gaya untuk warna teks berdasarkan hasil */
    .text-improved { color: #28a745; } /* Hijau untuk improved */
    .text-deteriorated { color: #dc3545; } /* Merah untuk deteriorated */
    .text-no-change { color: #ffc107; } /* Kuning/Oranye untuk no change */
</style>
{{-- @endpush --}}

@section('content') {{-- Konten utama halaman --}}
    <div class="flex items-center justify-center min-h-screen p-4">
        {{-- Kontainer utama hasil prediksi diperbesar --}}
        <div class="w-full max-w-2xl p-10 text-center bg-white border border-gray-200 rounded-lg shadow-xl">
            <div class="mb-8 text-center">
                <img src="{{ asset('assets/logo.png') }}" alt="Logo Diagnosa" width="50" height="50" class="mx-auto mb-3">
                <h1 class="mb-2 text-4xl font-extrabold text-gray-800">Hasil Prediksi Perkembangan Anda</h1> {{-- Judul diperbesar --}}
                <p class="text-lg text-gray-600">Dapatkan gambaran tentang progres kesehatan mental Anda.</p>
            </div>

            <p class="mb-8 text-xl text-gray-600">Berdasarkan data yang Anda berikan, prediksi perkembangan kesehatan mental Anda adalah:</p> {{-- Paragraf diperbesar --}}

            @if (isset($outcome_prediction))
                {{-- Kotak hasil prediksi diperbesar padding dan margin-nya --}}
                <div class="mb-10 result-box">
                    <p class="text-5xl font-extrabold 
                        @if ($outcome_prediction == 1) text-improved
                        @elseif ($outcome_prediction == 0) text-deteriorated
                        @elseif ($outcome_prediction == 2) text-no-change
                        @else text-gray-800 @endif
                    ">
                        {{-- Tampilkan nilai numerik atau nama hasil --}}
                        @if ($outcome_prediction == 0)
                            Deteriorated
                        @elseif ($outcome_prediction == 1)
                            Improved
                        @elseif ($outcome_prediction == 2)
                            No Change
                        @else
                            {{ $outcome_prediction }} {{-- Tampilkan nilai mentah jika tidak cocok --}}
                        @endif
                    </p>
                    <p class="mt-3 text-lg text-gray-700"> {{-- Ukuran teks diperbesar --}}
                        {{-- Keterangan lebih lanjut berdasarkan nilai outcome_prediction --}}
                        @if ($outcome_prediction == 1)
                            (Kondisi Anda diprediksi **membaik**! Ini adalah kabar baik, terus pertahankan progres Anda. ✨)
                        @elseif ($outcome_prediction == 0)
                            (Kondisi Anda diprediksi **memburuk**. Kami menyarankan untuk segera mempertimbangkan konsultasi lebih lanjut dengan profesional kesehatan mental. Jangan ragu mencari dukungan. 😔)
                        @elseif ($outcome_prediction == 2)
                            (Kondisi Anda diprediksi **stabil** tanpa perubahan signifikan. Tetap waspada dan terus ikuti rencana pengobatan/terapi Anda. 💪)
                        @else
                            (Prediksi outcome tidak diketahui atau perlu analisis lebih lanjut.)
                        @endif
                    </p>
                </div>
                <p class="leading-relaxed text-gray-700 text-md"> {{-- Ukuran teks diperbesar dan leading --}}
                    *Prediksi ini berdasarkan model AI dan tidak menggantikan evaluasi dari profesional kesehatan mental.
                    Selalu konsultasikan dengan ahli untuk keputusan terkait pengobatan atau terapi Anda.
                </p>
            @else
                <div class="relative px-4 py-3 mb-4 text-red-700 bg-red-100 border border-red-400 rounded" role="alert">
                    <strong class="font-bold">Maaf!</strong>
                    <span class="block sm:inline">Tidak dapat menampilkan hasil prediksi perkembangan.</span>
                </div>
            @endif

            {{-- Opsi Setelah Prediksi --}}
            <div class="flex flex-col mt-10 space-y-5"> {{-- Margin-top dan space-y diperbesar --}}
                <a href="{{ route('outcome.create') }}"
                   class="inline-flex items-center justify-center px-8 py-4 text-lg font-medium text-white transition duration-200 ease-in-out bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <i class="mr-3 fas fa-plus-circle"></i> Catat Perkembangan Baru
                </a>
                <a href="{{ route('outcome.comprehensive_history') }}"
                   class="inline-flex items-center justify-center px-8 py-4 text-lg font-medium text-blue-700 transition duration-200 ease-in-out bg-blue-100 border border-transparent rounded-md shadow-sm hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <i class="mr-3 fas fa-chart-line"></i> Lihat Riwayat Perkembangan Saya
                </a>
                <a href="{{ route('dashboard') }}"
                   class="inline-flex items-center justify-center px-8 py-4 text-lg font-medium text-gray-700 transition duration-200 ease-in-out bg-gray-200 border border-transparent rounded-md shadow-sm hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                    <i class="mr-3 fas fa-tachometer-alt"></i> Kembali ke Dashboard
                </a>
            </div>
        </div>
    </div>
@endsection