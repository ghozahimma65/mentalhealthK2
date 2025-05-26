@extends('layouts.main') {{-- Menggunakan layout utama Anda --}}

@section('title', 'Kuesioner Perkembangan Kesehatan Mental') {{-- Judul halaman --}}

@push('styles')
<style>
    /* Menggunakan kembali beberapa gaya dari kuesioner diagnosis jika sesuai */
    body {
        font-family: 'Poppins', sans-serif;
        background-color: #EDF6F9;
        color: #2C3E70;
    }
    .form-container-full {
        background-color: white;
        border-radius: 0.75rem;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        padding: 3rem;
        max-width: 1000px;
        width: 100%;
        margin: 2.5rem auto;
    }
    .form-label {
        display: block;
        font-weight: 600;
        margin-bottom: 0.6rem;
        color: #2C3E70;
        font-size: 1.05rem;
    }
    .form-input, .form-select {
        width: 100%;
        padding: 0.9rem;
        border: 1px solid #CBD5E0;
        border-radius: 0.375rem;
        box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.05);
        margin-bottom: 1.5rem;
        color: #4A5568;
    }
    .form-select option {
        color: #4A5568;
    }
    /* Gaya untuk opsi select agar ke bawah */
    .form-select option {
        padding: 0.5rem 0.75rem; /* Tambahkan padding agar lebih mudah diklik */
        display: block; /* Pastikan setiap option berada di baris baru jika perlu */
        white-space: normal; /* Izinkan teks melengkung jika terlalu panjang */
    }

    .submit-button {
        background-color: #80CBC4;
        color: white;
        font-weight: bold;
        padding: 0.9rem 2rem;
        border-radius: 0.375rem;
        cursor: pointer;
        transition: background-color 0.3s ease-in-out, transform 0.2s ease-in-out;
        font-size: 1.1rem;
    }
    .submit-button:hover {
        background-color: #009688;
        transform: translateY(-2px);
    }
    .back-button {
        background-color: #6B7280;
        color: white;
        font-weight: bold;
        padding: 0.9rem 2rem;
        border-radius: 0.375rem;
        cursor: pointer;
        transition: background-color 0.3s ease-in-out, transform 0.2s ease-in-out;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
    }
    .back-button:hover {
        background-color: #4B5563;
        transform: translateY(-2px);
    }
    .text-teal-400 {
        color: #80CBC4;
    }
</style>
@endpush

