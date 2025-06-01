@extends('admin.dashboard')

@section('title', 'Prediksi Outcome')
@section('header_title', 'Prediksi Outcome')

@section('content')
    <div class="container mx-auto bg-white p-6 rounded shadow-md">
        <h1 class="text-2xl font-bold mb-4">Detail Pengguna & Inputan Outcome</h1>

        @if (session('success'))
            <div class="alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert-error">
                {{ session('error') }}
            </div>
        @endif

        @if ($outcomeResults->isEmpty())
            <p class="text-gray-600 text-center">Tidak ada data outcome yang menunggu untuk diprediksi.</p>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white">
                    <thead>
                        <tr>
                            <th class="py-2 px-4 border-b border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">USER</th>
                            <th class="py-2 px-4 border-b border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">WAKTU PENGAJUAN</th>
                            <th class="py-2 px-4 border-b border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">INPUTAN (OUTCOME)</th>
                            <th class="py-2 px-4 border-b border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($outcomeResults as $outcome)
                            <tr>
                                <td class="py-2 px-4 border-b border-gray-200">{{ $outcome->user ? $outcome->user->name : 'Pengguna Tidak Dikenal' }}</td>
                                <td class="py-2 px-4 border-b border-gray-200">{{ $outcome->timestamp ? $outcome->timestamp->format('d M Y, H:i') : '-' }}</td>
                                <td class="py-2 px-4 border-b border-gray-200">
                                    <ul class="list-disc pl-5 text-sm">
                                        {{-- Untuk 'user_id' (jika Anda ingin menampilkan ini dari input_data) --}}
                                        @if (isset($outcome->input_data['user_id']))
                                            <li><strong>ID Pengguna Input:</strong> {{ $outcome->input_data['user_id'] }}</li>
                                        @endif

                                        {{-- Perbaikan: Sesuaikan nama kunci dengan yang ada di MongoDB --}}

                                        {{-- Untuk 'Diagnosis' --}}
                                        @if (isset($outcome->input_data['Diagnosis']))
                                            <li><strong>Diagnosis Awal:</strong> {{ $outcome->getDiagnosisDescription($outcome->input_data['Diagnosis']) }}</li>
                                        @endif
                                        
                                        {{-- Untuk 'Symptom Severity (1-10)' --}}
                                        @if (isset($outcome->input_data['Symptom Severity (1-10)']))
                                            <li><strong>Tingkat Keparahan Gejala:</strong> {{ $outcome->getSymptomSeverityDescription($outcome->input_data['Symptom Severity (1-10)']) }}</li>
                                        @endif

                                        {{-- Untuk 'Mood Score (1-10)' --}}
                                        @if (isset($outcome->input_data['Mood Score (1-10)']))
                                            <li><strong>Skor Suasana Hati:</strong> {{ $outcome->getMoodScoreDescription($outcome->input_data['Mood Score (1-10)']) }}</li>
                                        @endif

                                        {{-- Untuk 'Physical Activity (hrs/week)' --}}
                                        @if (isset($outcome->input_data['Physical Activity (hrs/week)']))
                                            <li><strong>Aktivitas Fisik:</strong> {{ $outcome->getPhysicalActivityDescription($outcome->input_data['Physical Activity (hrs/week)']) }}</li>
                                        @endif

                                        {{-- Untuk 'Medication' --}}
                                        @if (isset($outcome->input_data['Medication']))
                                            <li><strong>Pengobatan:</strong> {{ $outcome->getMedicationDescription($outcome->input_data['Medication']) }}</li>
                                        @endif

                                        {{-- Untuk 'Therapy Type' --}}
                                        @if (isset($outcome->input_data['Therapy Type']))
                                            <li><strong>Jenis Terapi:</strong> {{ $outcome->getTherapyTypeDescription($outcome->input_data['Therapy Type']) }}</li>
                                        @endif

                                        {{-- Untuk 'Treatment Duration (weeks)' --}}
                                        @if (isset($outcome->input_data['Treatment Duration (weeks)']))
                                            <li><strong>Durasi Pengobatan:</strong> {{ $outcome->getTreatmentDurationDescription($outcome->input_data['Treatment Duration (weeks)']) }}</li>
                                        @endif

                                        {{-- Untuk 'Stress Level (1-10)' --}}
                                        @if (isset($outcome->input_data['Stress Level (1-10)']))
                                            <li><strong>Tingkat Stres:</strong> {{ $outcome->getStressLevelDescription($outcome->input_data['Stress Level (1-10)']) }}</li>
                                        @endif

                                        {{-- Jika ada field lain yang tersimpan di input_data yang tidak memiliki metode khusus, tampilkan langsung --}}
                                        @foreach ($outcome->input_data as $key => $value)
                                            {{-- Lewati kunci yang sudah dihandle di atas untuk menghindari duplikasi --}}
                                            @if (!in_array($key, [
                                                'user_id', 'Diagnosis', 'Symptom Severity (1-10)', 'Mood Score (1-10)',
                                                'Physical Activity (hrs/week)', 'Medication', 'Therapy Type',
                                                'Treatment Duration (weeks)', 'Stress Level (1-10)'
                                            ]))
                                                <li><strong>{{ str_replace('_', ' ', ucfirst($key)) }}:</strong> {{ $value }}</li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </td>
                                <td class="py-2 px-4 border-b border-gray-200">
                                    <form action="{{ route('admin.outcome.prediksi', $outcome->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded text-sm">Prediksi</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection

@push('styles')
    <style>
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
        }
        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
        }
        /* Tambahkan gaya khusus tabel jika diperlukan */
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            text-align: left;
            padding: 8px;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
@endpush