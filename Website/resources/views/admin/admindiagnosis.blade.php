@extends('admin.dashboard') {{-- Meng-extend layout dashboard.blade.php --}}

@section('title', 'Klasifikasi Diagnosis') {{-- Mengisi section 'title' di dashboard --}}

@section('header_title', 'Prediksi Diagnosis') {{-- Mengisi section 'header_title' di dashboard --}}

@section('content') {{-- Memulai section 'content' --}}
    <div class="container p-6 mx-auto bg-white rounded shadow-md">
        <h1 class="mb-4 text-2xl font-bold">Detail Pengguna & Inputan Gejala</h1>

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

        <div class="overflow-x-auto"> {{-- Tambahkan div ini untuk responsive tabel --}}
            <table class="min-w-full bg-white"> {{-- Gunakan min-w-full untuk memastikan tabel tidak meluap --}}
                <thead>
                    <tr>
                        <th class="px-4 py-2 text-xs font-semibold tracking-wider text-left text-gray-600 uppercase border-b border-gray-200 bg-gray-50">User</th>
                        <th class="px-4 py-2 text-xs font-semibold tracking-wider text-left text-gray-600 uppercase border-b border-gray-200 bg-gray-50">Waktu Pengajuan</th> {{-- Kolom baru --}}
                        <th class="px-4 py-2 text-xs font-semibold tracking-wider text-left text-gray-600 uppercase border-b border-gray-200 bg-gray-50">Inputan (Gejala)</th>
                        <th class="px-4 py-2 text-xs font-semibold tracking-wider text-left text-gray-600 uppercase border-b border-gray-200 bg-gray-50">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($diagnosisResults as $result)
                        <tr>
                            <td class="px-4 py-2 border-b border-gray-200">{{ $result->user->name ?? 'Pengguna Tidak Dikenal' }}</td>
                            <td class="px-4 py-2 border-b border-gray-200">{{ $result->timestamp->format('d M Y, H:i') }}</td> {{-- Menampilkan timestamp --}}
                            <td class="px-4 py-2 border-b border-gray-200">
                                @if ($result->input_data)
                                    <ul class="text-sm list-disc list-inside"> {{-- Menambah text-sm agar lebih ringkas --}}
                                        {{-- Iterasi melalui input_data dan panggil method helper untuk deskripsi --}}
                                        {{-- Perhatikan bahwa kunci di input_data (dari Flask) mungkin memiliki format yang sedikit berbeda --}}

                                        {{-- Untuk 'Age' --}}
                                        @if (isset($result->input_data['Age']))
                                            <li><strong>Age:</strong> {{ $result->input_data['Age'] }}</li>
                                        @endif
                                        
                                        {{-- Untuk 'Gender' --}}
                                        @if (isset($result->input_data['Gender']))
                                            <li><strong>Gender:</strong> {{ $result->getGenderDescription($result->input_data['Gender']) }}</li>
                                        @endif

                                        {{-- Untuk 'Symptom Severity (1-10)' --}}
                                        @if (isset($result->input_data['Symptom Severity (1-10)']))
                                            <li><strong>Symptom Severity:</strong> {{ $result->getSymptomSeverityDescription($result->input_data['Symptom Severity (1-10)']) }}</li>
                                        @endif

                                        {{-- Untuk 'Mood Score (1-10)' --}}
                                        @if (isset($result->input_data['Mood Score (1-10)']))
                                            <li><strong>Mood Score:</strong> {{ $result->getMoodScoreDescription($result->input_data['Mood Score (1-10)']) }}</li>
                                        @endif

                                        {{-- Untuk 'Sleep Quality (1-10)' --}}
                                        @if (isset($result->input_data['Sleep Quality (1-10)']))
                                            <li><strong>Sleep Quality:</strong> {{ $result->getSleepQualityDescription($result->input_data['Sleep Quality (1-10)']) }}</li>
                                        @endif

                                        {{-- Untuk 'Physical Activity (hrs/week)' --}}
                                        @if (isset($result->input_data['Physical Activity (hrs/week)']))
                                            <li><strong>Physical Activity:</strong> {{ $result->getPhysicalActivityDescription($result->input_data['Physical Activity (hrs/week)']) }}</li>
                                        @endif

                                        {{-- Untuk 'Stress Level (1-10)' --}}
                                        @if (isset($result->input_data['Stress Level (1-10)']))
                                            <li><strong>Stress Level:</strong> {{ $result->getStressLevelDescription($result->input_data['Stress Level (1-10)']) }}</li>
                                        @endif

                                        {{-- Untuk 'AI-Detected Emotional State' --}}
                                        @if (isset($result->input_data['AI-Detected Emotional State']))
                                            <li><strong>AI-Detected Emotional State:</strong> {{ $result->getAiDetectedEmotionalStateDescription($result->input_data['AI-Detected Emotional State']) }}</li>
                                        @endif

                                        {{-- Jika ada field lain yang tersimpan di input_data yang tidak memiliki metode khusus, tampilkan langsung --}}
                                        @foreach ($result->input_data as $key => $value)
                                            {{-- Lewati kunci yang sudah dihandle di atas untuk menghindari duplikasi --}}
                                            @if (!in_array($key, [
                                                'Age',
                                                'Gender',
                                                'Symptom Severity (1-10)',
                                                'Mood Score (1-10)',
                                                'Sleep Quality (1-10)',
                                                'Physical Activity (hrs/week)',
                                                'Stress Level (1-10)',
                                                'AI-Detected Emotional State'
                                            ]))
                                                <li><strong>{{ str_replace('_', ' ', ucfirst($key)) }}:</strong> {{ $value }}</li>
                                            @endif
                                        @endforeach
                                    </ul>
                                @else
                                    Tidak ada input data
                                @endif
                            </td>
                            <td class="px-4 py-2 border-b border-gray-200">
                                {{-- HANYA FOKUS PADA BAGIAN FORM ACTION --}}
                                <form action="{{ route('admin.diagnosis.prediksi', $result->_id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="px-4 py-2 text-sm font-bold text-white bg-blue-500 rounded action-button hover:bg-blue-600">Prediksi</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-2 text-center text-gray-500 border-b border-gray-200">Belum ada data diagnosis yang menunggu prediksi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div> {{-- End overflow-x-auto --}}
    </div>
@endsection {{-- Mengakhiri section 'content' --}}

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
        .action-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.5rem 1rem;
            font-size: 0.875rem; /* text-sm */
            font-weight: 700; /* font-bold */
            text-decoration: none;
            border-radius: 0.25rem; /* rounded */
            transition: all 0.2s ease-in-out;
            cursor: pointer;
        }
        .action-button:hover {
            opacity: 0.9;
            transform: translateY(-0.5px);
        }
    </style>
@endpush