@section('content') {{-- Memulai bagian konten utama halaman --}}
    <div class="form-container-full">
        <div class="mb-8 text-center">
            <img src="{{ asset('assets/logo.png') }}" alt="Logo Diagnosa" width="50" height="50" class="mx-auto mb-3">
            <h1 class="mb-2 text-4xl font-extrabold text-gray-800">Kuesioner Perkembangan Pengobatan</h1>
            <p class="text-lg text-gray-600">Lacak progres Anda menuju kesejahteraan mental.</p>
        </div>

        <form action="{{ route('outcome.store') }}" method="POST" class="p-6 bg-white rounded-lg">
            @csrf
            <p class="mb-8 text-center text-gray-600">
                Isi kuesioner ini secara berkala untuk memantau progres Anda dan mendapatkan prediksi perkembangan.
            </p>
            
            {{-- Pesan Error Validasi dari Laravel --}}
            @if ($errors->any())
                <div class="relative px-4 py-3 mb-4 text-red-700 bg-red-100 border border-red-400 rounded" role="alert">
                    <strong class="font-bold">Oops!</strong>
                    <span class="block sm:inline">Ada beberapa masalah dengan input Anda:</span>
                    <ul class="mt-2 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Pesan Error dari Controller --}}
            @if (session('error'))
                <div class="relative px-4 py-3 mb-4 text-red-700 bg-red-100 border border-red-400 rounded" role="alert">
                    <strong class="font-bold">Error!</strong>
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            {{-- Mengubah struktur menjadi setiap input di baris penuh --}}
            <div class="grid grid-cols-1 gap-y-6"> {{-- Menggunakan grid 1 kolom dan gap-y untuk jarak vertikal --}}
                <div class="mb-4">
                    <label for="diagnosis" class="form-label">1. Diagnosis terakhir Anda?</label>
                    <select id="diagnosis" name="diagnosis" class="form-select" required>
                        <option value="" disabled selected>Pilih Diagnosis Anda</option>
                        <option value="0">Gangguan Bipolar</option>
                        <option value="1">Gangguan Kecemasan Umum</option>
                        <option value="2">Gangguan Depresi Mayor</option>
                        <option value="3">Gangguan Panik</option>
                        <option value="99">Lainnya / Tidak Tahu</option>
                    </select>
                    <p class="mt-1 text-sm text-gray-600">Pilih diagnosis yang Anda ketahui atau telah didapatkan sebelumnya.</p>
                </div>

                <div class="mb-4">
                    <label for="symptom_severity" class="form-label">2. Seberapa parah gejala yang Anda rasakan saat ini?</label>
                    <select id="symptom_severity" name="symptom_severity" class="form-select" required>
                        <option value="" disabled selected>Pilih Tingkat Keparahan Gejala</option>
                        @for ($i = 1; $i <= 10; $i++)
                            <option value="{{ $i }}">{{ $i }} - {{ 
                                [1 => 'Sangat Ringan', 2 => 'Ringan', 3 => 'Sedang', 4 => 'Agak Berat', 
                                 5 => 'Berat', 6 => 'Sangat Berat', 7 => 'Ekstrem', 8 => 'Kritis', 
                                 9 => 'Sangat Kritis', 10 => 'Maksimal'][$i] 
                            }}</option>
                        @endfor
                    </select>
                    <p class="mt-1 text-sm text-gray-600">Nilai 1 (sangat ringan) hingga 10 (maksimal).</p>
                </div>

                <div class="mb-4">
                    <label for="mood_score" class="form-label">3. Bagaimana suasana hati Anda dalam seminggu terakhir?</label>
                    <select id="mood_score" name="mood_score" class="form-select" required>
                        <option value="" disabled selected>Pilih Suasana Hati Anda</option>
                        @for ($i = 1; $i <= 10; $i++)
                            <option value="{{ $i }}">{{ $i }} - {{ 
                                [1 => 'Sangat Buruk (Depresi/Sedih)', 2 => 'Buruk (Cemas/Resah)', 
                                 3 => 'Agak Buruk (Kurang Bersemangat)', 4 => 'Cukup Netral (Biasa Saja)', 
                                 5 => 'Netral (Stabil)', 6 => 'Agak Baik (Cukup Bersemangat)', 
                                 7 => 'Baik (Senang)', 8 => 'Sangat Baik (Gembira/Optimis)', 
                                 9 => 'Luar Biasa (Bahagia/Antusias)', 10 => 'Maksimal (Euforia/Penuh Energi)'][$i] 
                            }}</option>
                        @endfor
                    </select>
                    <p class="mt-1 text-sm text-gray-600">Nilai 1 (sangat buruk) hingga 10 (sangat baik).</p>
                </div>

                <div class="mb-4">
                    <label for="physical_activity" class="form-label">4. Rata-rata aktivitas fisik Anda per minggu (jam)?</label>
                    <input type="number" id="physical_activity" name="physical_activity" step="0.5" min="0" max="168" class="form-input" required>
                    <p class="mt-1 text-sm text-gray-600">Masukkan rata-rata jam aktivitas fisik/olahraga per minggu (misal: 3.5 jam).</p>
                </div>
                
                <div class="mb-4">
                    <label for="medication" class="form-label">5. Jenis pengobatan/obat yang sedang Anda gunakan?</label>
                    <select id="medication" name="medication" class="form-select" required>
                        <option value="" disabled selected>Pilih Jenis Pengobatan</option>
                        <option value="0">Antidepressants (Antidepresan)</option>
                        <option value="1">Antipsychotics (Antipsikotik)</option>
                        <option value="2">Benzodiazepines (Benzodiazepin)</option>
                        <option value="3">Mood Stabilizers (Penstabil Suasana Hati)</option>
                        <option value="4">SSRIs (Selective Serotonin Reuptake Inhibitors)</option>
                        <option value="5">Anxiolytics (Anxiolitik/Anti-kecemasan)</option>
                        <option value="99">Tidak sedang mengonsumsi obat</option>
                    </select>
                    <p class="mt-1 text-sm text-gray-600">Pilih jenis obat yang sedang Anda gunakan. Jika tidak ada, pilih opsi terakhir.</p>
                </div>

                <div class="mb-4">
                    <label for="therapy_type" class="form-label">6. Jenis terapi yang sedang Anda jalani?</label>
                    <select id="therapy_type" name="therapy_type" class="form-select" required>
                        <option value="" disabled selected>Pilih Jenis Terapi</option>
                        <option value="0">Cognitive Behavioral Therapy (CBT)</option>
                        <option value="1">Dialectical Behavioral Therapy (DBT)</option>
                        <option value="2">Interpersonal Therapy (IPT)</option>
                        <option value="3">Mindfulness-Based Therapy (Terapi Berbasis Kesadaran)</option>
                        <option value="99">Tidak sedang menjalani terapi</option>
                    </select>
                    <p class="mt-1 text-sm text-gray-600">Pilih jenis terapi yang sedang Anda jalani. Jika tidak ada, pilih opsi terakhir.</p>
                </div>

                <div class="mb-4">
                    <label for="treatment_duration" class="form-label">7. Berapa lama Anda sudah menjalani pengobatan/terapi (dalam minggu)?</label>
                    <input type="number" id="treatment_duration" name="treatment_duration" min="0" max="500" class="form-input" required>
                    <p class="mt-1 text-sm text-gray-600">Masukkan durasi total pengobatan atau terapi Anda dalam minggu (misal: 12 minggu).</p>
                </div>

                <div class="mb-4">
                    <label for="stress_level" class="form-label">8. Seberapa sering Anda merasa stres dalam seminggu terakhir?</label>
                    <select id="stress_level" name="stress_level" class="form-select" required>
                        <option value="" disabled selected>Pilih Tingkat Stres Anda</option>
                        @for ($i = 1; $i <= 10; $i++)
                            <option value="{{ $i }}">{{ $i }} - {{ 
                                [1 => 'Sangat Rendah (Tidak Stres)', 2 => 'Rendah', 3 => 'Sedang', 
                                 4 => 'Cukup Tinggi', 5 => 'Tinggi', 6 => 'Sangat Tinggi', 
                                 7 => 'Berlebihan', 8 => 'Kritis', 9 => 'Parah', 
                                 10 => 'Sangat Parah (Tidak Terkendali)'][$i] 
                            }}</option>
                        @endfor
                    </select>
                    <p class="mt-1 text-sm text-gray-600">Nilai 1 (sangat rendah) hingga 10 (sangat parah).</p>
                </div>
            </div> {{-- Akhir grid --}}

            <div class="flex items-center justify-between mt-6">
                {{-- Tombol kembali bisa disesuaikan, misalnya ke dashboard --}}
                <a href="{{ route('dashboard') }}" class="back-button">
                    <i class="mr-2 fas fa-arrow-left"></i> Kembali ke Dashboard
                </a>
                <button type="submit" class="submit-button">
                    Dapatkan Prediksi Perkembangan <i class="ml-2 fas fa-chart-line"></i>
                </button>
            </div>
        </form>
    </div>
@endsection