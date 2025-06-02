@extends('admin.dashboard') {{-- Pastikan ini meng-extend layout dashboard admin Anda --}}

@section('title', 'Klasifikasi Outcome')
@section('header_title', 'Klasifikasi Outcome')

@section('content')
    <div class="container p-6 mx-auto bg-white rounded shadow-md">
        <h1 class="mb-4 text-2xl font-bold">Detail Pengguna & Inputan Outcome</h1>

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
            <p class="text-center text-gray-600">Tidak ada data outcome yang menunggu untuk diklasifikasi.</p>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 text-xs font-semibold tracking-wider text-left text-gray-600 uppercase bg-gray-100 border-b border-gray-200">USER</th>
                            <th class="px-4 py-2 text-xs font-semibold tracking-wider text-left text-gray-600 uppercase bg-gray-100 border-b border-gray-200">WAKTU PENGAJUAN</th>
                            <th class="px-4 py-2 text-xs font-semibold tracking-wider text-left text-gray-600 uppercase bg-gray-100 border-b border-gray-200">INPUTAN (OUTCOME)</th>
                            <th class="px-4 py-2 text-xs font-semibold tracking-wider text-left text-gray-600 uppercase bg-gray-100 border-b border-gray-200">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($outcomeResults as $outcome)
                            <tr>
                                <td class="px-4 py-2 border-b border-gray-200">{{ $outcome->user ? $outcome->user->name : 'Pengguna Tidak Dikenal' }}</td>
                                <td class="px-4 py-2 border-b border-gray-200">{{ $outcome->timestamp ? $outcome->timestamp->format('d M Y, H:i') : '-' }}</td>
                                <td class="px-4 py-2 border-b border-gray-200">
                                    <ul class="pl-5 text-sm list-disc"> {{-- Menambah text-sm agar lebih ringkas --}}
                                        {{-- Iterasi melalui input_data dan panggil method helper untuk deskripsi --}}
                                        {{-- Perhatikan bahwa kunci di input_data (dari Flask) mungkin memiliki format yang sedikit berbeda --}}

                                        {{-- Untuk 'user_id' (jika Anda ingin menampilkan ini dari input_data) --}}
                                        @if (isset($outcome->input_data['user_id']))
                                            <li><strong>ID Pengguna Input:</strong> {{ $outcome->input_data['user_id'] }}</li>
                                        @endif

                                        {{-- Untuk 'diagnosis' --}}
                                        @if (isset($outcome->input_data['diagnosis']))
                                            <li><strong>Diagnosis Awal:</strong> {{ $outcome->getDiagnosisDescription($outcome->input_data['diagnosis']) }}</li>
                                        @endif
                                        
                                        {{-- Untuk 'symptom_severity' --}}
                                        @if (isset($outcome->input_data['symptom_severity']))
                                            <li><strong>Tingkat Keparahan Gejala:</strong> {{ $outcome->getSymptomSeverityDescription($outcome->input_data['symptom_severity']) }}</li>
                                        @endif

                                        {{-- Untuk 'mood_score' --}}
                                        @if (isset($outcome->input_data['mood_score']))
                                            <li><strong>Skor Suasana Hati:</strong> {{ $outcome->getMoodScoreDescription($outcome->input_data['mood_score']) }}</li>
                                        @endif

                                        {{-- Untuk 'physical_activity' --}}
                                        @if (isset($outcome->input_data['physical_activity']))
                                            <li><strong>Aktivitas Fisik:</strong> {{ $outcome->getPhysicalActivityDescription($outcome->input_data['physical_activity']) }}</li>
                                        @endif

                                        {{-- Untuk 'medication' --}}
                                        @if (isset($outcome->input_data['medication']))
                                            <li><strong>Pengobatan:</strong> {{ $outcome->getMedicationDescription($outcome->input_data['medication']) }}</li>
                                        @endif

                                        {{-- Untuk 'therapy_type' --}}
                                        @if (isset($outcome->input_data['therapy_type']))
                                            <li><strong>Jenis Terapi:</strong> {{ $outcome->getTherapyTypeDescription($outcome->input_data['therapy_type']) }}</li>
                                        @endif

                                        {{-- Untuk 'treatment_duration' --}}
                                        @if (isset($outcome->input_data['treatment_duration']))
                                            <li><strong>Durasi Pengobatan:</strong> {{ $outcome->getTreatmentDurationDescription($outcome->input_data['treatment_duration']) }}</li>
                                        @endif

                                        {{-- Untuk 'stress_level' --}}
                                        @if (isset($outcome->input_data['stress_level']))
                                            <li><strong>Tingkat Stres:</strong> {{ $outcome->getStressLevelDescription($outcome->input_data['stress_level']) }}</li>
                                        @endif

                                        {{-- Jika ada field lain yang tersimpan di input_data yang tidak memiliki metode khusus, tampilkan langsung --}}
                                        @foreach ($outcome->input_data as $key => $value)
                                            {{-- Lewati kunci yang sudah dihandle di atas untuk menghindari duplikasi --}}
                                            @if (!in_array($key, [
                                                'user_id', 'diagnosis', 'symptom_severity', 'mood_score',
                                                'physical_activity', 'medication', 'therapy_type',
                                                'treatment_duration', 'stress_level',
                                            ]))
                                                <li><strong>{{ str_replace('_', ' ', ucfirst($key)) }}:</strong> {{ $value }}</li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </td>
                                <td class="px-4 py-2 border-b border-gray-200">
                                    <form action="{{ route('admin.outcome.prediksi', $outcome->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="px-3 py-1 text-sm font-bold text-white bg-blue-500 rounded hover:bg-blue-700">Klasifikasi</button>
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