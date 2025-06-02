@extends('admin.dashboard')

@section('title', 'Tren Hasil Klasifikasi Global')

@push('styles')
<style>
    .chart-container {
        position: relative;
        margin: auto;
        height: 320px;
        width: 100%;
    }
</style>
@endpush

@section('content')
    <div class="container p-6 mx-auto lg:p-8">
        <h1 class="mb-6 text-3xl font-bold text-gray-800">Tren Hasil Klasifikasi Global</h1>
        <p class="mb-8 text-gray-600">Visualisasi dan statistik mengenai hasil diagnosis dan perkembangan dari seluruh pengguna.</p>

        <div class="grid grid-cols-1 gap-8 mb-8 md:grid-cols-2">
            {{-- Kartu Grafik Distribusi Diagnosis --}}
            <div class="p-6 bg-white shadow-lg md:p-8 rounded-xl">
                <h2 class="mb-6 text-xl font-semibold text-center text-gray-700 md:text-2xl">Distribusi Diagnosis Awal</h2>
                <div class="chart-container">
                    @if (isset($diagnosisLabels) && $diagnosisLabels->isNotEmpty() && isset($diagnosisData) && $diagnosisData->isNotEmpty())
                        <canvas id="diagnosisDistributionChart"></canvas>
                    @else
                        <p class="flex items-center justify-center h-full text-gray-500">Data diagnosis tidak cukup untuk ditampilkan.</p>
                    @endif
                </div>
                <p class="mt-4 text-sm text-center text-gray-500">
                    Menunjukkan jumlah total setiap jenis diagnosis awal yang tercatat.
                </p>
            </div>

            {{-- Kartu Grafik Tren Perkembangan Global --}}
            <div class="p-6 bg-white shadow-lg md:p-8 rounded-xl">
                <h2 class="mb-6 text-xl font-semibold text-center text-gray-700 md:text-2xl">Tren Perkembangan Pengguna Global</h2>
                <div class="chart-container">
                    @if (isset($outcomeChartLabels) && count($outcomeChartLabels) > 1 && isset($outcomeChartData) && count($outcomeChartData) > 1)
                        <canvas id="outcomeTrendChart"></canvas>
                    @else
                        <p class="flex items-center justify-center h-full text-gray-500">Minimal 2 data perkembangan diperlukan untuk menampilkan tren.</p>
                    @endif
                </div>
                <p class="mt-4 text-sm text-center text-gray-500">
                    Garis ini menunjukkan tren kondisi rata-rata seluruh pengguna dari waktu ke waktu.
                </p>
            </div>
        </div>

        {{-- Bagian Statistik Ringkas Tambahan --}}
        <div class="p-6 bg-white shadow-lg md:p-8 rounded-xl">
            <h2 class="mb-6 text-xl font-semibold text-center text-gray-700 md:text-2xl">Statistik Klasifikasi</h2>
            <div class="grid grid-cols-1 gap-6 text-center md:grid-cols-3">
                <div class="p-4 rounded-lg bg-gray-50">
                    <p class="text-2xl font-bold text-blue-600">{{ (isset($diagnosisData) && ($diagnosisData instanceof \Illuminate\Support\Collection || is_array($diagnosisData))) ? collect($diagnosisData)->sum() : 0 }}</p>
                    <p class="text-sm text-gray-600">Total Diagnosis Tercatat</p>
                </div>
                <div class="p-4 rounded-lg bg-gray-50">
                    <p class="text-2xl font-bold text-purple-600">{{ $globalOutcomes_count ?? 0 }}</p>
                    <p class="text-sm text-gray-600">Total Catatan Perkembangan</p>
                </div>
                <div class="p-4 rounded-lg bg-gray-50">
                    <p class="text-2xl font-bold text-green-600">N/A</p>
                    <p class="text-sm text-gray-600">Rata-rata Skor Stres (Contoh)</p>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // --- Grafik Distribusi Diagnosis ---
            // Gunakan json_encode secara eksplisit dan pastikan variabel adalah array dari controller
            const diagnosisLabels = JSON.parse('{!! addslashes(json_encode($diagnosisLabels ?? [])) !!}');
            const diagnosisData = JSON.parse('{!! addslashes(json_encode($diagnosisData ?? [])) !!}');
            const diagnosisColors = JSON.parse('{!! addslashes(json_encode($diagnosisColors ?? ['#FF6384', '#36A2EB', '#FFCE56'])) !!}'); // Sederhanakan fallback colors

            if (diagnosisLabels.length > 0 && diagnosisData.length > 0 && document.getElementById('diagnosisDistributionChart')) {
                const ctxDiagnosis = document.getElementById('diagnosisDistributionChart').getContext('2d');
                new Chart(ctxDiagnosis, {
                    type: 'doughnut',
                    data: {
                        labels: diagnosisLabels,
                        datasets: [{
                            label: 'Distribusi Diagnosis',
                            data: diagnosisData,
                            backgroundColor: diagnosisColors,
                            hoverOffset: 8,
                            borderColor: '#fff',
                            borderWidth: 2
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { position: 'bottom', labels: { padding: 15, boxWidth: 12, font: { size: 10 } } },
                            title: { display: false },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        let label = context.label || '';
                                        if (label) { label += ': '; }
                                        if (context.parsed !== null) { label += context.parsed; }
                                        const total = context.dataset.data.reduce((acc, value) => acc + value, 0);
                                        const percentage = total > 0 ? ((context.parsed / total) * 100).toFixed(1) + '%' : '0%';
                                        return label + ' (' + percentage + ')';
                                    }
                                }
                            }
                        }
                    }
                });
            } else {
                console.log("Data diagnosis tidak cukup atau elemen chart 'diagnosisDistributionChart' tidak ditemukan.");
            }

            // --- Grafik Tren Perkembangan Global ---
            const outcomeChartLabels = JSON.parse('{!! addslashes(json_encode($outcomeChartLabels ?? [])) !!}');
            const outcomeChartData = JSON.parse('{!! addslashes(json_encode($outcomeChartData ?? [])) !!}');
            const plotLabelsMap = JSON.parse('{!! addslashes(json_encode($plotLabelsMap ?? (object)[0 => 'Memburuk', 1 => 'Tidak Berubah', 2 => 'Membaik'])) !!}');

            if (outcomeChartLabels.length > 1 && outcomeChartData.length > 1 && document.getElementById('outcomeTrendChart')) {
                const ctxOutcome = document.getElementById('outcomeTrendChart').getContext('2d');
                new Chart(ctxOutcome, {
                    type: 'line',
                    data: {
                        labels: outcomeChartLabels,
                        datasets: [{
                            label: 'Tren Perkembangan Global',
                            data: outcomeChartData,
                            borderColor: 'rgb(101, 116, 205)',
                            backgroundColor: 'rgba(101, 116, 205, 0.1)',
                            tension: 0.3,
                            fill: true,
                            pointRadius: 4,
                            pointBackgroundColor: 'rgb(101, 116, 205)',
                            pointBorderColor: '#fff',
                            pointHoverRadius: 6,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                ticks: {
                                    callback: function(value, index, ticks) {
                                        return plotLabelsMap[value] !== undefined ? plotLabelsMap[value] : String(value);
                                    },
                                    font: { size: 10 }
                                },
                                min: 0,
                                max: 2,
                                suggestedMin: 0,
                                suggestedMax: 2,
                                title: { display: true, text: 'Kondisi Rata-Rata Global', font: { size: 12, weight: 'bold' } }
                            },
                            x: {
                                title: { display: true, text: 'Tanggal', font: { size: 12, weight: 'bold' } },
                                grid: { display: false },
                                ticks: { font: { size: 10 } }
                            }
                        },
                        plugins: {
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        let label = context.dataset.label || '';
                                        if (label) { label += ': '; }
                                        const value = context.raw;
                                        return label + (plotLabelsMap[value] !== undefined ? plotLabelsMap[value] : 'N/A');
                                    }
                                }
                            },
                            legend: { display: false }
                        }
                    }
                });
            } else {
                 console.log("Data outcome tidak cukup atau elemen chart 'outcomeTrendChart' tidak ditemukan.");
            }
        });
    </script>
@endpush