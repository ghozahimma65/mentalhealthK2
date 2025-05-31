@extends('layouts.main') {{-- Menggunakan layout utama Anda --}}

@section('title', 'Dashboard Anda')

@section('content') {{-- Memulai bagian konten utama halaman --}}
    <div class="container p-6 mx-auto lg:p-8">
        {{-- Sapaan Personal --}}
        <h1 class="mb-4 text-3xl font-bold text-gray-800">Halo, {{ Auth::user()->name }}!</h1>
        <p class="mb-8 text-lg text-gray-600">
            Senang melihat Anda kembali! Mari terus pantau kesehatan Anda. ✨
        </p>

        {{-- Area Statistik dan Notifikasi --}}
        <div class="grid grid-cols-1 gap-6 mb-8 md:grid-cols-3">
            {{-- Kartu Jumlah Diagnosis --}}
            {{-- Kartu Total Aktivitas Prediksi (Pengganti 'Total Diagnosis') --}}
    <div class="flex flex-col items-start justify-between p-6 bg-white rounded-lg shadow-md">
        <div>
            <h2 class="mb-2 text-xl font-semibold text-gray-700">Total Aktivitas Prediksi</h2>
            <p class="text-5xl font-bold text-blue-600">
                {{ $totalActivities ?? '0' }} {{-- Variabel ini harus disiapkan di Controller --}}
            </p>
        </div>
        <p class="mt-4 text-sm text-gray-500">Jumlah total diagnosis & catatan perkembangan.</p>
    </div>

            {{-- Kartu Hasil Diagnosis Terakhir --}}
            <div class="flex flex-col items-start justify-between p-6 bg-white rounded-lg shadow-md">
                <div>
                    <h2 class="mb-2 text-xl font-semibold text-gray-700">Diagnosis Terakhir</h2>
                    @if(isset($latestDiagnosis))
                        <p class="text-3xl font-bold {{ $latestDiagnosis->result_class ?? 'text-gray-800' }}">
                            {{ $latestDiagnosis->result_name ?? 'Tidak Diketahui' }}
                        </p>
                        <p class="mt-1 text-sm text-gray-500">Pada: {{ \Carbon\Carbon::parse($latestDiagnosis->timestamp)->format('d M Y, H:i') }}</p>
                        <p class="mt-2 text-sm text-gray-600">
                            Terus jaga kesehatan Anda! 💪
                        </p>
                    @else
                        <p class="text-lg text-gray-600">Belum ada diagnosis dilakukan. Mulai yang pertama sekarang!</p>
                    @endif
                </div>
            </div>

            {{-- Kartu Aktivitas Terbaru --}}
            <div class="flex flex-col items-start justify-between p-6 bg-white rounded-lg shadow-md">
                <div>
                    <h2 class="mb-2 text-xl font-semibold text-gray-700">Aktivitas Terbaru</h2>
                    @if(isset($lastPredictionOverall))
                        <div class="flex items-center mb-3 text-lg font-medium text-gray-800">
                            <i class="mr-2 text-blue-500 fas fa-calendar-alt"></i>
                            Terakhir Melakukan Prediksi: <span class="ml-1 text-blue-600">{{ $lastPredictionOverall->format('d M Y') }}</span>
                        </div>
                        <p class="text-sm text-gray-600">
                            Pukul: {{ $lastPredictionOverall->format('H:i') }} WIB
                        </p>
                        <p class="mt-2 text-sm text-gray-600">
                            Kami mencatat aktivitas prediksi terbaru Anda.
                        </p>
                    @else
                        <div class="flex items-center mb-3 text-lg text-gray-600">
                            <i class="mr-2 text-gray-400 fas fa-calendar-times"></i>
                            Belum ada aktivitas prediksi.
                        </div>
                        <p class="text-sm text-gray-600">Mulai prediksi diagnosis atau catat perkembangan pertama Anda sekarang!</p>
                    @endif
                    
                    @if(!isset($lastPredictionOverall) && (!isset($notifications) || $notifications->isEmpty()))
                         <p class="mt-4 text-sm text-gray-600">Tidak ada notifikasi atau aktivitas terbaru lainnya. Semua aman! ✅</p>
                    @endif
                </div>
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
                
                <a href="{{ route('outcome.create') }}" class="flex items-center p-4 space-x-3 transition duration-200 rounded-md bg-yellow-50 hover:bg-yellow-100">
                    <i class="text-2xl text-yellow-600 fas fa-notes-medical"></i>
                    <div>
                        <h3 class="font-medium text-gray-800">Catat Perkembangan Baru</h3>
                        <p class="text-sm text-gray-600">Isi kuesioner untuk prediksi perkembangan terbaru.</p>
                    </div>
                </a>
                <a href="{{ route('history.select_type') }}" class="flex items-center p-4 space-x-3 transition duration-200 rounded-md bg-purple-50 hover:bg-purple-100">
                    <i class="text-2xl text-purple-600 fas fa-chart-line"></i>
                    <div>
                        <h3 class="font-medium text-gray-800">Riwayat Diagnosis & Pengobatan</h3>
                        <p class="text-sm text-gray-600">Pantau progres pengobatan atau pemulihan Anda.</p>
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
            <p class="mb-4 text-sm text-gray-600">Grafik ini menunjukkan perkembangan kondisi Anda seiring waktu.</p>
            
            {{-- Pastikan $chartData adalah array, meskipun kosong atau null --}}
            @php
                $chartData = $chartData ?? []; // Inisialisasi $chartData menjadi array kosong jika null
            @endphp

            @if (count($chartData) > 1) 
                <div class="relative h-96">
                    <canvas id="healthTrendChart"></canvas>
                </div>
                <p class="mt-4 text-sm text-gray-500">
                    Data tren akan menjadi lebih akurat seiring dengan bertambahnya riwayat prediksi perkembangan Anda. Terus semangat! ✨
                </p>
            @else
                <div class="flex items-center justify-center h-64 text-gray-400 bg-gray-100 rounded-md">
                    <p>Lakukan minimal 2 kali prediksi perkembangan untuk melihat tren Anda di sini.</p>
                </div>
                <p class="mt-4 text-sm text-gray-500">
                    Data tren akan muncul setelah Anda melakukan lebih banyak prediksi perkembangan. Terus semangat! ✨
                </p>
            @endif
        </div>

        {{-- Bagian Link Eksternal Kesehatan Mental --}}
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
                    <p class="text-sm opacity-80">Kunjungi Into The Light Indonesia untuk bantuan dan edukasi.</p>
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
    </div>
    
