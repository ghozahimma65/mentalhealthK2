@extends('layouts.main') {{-- Menggunakan layout utama Anda --}}

@section('title', 'Detail Perkembangan: ' . (\Carbon\Carbon::parse($outcome->timestamp)->format('d M Y')))

@section('content')
    <div class="container p-6 mx-auto lg:p-8">
        <h1 class="mb-6 text-3xl font-bold text-gray-800">Detail Perkembangan Pengobatan</h1>
        <p class="mb-8 text-gray-600">Informasi lengkap mengenai catatan perkembangan Anda pada {{ \Carbon\Carbon::parse($outcome->timestamp)->format('d M Y, H:i') }}.</p>

        @if (isset($outcome))
            <div class="p-8 mb-8 bg-white shadow-lg rounded-xl">
                <h2 class="mb-4 text-2xl font-bold text-gray-800">Hasil Klasifikasi:</h2>
                @php
                    $outcomeNameMap = [0 => 'Deteriorated', 1 => 'Improved', 2 => 'No Change'];
                    $resultColorClass = 'text-gray-800';
                    switch($outcome->predicted_outcome) {
                        case 1: $resultColorClass = 'text-green-600'; break; // Improved
                        case 0: $resultColorClass = 'text-red-600';    break;    // Deteriorated
                        case 2: $resultColorClass = 'text-yellow-600'; break; // No Change
                    }
                @endphp
                <p class="text-xl font-semibold mb-6 {{ $resultColorClass }}">
                    {{ $outcomeNameMap[$outcome->predicted_outcome] ?? 'N/A' }}
                </p>

                <h2 class="mt-8 mb-4 text-2xl font-bold text-gray-800">Data Input (Kuesioner):</h2>
                <div class="grid grid-cols-1 gap-4 text-gray-700 md:grid-cols-2">
                    @php
                        // Memastikan map diagnosis ada untuk display
                        $diagnosisNameMap = [
                            0 => 'Gangguan Bipolar', 1 => 'Gangguan Kecemasan Umum',
                            2 => 'Gangguan Depresi Mayor', 3 => 'Gangguan Panik',
                            99 => 'Lainnya / Tidak Tahu',
                        ];
                        // Field mapping from input_data to readable labels
                        $inputFieldMap = [
                            'Diagnosis' => 'Diagnosis Terakhir',
                            'Symptom Severity (1-10)' => 'Tingkat Gejala',
                            'Mood Score (1-10)' => 'Skor Mood',
                            'Physical Activity (hrs/week)' => 'Aktivitas Fisik (jam/minggu)',
                            'Medication' => 'Jenis Pengobatan',
                            'Therapy Type' => 'Jenis Terapi',
                            'Treatment Duration (weeks)' => 'Durasi Pengobatan (minggu)',
                            'Stress Level (1-10)' => 'Tingkat Stres',
                        ];
                        // Map untuk Medication dan Therapy Type jika diperlukan
                        $medicationMap = [
                            0 => 'Antidepresan', 1 => 'Antipsikotik', 2 => 'Benzodiazepin',
                            3 => 'Penstabil Mood', 4 => 'SSRIs', 5 => 'Anxiolitik', 99 => 'Tidak Ada'
                        ];
                        $therapyMap = [
                            0 => 'CBT', 1 => 'DBT', 2 => 'IPT', 3 => 'Mindfulness', 99 => 'Tidak Ada'
                        ];
                    @endphp
                    
                    @foreach ($outcome->input_data as $key => $value)
                        <div class="flex items-center">
                            <strong>{{ $inputFieldMap[$key] ?? $key }}:</strong> 
                            <span class="ml-2">
                                @if ($key == 'Diagnosis')
                                    {{ $diagnosisNameMap[$value] ?? 'N/A' }}
                                @elseif ($key == 'Medication')
                                    {{ $medicationMap[$value] ?? 'N/A' }}
                                @elseif ($key == 'Therapy Type')
                                    {{ $therapyMap[$value] ?? 'N/A' }}
                                @elseif ($key == 'Physical Activity (hrs/week)')
                                    {{ $value }} jam
                                @else
                                    {{ $value }}
                                @endif
                            </span>
                        </div>
                    @endforeach
                </div>

                <p class="mt-8 text-sm text-gray-700">
                    *Detail ini adalah catatan dari input yang Anda berikan saat mencatat perkembangan.
                </p>
            </div>

            {{-- Tombol Kembali --}}
            <div class="mt-8 text-center">
                <a href="{{ route('outcome.comprehensive_history') }}" class="inline-flex items-center px-6 py-3 text-base font-medium text-white transition duration-200 ease-in-out bg-gray-600 border border-transparent rounded-md shadow-sm hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                    <i class="mr-2 fas fa-arrow-left"></i> Kembali ke Riwayat Perkembangan
                </a>
            </div>
        @else
            <div class="relative px-4 py-3 mb-4 text-red-700 bg-red-100 border border-red-400 rounded" role="alert">
                <strong class="font-bold">Maaf!</strong>
                <span class="block sm:inline">Data perkembangan tidak ditemukan.</span>
            </div>
            <div class="mt-8 text-center">
                <a href="{{ route('outcome.comprehensive_history') }}" class="inline-flex items-center px-6 py-3 text-base font-medium text-white transition duration-200 ease-in-out bg-gray-600 border border-transparent rounded-md shadow-sm hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                    <i class="mr-2 fas fa-arrow-left"></i> Kembali ke Riwayat Perkembangan
                </a>
            </div>
        @endif
    </div>
@endsection