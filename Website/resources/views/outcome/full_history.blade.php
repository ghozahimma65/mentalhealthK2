@extends('layouts.main') {{-- Menggunakan layout utama Anda --}}

@section('title', 'Riwayat Perkembangan Pengobatan') {{-- Judul halaman diubah --}}

@section('content')
    <div class="container p-6 mx-auto lg:p-8">
        <h1 class="mb-6 text-3xl font-bold text-gray-800">Riwayat Perkembangan Pengobatan Anda</h1>
        <p class="mb-8 text-gray-600">Berikut adalah catatan semua prediksi perkembangan kondisi Anda.</p>

        {{-- Bagian Grafik Tren (DIHILANGKAN DARI SINI) --}}
        {{--
        <div class="p-8 mb-8 bg-white shadow-lg rounded-xl">
            <h2 class="mb-6 text-2xl font-bold text-center text-gray-800">Tren Perkembangan Kondisi</h2>
            <p class="mb-8 text-lg text-center text-gray-600">Visualisasikan progres Anda seiring waktu dari prediksi perkembangan.</p>
            
            @php
                $chartData = $chartData ?? [];
                $chartLabels = $chartLabels ?? [];
                $plotLabelsMap = $plotLabelsMap ?? [];
            @endphp

            @if (count($chartData) > 1)
                <div class="relative h-96">
                    <canvas id="healthTrendChart"></canvas>
                </div>
                <p class="mt-8 text-sm text-center text-gray-500">
                    Grafik ini menampilkan tren kondisi Anda berdasarkan hasil prediksi perkembangan.
                </p>
            @else
                <div class="flex items-center justify-center h-64 text-gray-400 bg-gray-100 border border-gray-300 border-dashed rounded-lg">
                    <p class="text-lg text-center">
                        <i class="mb-3 text-4xl fas fa-chart-line"></i><br>
                        Lakukan minimal 2 kali prediksi perkembangan untuk melihat tren Anda di sini.
                    </p>
                </div>
                <p class="mt-8 text-sm text-center text-gray-500">
                    Grafik tren akan muncul setelah Anda mencatat lebih banyak perkembangan (outcome).
                </p>
            @endif
        </div>
        --}}

        {{-- Bagian Tabel Riwayat Outcome Saja --}}
        <div class="p-8 mb-8 bg-white shadow-lg rounded-xl">
            <h2 class="mb-6 text-2xl font-bold text-center text-gray-800">Catatan Perkembangan Lengkap</h2>
            
            @php
                $outcomeResults = $outcomeResults ?? collect(); // Pastikan variabel diinisialisasi
                // Untuk admin, variabelnya adalah $allOutcomeResults
                if (Auth::check() && Auth::user()->isAdmin()) {
                    $outcomeResults = $allOutcomeResults ?? collect();
                }
            @endphp

            @if ($outcomeResults->isEmpty())
                <div class="p-4 text-blue-700 bg-blue-100 border-l-4 border-blue-500 rounded-lg" role="alert">
                    <p class="mb-2 font-bold">Belum Ada Catatan Perkembangan!</p>
                    <p>Mulai <a href="{{ route('outcome.create') }}" class="underline">catatan perkembangan pertama Anda sekarang</a>.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Tanggal</th>
                                <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Diagnosis Terakhir</th>
                                <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Tingkat Stres</th>
                                <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">Hasil Prediksi</th>
                                <th class="relative px-6 py-3">
                                    <span class="sr-only">Detail</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($outcomeResults as $outcome)
                                @php
                                    $resultColorClass = 'text-gray-800';
                                    switch($outcome->predicted_outcome) {
                                        case 1: $resultColorClass = 'text-green-600'; break; // Improved
                                        case 0: $resultColorClass = 'text-red-600';    break;    // Deteriorated
                                        case 2: $resultColorClass = 'text-yellow-600'; break; // No Change
                                    }
                                @endphp
                                <tr>
                                    <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap">
                                        {{ \Carbon\Carbon::parse($outcome->timestamp)->format('d M Y') }}
                                        <div class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($outcome->timestamp)->format('H:i') }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap">
                                        {{ $diagnosisNameMap[$outcome->input_data['Diagnosis'] ?? 99] ?? 'N/A' }} {{-- Menggunakan diagnosisNameMap --}}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap">
                                        {{ $outcome->input_data['Stress Level (1-10)'] ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium {{ $resultColorClass }}">
                                        {{ $outcomeNameMap[$outcome->predicted_outcome] ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 text-sm font-medium text-right whitespace-nowrap">
                                        <a href="{{ route('outcome.show', $outcome->_id) }}" class="text-indigo-600 hover:text-indigo-900">Lihat Detail</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $outcomeResults->links() }}
                </div>
            @endif
        </div>

        {{-- Bagian Tautan ke Riwayat Diagnosis Awal (jika ingin) --}}
        <div class="p-6 mt-10 text-center rounded-lg shadow-md bg-blue-50">
            <h3 class="mb-3 text-xl font-semibold text-blue-800">Ingin melihat riwayat diagnosis awal Anda?</h3>
            <p class="mb-4 text-gray-700">Akses halaman yang hanya menampilkan riwayat diagnosis awal Anda.</p>
            <a href="{{ route('predictions.history') }}" 
               class="inline-flex items-center px-6 py-3 text-base font-medium text-white transition duration-200 ease-in-out bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                <i class="mr-2 fas fa-robot"></i> Kunjungi Halaman Diagnosis Awal
            </a>
        </div>
    </div>
@endsection

@push('scripts')
    {{-- Karena grafik sudah dihapus dari sini, script Chart.js mungkin tidak diperlukan di sini --}}
    {{-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> --}}
    <script>
        // Kode Chart.js yang sebelumnya ada di sini telah dihapus
        // karena Bagian Grafik Tren telah dihapus dari tampilan.
    </script>
@endpush