@endsection

@push('scripts')
    {{-- Impor Chart.js dari CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Pastikan data yang diterima dari Blade adalah array atau default ke array kosong
            const chartLabels = @json($chartLabels); // Labels (dates)
            const chartData = @json($chartData);     // Numerical data (0, 1, 2)
            const plotLabelsMap = @json($plotLabelsMap); // Map for Y-axis ticks

            if (chartLabels.length > 1) { // Hanya inisialisasi chart jika ada setidaknya 2 data point
                const ctx = document.getElementById('healthTrendChart').getContext('2d');

                const healthTrendChart = new Chart(ctx, {
                    type: 'line', // Jenis grafik: garis
                    data: {
                        labels: chartLabels,
                        datasets: [{
                            label: 'Perkembangan Kondisi',
                            data: chartData,
                            borderColor: 'rgb(75, 192, 192)', // Warna garis
                            backgroundColor: 'rgba(75, 192, 192, 0.2)', // Warna area di bawah garis
                            tension: 0.1, // Kelengkungan garis
                            fill: true,
                            pointRadius: 5,
                            pointBackgroundColor: 'rgb(75, 192, 192)',
                            pointBorderColor: '#fff',
                            pointHoverRadius: 7,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                ticks: {
                                    callback: function(value, index, ticks) {
                                        return plotLabelsMap[value] || '';
                                    }
                                },
                                min: 0,
                                max: 2,
                                stepSize: 1,
                                title: {
                                    display: true,
                                    text: 'Kondisi'
                                }
                            },
                            x: {
                                title: {
                                    display: true,
                                    text: 'Tanggal'
                                },
                                grid: {
                                    display: false
                                }
                            }
                        },
                        plugins: {
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        let label = context.dataset.label || '';
                                        if (label) {
                                            label += ': ';
                                        }
                                        const value = context.raw;
                                        return label + (plotLabelsMap[value] || 'N/A');
                                    }
                                }
                            },
                            legend: {
                                display: false
                            }
                        }
                    }
                });
            }
        });
    </script>
@endpush