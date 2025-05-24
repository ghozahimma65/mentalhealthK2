@extends('layouts.main') {{-- Menggunakan layout main.blade.php yang sudah kita buat --}}

@section('title', 'Dashboard Anda')

@section('content')
    <div class="container p-6 mx-auto lg:p-8">
        {{-- Sapaan Personal --}}
        <h1 class="mb-4 text-3xl font-bold text-gray-800">Halo, {{ Auth::user()->name }}!</h1>
        <p class="mb-8 text-lg text-gray-600">
            Senang melihat Anda kembali! Mari terus pantau kesehatan Anda. ✨
        </p>

        {{-- Area Statistik dan Notifikasi --}}
        <div class="grid grid-cols-1 gap-6 mb-8 md:grid-cols-3">
            {{-- Kartu Jumlah Diagnosa --}}
            <div class="flex flex-col items-start justify-between p-6 bg-white rounded-lg shadow-md">
                <div>
                    <h2 class="mb-2 text-xl font-semibold text-gray-700">Total Diagnosa</h2>
                    <p class="text-5xl font-bold text-blue-600">
                        {{-- Contoh: Ambil dari database --}}
                        {{ $diagnosesCount ?? '0' }}
                    </p>
                </div>
                <p class="mt-4 text-sm text-gray-500">Anda telah aktif memantau kesehatan!</p>
            </div>

            {{-- Kartu Hasil Diagnosa Terakhir --}}
            <div class="flex flex-col items-start justify-between p-6 bg-white rounded-lg shadow-md">
                <div>
                    <h2 class="mb-2 text-xl font-semibold text-gray-700">Diagnosa Terakhir</h2>
                    @if(isset($latestDiagnosis))
                        <p class="text-3xl font-bold {{ $latestDiagnosis->result_class ?? 'text-gray-800' }}">
                            {{ $latestDiagnosis->result_name ?? 'Tidak Diketahui' }}
                        </p>
                        <p class="mt-1 text-sm text-gray-500">Pada: {{ \Carbon\Carbon::parse($latestDiagnosis->created_at)->format('d M Y, H:i') }}</p>
                        <p class="mt-2 text-sm text-gray-600">
                            Terus jaga kesehatan Anda! 💪
                        </p>
                    @else
                        <p class="text-lg text-gray-600">Belum ada diagnosa dilakukan. Mulai yang pertama sekarang!</p>
                    @endif
                </div>
                <a href="{{ route('predictions.history') }}" class="mt-4 text-sm font-medium text-blue-600 hover:underline">Lihat Riwayat Lengkap <i class="ml-1 text-xs fas fa-arrow-right"></i></a>
            </div>

            {{-- Kartu Notifikasi Penting --}}
            <div class="flex flex-col items-start justify-between p-6 bg-white rounded-lg shadow-md">
                <div>
                    <h2 class="mb-2 text-xl font-semibold text-gray-700">Notifikasi Penting</h2>
                    @if(isset($notifications) && $notifications->count() > 0)
                        <ul class="space-y-2 text-sm text-gray-700">
                            @foreach($notifications as $notification)
                                <li class="flex items-center">
                                    <i class="mr-2 text-blue-500 fas fa-bell"></i> {{ $notification->message }}
                                </li>
                            @endforeach
                        </ul>
                        <p class="mt-4 text-sm text-gray-600">
                            Jangan lewatkan informasi penting untuk kesehatan Anda! 🔔
                        </p>
                    @else
                        <p class="text-sm text-gray-600">Tidak ada notifikasi baru saat ini. Semua aman! ✅</p>
                    @endif
                </div>
                <a href="#" class="mt-4 text-sm font-medium text-blue-600 hover:underline">Lihat Semua Notifikasi <i class="ml-1 text-xs fas fa-arrow-right"></i></a>
            </div>
        </div>

        {{-- Area Akses Cepat --}}
        <div class="p-6 mb-8 bg-white rounded-lg shadow-md">
            <h2 class="mb-4 text-xl font-semibold text-gray-700">Akses Cepat</h2>
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                <a href="{{ route('diagnosis.form') }}" class="flex items-center p-4 space-x-3 transition duration-200 rounded-md bg-blue-50 hover:bg-blue-100">
                    <i class="text-2xl text-blue-600 fas fa-robot"></i>
                    <div>
                        <h3 class="font-medium text-gray-800">Mulai Prediksi Diagnosis Baru</h3>
                        <p class="text-sm text-gray-600">Dapatkan prediksi kondisi kesehatan terbaru Anda.</p>
                    </div>
                </a>
                <a href="#" class="flex items-center p-4 space-x-3 transition duration-200 rounded-md bg-purple-50 hover:bg-purple-100">
                    <i class="text-2xl text-purple-600 fas fa-chart-line"></i>
                    <div>
                        <h3 class="font-medium text-gray-800">Perkembangan Pengobatan</h3>
                        <p class="text-sm text-gray-600">Pantau progres pengobatan atau pemulihan Anda.</p>
                    </div>
                </a>
                <a href="{{ route('predictions.history') }}" class="flex items-center p-4 space-x-3 transition duration-200 rounded-md bg-green-50 hover:bg-green-100">
                    <i class="text-2xl text-green-600 fas fa-history"></i>
                    <div>
                        <h3 class="font-medium text-gray-800">Lihat Riwayat Diagnosis</h3>
                        <p class="text-sm text-gray-600">Tinjau semua riwayat prediksi diagnosis Anda.</p>
                    </div>
                </a>
            </div>
            <p class="mt-6 text-sm text-center text-gray-500">
                Kami siap membantu Anda setiap langkah! 😊
            </p>
        </div>

        {{-- Area Grafik Tren (Opsional) --}}
        <div class="p-6 mb-8 bg-white rounded-lg shadow-md">
            <h2 class="mb-4 text-xl font-semibold text-gray-700">Tren Kondisi Kesehatan Anda</h2>
            <p class="mb-4 text-sm text-gray-600">Grafik ini akan menunjukkan perkembangan kondisi Anda seiring waktu.</p>
            <div class="flex items-center justify-center h-64 text-gray-400 bg-gray-100 rounded-md">
                {{-- Placeholder untuk Grafik --}}
                <p>Area untuk grafik tren kondisi (membutuhkan library seperti Chart.js atau sejenisnya)</p>
            </div>
            <p class="mt-4 text-sm text-gray-500">
                Data tren akan menjadi lebih akurat seiring dengan bertambahnya riwayat diagnosa Anda. Terus semangat! ✨
            </p>
        </div>


