@extends('layouts.main') {{-- Menggunakan layout utama Anda --}}

@section('title', 'Detail Diagnosis: ' . ($diagnosisResult->predicted_diagnosis ? ($diagnosisNameMap[$diagnosisResult->predicted_diagnosis] ?? 'Tidak Diketahui') : 'N/A'))

@section('content')
    <div class="container p-6 mx-auto lg:p-8">
        <h1 class="mb-6 text-3xl font-bold text-gray-800">Detail Diagnosis Anda</h1>
        <p class="mb-8 text-gray-600">Informasi lengkap mengenai diagnosis awal yang Anda lakukan pada {{ \Carbon\Carbon::parse($diagnosisResult->timestamp)->format('d M Y, H:i') }}.</p>

        <div class="p-8 mb-8 bg-white shadow-lg rounded-xl">
            <h2 class="mb-4 text-2xl font-bold text-gray-800">Hasil Prediksi:</h2>
            <p class="mb-6 text-xl font-semibold">
                <span class="
                    @php
                        $resultColorClass = 'text-gray-800';
                        switch($diagnosisResult->predicted_diagnosis) {
                            case 0: $resultColorClass = 'text-purple-600'; break; // Bipolar
                            case 1: $resultColorClass = 'text-orange-600'; break; // Kecemasan
                            case 2: $resultColorClass = 'text-red-600'; break;    // Depresi
                            case 3: $resultColorClass = 'text-yellow-600'; break; // Panik
                        }
                    @endphp
                    {{ $resultColorClass }}
                ">
                    {{ $diagnosisNameMap[$diagnosisResult->predicted_diagnosis] ?? 'Tidak Diketahui' }}
                </span>
            </p>

            <h2 class="mt-8 mb-4 text-2xl font-bold text-gray-800">Data Input:</h2>
            <div class="grid grid-cols-1 gap-4 text-gray-700 md:grid-cols-2">
                <div class="flex items-center">
                    <i class="mr-2 text-blue-500 fas fa-user"></i>
                    <strong>Usia:</strong> {{ $diagnosisResult->input_data['Age'] ?? 'N/A' }}
                </div>
                <div class="flex items-center">
                    <i class="mr-2 text-pink-500 fas fa-venus-mars"></i>
                    <strong>Jenis Kelamin:</strong> {{ ($diagnosisResult->input_data['Gender'] ?? null) == 0 ? 'Pria' : 'Wanita' }}
                </div>
                <div class="flex items-center">
                    <i class="mr-2 text-red-500 fas fa-thermometer-half"></i>
                    <strong>Tingkat Gejala:</strong> {{ $diagnosisResult->input_data['Symptom Severity (1-10)'] ?? 'N/A' }}
                </div>
                <div class="flex items-center">
                    <i class="mr-2 text-yellow-500 fas fa-smile-beam"></i>
                    <strong>Skor Mood:</strong> {{ $diagnosisResult->input_data['Mood Score (1-10)'] ?? 'N/A' }}
                </div>
                <div class="flex items-center">
                    <i class="mr-2 text-purple-500 fas fa-bed"></i>
                    <strong>Kualitas Tidur:</strong> {{ $diagnosisResult->input_data['Sleep Quality (1-10)'] ?? 'N/A' }}
                </div>
                <div class="flex items-center">
                    <i class="mr-2 text-green-500 fas fa-running"></i>
                    <strong>Aktivitas Fisik:</strong> {{ $diagnosisResult->input_data['Physical Activity (hrs/week)'] ?? 'N/A' }} jam/minggu
                </div>
                <div class="flex items-center">
                    <i class="mr-2 text-gray-500 fas fa-frown-open"></i>
                    <strong>Tingkat Stres:</strong> {{ $diagnosisResult->input_data['Stress Level (1-10)'] ?? 'N/A' }}
                </div>
                <div class="flex items-center">
                    <i class="mr-2 text-indigo-500 fas fa-brain"></i>
                    <strong>Emosi AI Terdeteksi:</strong> {{ $diagnosisResult->input_data['AI-Detected Emotional State'] ?? 'N/A' }}
                </div>
            </div>

            <p class="mt-8 text-sm text-gray-700">
                *Detail ini adalah catatan dari input yang Anda berikan saat melakukan diagnosis.
            </p>
        </div>

        {{-- Tombol Kembali --}}
        <div class="mt-8 text-center">
            <a href="{{ route('predictions.history') }}" class="inline-flex items-center px-6 py-3 text-base font-medium text-white transition duration-200 ease-in-out bg-gray-600 border border-transparent rounded-md shadow-sm hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                <i class="mr-2 fas fa-arrow-left"></i> Kembali ke Riwayat Diagnosis
            </a>
        </div>
    </div>
@endsection