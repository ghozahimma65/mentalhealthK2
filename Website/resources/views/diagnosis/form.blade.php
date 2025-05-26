@extends('layouts.main') {{-- Menggunakan layout utama Anda --}}

@section('title', 'Kuesioner Diagnosis Kesehatan Mental') {{-- Judul halaman --}}

@push('styles')
<style>
    /* Mengatur warna background body secara global (jika belum di layouts.main) */
    body {
        font-family: 'Poppins', sans-serif;
        background-color: #F5F9FF; /* Sesuaikan dengan warna body dari layouts.main */
        color: #2C3E70;
    }
    .form-container-full { /* Mengubah nama kelas agar tidak bentrok dengan .container di layout utama */
        background-color: white;
        border-radius: 0.75rem; /* Sudut lebih melengkung */
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05); /* Bayangan lebih dalam */
        padding: 3rem; /* Padding lebih besar */
        max-width: 1000px; /* Lebar maksimum yang lebih besar */
        width: 100%;
        margin: 2.5rem auto; /* Margin atas/bawah */
    }
    /* Gaya untuk label dan input tetap, hanya beberapa penyesuaian di bawah */
    .form-label {
        display: block;
        font-weight: 600; /* Lebih tebal sedikit */
        margin-bottom: 0.6rem;
        color: #2C3E70;
        font-size: 1.05rem; /* Sedikit lebih besar */
    }
    .form-input, .form-select {
        width: 100%;
        padding: 0.9rem; /* Padding lebih besar */
        border: 1px solid #CBD5E0;
        border-radius: 0.375rem; /* Sudut lebih melengkung */
        box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.05); /* Bayangan inset */
        margin-bottom: 1.5rem; /* Jarak antar input lebih besar */
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
        padding: 0.9rem 2rem; /* Padding lebih besar */
        border-radius: 0.375rem;
        cursor: pointer;
        transition: background-color 0.3s ease-in-out, transform 0.2s ease-in-out; /* Transisi lebih halus */
        font-size: 1.1rem; /* Ukuran font lebih besar */
    }
    .submit-button:hover {
        background-color: #009688;
        transform: translateY(-2px); /* Efek angkat */
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
        display: inline-flex; /* Agar ikon bisa di tengah */
        align-items: center; /* Agar ikon dan teks sejajar */
        justify-content: center; /* Agar ikon dan teks di tengah */
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
    <div class="form-container-full"> {{-- Menggunakan kelas baru untuk kontainer form --}}
        <div class="mb-8 text-center">
            <img src="{{ asset('assets/logo.png') }}" alt="Logo Diagnosa" width="50" height="50" class="mx-auto mb-3">
            <h1 class="mb-2 text-4xl font-extrabold text-gray-800">Kuesioner Diagnosis Kesehatan Mental</h1>
            <p class="text-lg text-gray-600">Dapatkan diagnosis awal untuk memahami kondisi Anda.</p>
        </div>

        <form action="{{ route('diagnosis.submit') }}" method="POST" class="p-6 bg-white rounded-lg">
            @csrf
            <p class="mb-8 text-center text-gray-600">
                Silakan isi informasi di bawah ini untuk mendapatkan diagnosis awal. Data Anda akan dijaga kerahasiaannya.
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

            {{-- Pesan Error dari Controller (misal, Flask API gagal) --}}
            @if (session('error'))
                <div class="relative px-4 py-3 mb-4 text-red-700 bg-red-100 border border-red-400 rounded" role="alert">
                    <strong class="font-bold">Error!</strong>
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <div class="grid grid-cols-1 gap-y-6"> {{-- Menggunakan grid 1 kolom dan gap-y untuk jarak vertikal --}}
                <div class="mb-4">
                    <label for="age" class="form-label">1. Berapa usia Anda?</label>
                    <input type="number" id="age" name="age" class="form-input" value="{{ old('age') }}" required>
                </div>

                <div class="mb-4">
                    <label for="gender" class="form-label">2. Apa jenis kelamin Anda?</label>
                    <select id="gender" name="gender" class="form-select" required>
                        <option value="" disabled {{ old('gender') == '' ? 'selected' : '' }}>Pilih Jenis Kelamin Anda</option>
                        <option value="0" {{ old('gender') == '0' ? 'selected' : '' }}>Pria 👨</option>
                        <option value="1" {{ old('gender') == '1' ? 'selected' : '' }}>Wanita 👩</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label for="symptom_severity" class="form-label">3. Seberapa parah gejala yang Anda rasakan?</label>
                    <select id="symptom_severity" name="symptom_severity" class="form-select" required>
                        <option value="" disabled {{ old('symptom_severity') == '' ? 'selected' : '' }}>Pilih Tingkat Keparahan Gejala</option>
                        @for ($i = 1; $i <= 10; $i++)
                            <option value="{{ $i }}">{{ $i }} - {{ 
                                [1 => 'Sangat Ringan', 2 => 'Ringan', 3 => 'Sedang', 4 => 'Agak Berat', 
                                 5 => 'Berat', 6 => 'Sangat Berat', 7 => 'Ekstrem', 8 => 'Kritis', 
                                 9 => 'Sangat Kritis', 10 => 'Maksimal'][$i] 
                            }}</option>
                        @endfor
                    </select>
                </div>

                <div class="mb-4">
                    <label for="mood_score" class="form-label">4. Bagaimana suasana hati Anda dalam seminggu terakhir?</label>
                    <select id="mood_score" name="mood_score" class="form-select" required>
                        <option value="" disabled {{ old('mood_score') == '' ? 'selected' : '' }}>Pilih Suasana Hati Anda</option>
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
                </div>

                <div class="mb-4">
                    <label for="sleep_quality" class="form-label">5. Seberapa baik kualitas tidur Anda?</label>
                    <select id="sleep_quality" name="sleep_quality" class="form-select" required>
                        <option value="" disabled {{ old('sleep_quality') == '' ? 'selected' : '' }}>Pilih Kualitas Tidur Anda</option>
                        @for ($i = 1; $i <= 10; $i++)
                            <option value="{{ $i }}">{{ $i }} - {{ 
                                [1 => 'Sangat Buruk (Tidak Tidur Sama Sekali)', 2 => 'Buruk (Tidur Sangat Gelisah)', 
                                 3 => 'Agak Buruk (Sulit Tidur Nyenyak)', 4 => 'Cukup Buruk (Terbangun Berkali-kali)', 
                                 5 => 'Sedang (Tidur Biasa Saja)', 6 => 'Cukup Baik (Tidur Cukup Nyenyak)', 
                                 7 => 'Agak Baik (Tidur Pulas)', 8 => 'Baik (Tidur Sangat Nyenyak)', 
                                 9 => 'Sangat Baik (Tidur Berkualitas Tinggi)', 10 => 'Sangat Optimal (Tidur Sempurna dan Segar)'][$i] 
                            }}</option>
                        @endfor
                    </select>
                </div>

                <div class="mb-4">
                    <label for="physical_activity" class="form-label">6. Berapa sering Anda melakukan aktivitas fisik (olahraga)?</label>
                    <select id="physical_activity" name="physical_activity" class="form-select" required>
                        <option value="" disabled {{ old('physical_activity') == '' ? 'selected' : '' }}>Pilih Frekuensi Aktivitas Fisik Anda</option>
                        @for ($i = 1; $i <= 10; $i++)
                            <option value="{{ $i }}">{{ $i }} - {{ 
                                [1 => 'Sangat Jarang (Tidak Aktif)', 2 => 'Jarang (Sangat Sedikit Aktivitas)', 
                                 3 => 'Cukup (Aktivitas Ringan-Sedang)', 4 => 'Sering (Aktivitas Sedang-Tinggi)', 
                                 5 => 'Sangat Sering (Sangat Aktif)', 6 => 'Teratur (Aktivitas Terorganisir)', 
                                 7 => 'Aktif (Sering Berolahraga)', 8 => 'Sangat Aktif (Intensitas Tinggi)', 
                                 9 => 'Profesional (Latihan Ekstrem)', 10 => 'Atlet Elit (Aktivitas Maksimal)'][$i] 
                            }}</option>
                        @endfor
                    </select>
                </div>

                <div class="mb-4">
                    <label for="stress_level" class="form-label">7. Seberapa sering Anda merasa stres?</label>
                    <select id="stress_level" name="stress_level" class="form-select" required>
                        <option value="" disabled {{ old('stress_level') == '' ? 'selected' : '' }}>Pilih Tingkat Stres Anda</option>
                        @for ($i = 1; $i <= 10; $i++)
                            <option value="{{ $i }}">{{ $i }} - {{ 
                                [1 => 'Sangat Rendah (Tidak Stres)', 2 => 'Rendah', 3 => 'Sedang', 
                                 4 => 'Cukup Tinggi', 5 => 'Tinggi', 6 => 'Sangat Tinggi', 
                                 7 => 'Berlebihan', 8 => 'Kritis', 9 => 'Parah', 
                                 10 => 'Sangat Parah (Tidak Terkendali)'][$i] 
                            }}</option>
                        @endfor
                    </select>
                </div>

                <div class="mb-4">
                    <label for="ai_detected_emotional_state" class="form-label">8. Bagaimana Suasana Hati Anda Saat ini?</label>
                    <select id="ai_detected_emotional_state" name="ai_detected_emotional_state" class="form-select" required>
                        <option value="" disabled {{ old('ai_detected_emotional_state') == '' ? 'selected' : '' }}>Pilih Suasana Hati Saat Ini</option>
                        <option value="0" {{ old('ai_detected_emotional_state') == '0' ? 'selected' : '' }}>😟 Anxious (Cemas)</option>
                        <option value="1" {{ old('ai_detected_emotional_state') == '1' ? 'selected' : '' }}>😔 Depressed (Sedih)</option>
                        <option value="2" {{ old('ai_detected_emotional_state') == '2' ? 'selected' : '' }}>🤩 Excited (Gembira)</option>
                        <option value="3" {{ old('ai_detected_emotional_state') == '3' ? 'selected' : '' }}>😊 Happy (Senang)</option>
                        <option value="4" {{ old('ai_detected_emotional_state') == '4' ? 'selected' : '' }}>😐 Neutral (Netral)</option>
                        <option value="5" {{ old('ai_detected_emotional_state') == '5' ? 'selected' : '' }}>😥 Stressed (Stres)</option>
                    </select>
                </div>
            </div> {{-- Akhir grid --}}

            <div class="flex items-center justify-between mt-6">
                <a href="{{ route('landing') }}" class="back-button">
                    <i class="mr-2 fas fa-arrow-left"></i> Kembali
                </a>
                <button type="submit" class="submit-button">
                    Dapatkan Diagnosis <i class="ml-2 fas fa-robot"></i>
                </button>
            </div>
        </form>
    </div>
@endsection