{{-- Bagian Link Eksternal Kesehatan Mental yang Lebih Menarik --}}
        <div class="p-8 mt-12 text-white shadow-lg bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl">
            <div class="flex items-center justify-center mb-6">
                <i class="mr-4 text-5xl text-white fas fa-heartbeat"></i>
                <h2 class="text-3xl font-bold">Kesehatan Mental Anda Prioritas Kami</h2>
            </div>
            <p class="mb-8 text-lg leading-relaxed text-center opacity-90">
                Kesehatan fisik dan mental saling berkaitan erat. Kami peduli dengan kesejahteraan Anda secara menyeluruh. Jelajahi sumber daya inspiratif di bawah ini untuk mendukung pikiran dan jiwa Anda. **Ingat, Anda tidak sendiri!** 💖
            </p>

            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                {{-- Link 1: Artikel/Berita Umum Kesehatan Mental --}}
                <a href="https://hellosehat.com/mental/" target="_blank" class="block p-5 transition duration-300 transform bg-white rounded-lg bg-opacity-10 backdrop-filter backdrop-blur-sm hover:bg-opacity-20 hover:scale-105">
                    <div class="flex items-center mb-3">
                        <i class="mr-3 text-2xl text-blue-300 fas fa-book-reader"></i>
                        <h3 class="text-xl font-semibold">Artikel & Wawasan Terbaru</h3>
                    </div>
                    <p class="text-sm opacity-80">Temukan informasi mendalam dan tips praktis untuk menjaga kesehatan mental dari Hello Sehat.</p>
                    <span class="block mt-3 text-xs opacity-70">hellosehat.com <i class="ml-1 fas fa-external-link-alt"></i></span>
                </a>

                {{-- Link 2: Organisasi/Yayasan Dukungan Kesehatan Mental --}}
                <a href="https://www.intothelightid.org/" target="_blank" class="block p-5 transition duration-300 transform bg-white rounded-lg bg-opacity-10 backdrop-filter backdrop-blur-sm hover:bg-opacity-20 hover:scale-105">
                    <div class="flex items-center mb-3">
                        <i class="mr-3 text-2xl text-green-300 fas fa-hands-helping"></i>
                        <h3 class="text-xl font-semibold">Dukungan Komunitas</h3>
                    </div>
                    <p class="text-sm opacity-80">Kunjungi Into The Light Indonesia untuk dukungan emosional dan sumber daya pencegahan bunuh diri.</p>
                    <span class="block mt-3 text-xs opacity-70">intothelightid.org <i class="ml-1 fas fa-external-link-alt"></i></span>
                </a>

                {{-- Link 3: Tips Mengelola Stres --}}
                <a href="https://www.alodokter.com/cara-mengatasi-stres" target="_blank" class="block p-5 transition duration-300 transform bg-white rounded-lg bg-opacity-10 backdrop-filter backdrop-blur-sm hover:bg-opacity-20 hover:scale-105">
                    <div class="flex items-center mb-3">
                        <i class="mr-3 text-2xl text-purple-300 fas fa-leaf"></i>
                        <h3 class="text-xl font-semibold">Teknik Relaksasi & Ketenangan</h3>
                    </div>
                    <p class="text-sm opacity-80">Pelajari cara-cara efektif dari Alodokter untuk mengelola stres dan menjaga pikiran tetap tenang.</p>
                    <span class="block mt-3 text-xs opacity-70">alodokter.com <i class="ml-1 fas fa-external-link-alt"></i></span>
                </a>

                {{-- Link 4: Sumber Inspirasi/Kata-kata Motivasi --}}
                <a href="https://www.psychologytoday.com/us/blog/prescribing-wellness/202210/25-mental-health-quotes-boost-your-well-being" target="_blank" class="block p-5 transition duration-300 transform bg-white rounded-lg bg-opacity-10 backdrop-filter backdrop-blur-sm hover:bg-opacity-20 hover:scale-105">
                    <div class="flex items-center mb-3">
                        <i class="mr-3 text-2xl text-yellow-300 fas fa-lightbulb"></i>
                        <h3 class="text-xl font-semibold">Inspirasi & Motivasi Harian</h3>
                    </div>
                    <p class="text-sm opacity-80">Dapatkan dosis positif dari kutipan dan pesan penyemangat untuk meningkatkan suasana hati Anda.</p>
                    <span class="block mt-3 text-xs opacity-70">psychologytoday.com <i class="ml-1 fas fa-external-link-alt"></i></span>
                </a>
            </div>

            <p class="mt-10 text-lg font-medium text-center">
                Penting untuk mencari bantuan profesional jika Anda merasa tidak baik. Anda berharga dan layak mendapatkan dukungan terbaik. ❤️
            </p>
        </div>
@endsection

@push('scripts')
    {{-- Jika Anda menggunakan Chart.js atau library grafik lainnya, impor di sini --}}
    {{-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> --}}
    <script>
        // Contoh JavaScript untuk inisialisasi grafik jika ada
        // const ctx = document.getElementById('myHealthChart').getContext('2d');
        // new Chart(ctx, { ... });
    </script>
@endpush

