{{-- resources/views/admin/dashboard_content.blade.php --}}
@extends('admin.dashboard') {{-- Pastikan ini meng-extend layout admin yang benar --}}

@section('title', 'Dashboard Admin')
@section('header_title', 'Dashboard Statistik')

@section('content')
<div class="container mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <h1 class="text-3xl font-bold mb-8 text-center text-gray-800">Overview Statistik Aplikasi</h1>

    {{-- Statistik Card --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        {{-- Card Total Pengguna --}}
        <div class="bg-white rounded-lg shadow-md p-6 flex items-center justify-between">
            <div>
                <h2 class="text-xl font-semibold text-gray-700">Total Pengguna</h2>
                <p class="text-4xl font-extrabold text-blue-600 mt-2">{{ $totalUsers }}</p>
            </div>
            <div class="text-blue-400 text-5xl">
                <i class="fas fa-users"></i>
            </div>
        </div>

        {{-- Card Total Diagnosis --}}
        <div class="bg-white rounded-lg shadow-md p-6 flex items-center justify-between">
            <div>
                <h2 class="text-xl font-semibold text-gray-700">Diagnosis Diproses</h2>
                <p class="text-4xl font-extrabold text-green-600 mt-2">{{ $totalProcessedDiagnoses }}</p>
            </div>
            <div class="text-green-400 text-5xl">
                <i class="fas fa-notes-medical"></i>
            </div>
        </div>

        {{-- Card Rata-rata Akurasi (Contoh) --}}
        <div class="bg-white rounded-lg shadow-md p-6 flex items-center justify-between">
            <div>
                <h2 class="text-xl font-semibold text-gray-700">Rata-rata Akurasi (Contoh)</h2>
                <p class="text-4xl font-extrabold text-purple-600 mt-2">92%</p>
            </div>
            <div class="text-purple-400 text-5xl">
                <i class="fas fa-chart-line"></i>
            </div>
        </div>
    </div>

    {{-- Kontainer untuk Dua Pie Charts (Distribusi Gangguan Mental & Gender) --}}
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h2 class="text-2xl font-semibold text-gray-800 mb-6 text-center">Distribusi Umum Pengguna & Diagnosis</h2>
        {{-- PASTIKAN DIV INI MEMILIKI GRID DENGAN 2 KOLOM PADA UKURAN MENENGAH KE ATAS --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            {{-- Diagram Distribusi Jenis Gangguan Mental --}}
            <div>
                <h3 class="text-xl font-semibold text-gray-700 mb-4 text-center">Distribusi Jenis Gangguan Mental</h3>
                {{-- Kontainer canvas dengan tinggi tetap --}}
                <div class="relative h-64 md:h-72 lg:h-80 w-full flex justify-center items-center mx-auto">
                    <canvas id="diagnosisChart"></canvas>
                </div>
            </div>

            {{-- Diagram Distribusi Gender Pengguna --}}
            <div>
                <h3 class="text-xl font-semibold text-gray-700 mb-4 text-center">Distribusi Gender Pengguna</h3>
                {{-- Kontainer canvas dengan tinggi tetap --}}
                <div class="relative h-64 md:h-72 lg:h-80 w-full flex justify-center items-center mx-auto">
                    <canvas id="genderChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    {{-- Kontainer untuk Tren Diagnosis Harian (Bar Chart) --}}
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-2xl font-semibold text-gray-800 mb-6 text-center">Tren Diagnosis Harian 7 Hari Terakhir</h2>
        {{-- Kontainer canvas dengan tinggi lebih besar dan lebar penuh --}}
        <div class="relative h-72 md:h-80 lg:h-96 w-full">
            <canvas id="dailyDiagnosisChart"></canvas>
        </div>
    </div>

    {{-- Tambahkan visualisasi lain di sini --}}
</div>
@endsection

@push('scripts')
{{-- Sertakan Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Data dari Controller
        const diagnosisLabels = {!! $diagnosisLabels !!};
        const diagnosisData = {!! $diagnosisData !!};
        const dailyLabels = {!! $dailyLabels !!};
        const dailyData = {!! $dailyData !!};
        const genderLabels = {!! $genderLabels !!};
        const genderData = {!! $genderData !!};


        // Fungsi untuk mendapatkan palet warna yang menarik dan berbeda
        function getChartColors(numColors, type = 'default') {
            let backgroundColors = [];
            let borderColors = [];

            if (type === 'pie') {
                // Palet warna cerah untuk pie chart
                const pieColors = [
                    'rgba(255, 159, 64, 0.8)',  // Oranye
                    'rgba(54, 162, 235, 0.8)',  // Biru
                    'rgba(255, 99, 132, 0.8)',  // Merah
                    'rgba(75, 192, 192, 0.8)',  // Teal
                    'rgba(153, 102, 255, 0.8)', // Ungu
                    'rgba(201, 203, 207, 0.8)', // Abu-abu
                    'rgba(255, 205, 86, 0.8)',  // Kuning
                    'rgba(231, 233, 237, 0.8)'
                ];
                for (let i = 0; i < numColors; i++) {
                    backgroundColors.push(pieColors[i % pieColors.length]);
                    borderColors.push(pieColors[i % pieColors.length].replace('0.8', '1')); // Border lebih gelap
                }
            } else if (type === 'bar') {
                // Palet warna yang lebih solid untuk bar chart
                backgroundColors = ['rgba(102, 187, 106, 0.8)']; // Hijau stabil
                borderColors = ['rgba(102, 187, 106, 1)'];
            } else {
                // Default fallback
                const defaultColors = [
                    'rgba(255, 99, 132, 0.7)',
                    'rgba(54, 162, 235, 0.7)',
                    'rgba(255, 206, 86, 0.7)',
                    'rgba(75, 192, 192, 0.7)',
                    'rgba(153, 102, 255, 0.7)',
                    'rgba(255, 159, 64, 0.7)'
                ];
                for (let i = 0; i < numColors; i++) {
                    backgroundColors.push(defaultColors[i % defaultColors.length]);
                    borderColors.push(defaultColors[i % defaultColors.length].replace('0.7', '1'));
                }
            }
            return { backgroundColor: backgroundColors, borderColor: borderColors };
        }


        // Chart 1: Distribusi Jenis Gangguan Mental (Pie Chart)
        const colorsDiagnosis = getChartColors(diagnosisLabels.length, 'pie');
        const ctxDiagnosis = document.getElementById('diagnosisChart').getContext('2d');
        new Chart(ctxDiagnosis, {
            type: 'pie',
            data: {
                labels: diagnosisLabels,
                datasets: [{
                    label: 'Jumlah Diagnosis',
                    data: diagnosisData,
                    backgroundColor: colorsDiagnosis.backgroundColor,
                    borderColor: colorsDiagnosis.borderColor,
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            font: {
                                size: 12
                            }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed !== null) {
                                    label += context.parsed + ' kasus';
                                }
                                return label;
                            }
                        }
                    }
                }
            }
        });

        // Chart 3: Distribusi Gender Pengguna (Pie Chart)
        const colorsGender = getChartColors(genderLabels.length, 'pie');
        const ctxGender = document.getElementById('genderChart').getContext('2d');
        new Chart(ctxGender, {
            type: 'pie',
            data: {
                labels: genderLabels,
                datasets: [{
                    label: 'Jumlah Pengguna',
                    data: genderData,
                    backgroundColor: colorsGender.backgroundColor,
                    borderColor: colorsGender.borderColor,
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            font: {
                                size: 12
                            }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed !== null) {
                                    label += context.parsed + ' pengguna';
                                }
                                return label;
                            }
                        }
                    }
                }
            }
        });

        // Chart 2: Tren Diagnosis Harian (Bar Chart)
        const colorsDaily = getChartColors(1, 'bar');
        const ctxDailyDiagnosis = document.getElementById('dailyDiagnosisChart').getContext('2d');
        new Chart(ctxDailyDiagnosis, {
            type: 'bar',
            data: {
                labels: dailyLabels,
                datasets: [{
                    label: 'Jumlah Diagnosis',
                    data: dailyData,
                    backgroundColor: colorsDaily.backgroundColor,
                    borderColor: colorsDaily.borderColor,
                    borderWidth: 1,
                    barPercentage: 0.8,
                    categoryPercentage: 0.8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Jumlah Diagnosis',
                            color: '#4a5568'
                        },
                        ticks: {
                            stepSize: 1,
                            color: '#4a5568'
                        },
                        grid: {
                            color: 'rgba(200, 200, 200, 0.4)'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Tanggal',
                            color: '#4a5568'
                        },
                        ticks: {
                            color: '#4a5568'
                        },
                        grid: {
                            display: false
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.7)',
                        titleColor: '#fff',
                        bodyColor: '#fff',
                        borderColor: '#fff',
                        borderWidth: 1,
                        padding: 10,
                        displayColors: false,
                        callbacks: {
                            title: function(context) {
                                return context[0].label;
                            },
                            label: function(context) {
                                return 'Diagnosis: ' + context.parsed.y;
                            }
                        }
                    }
                }
            }
        });

    });
</script>
@endpush