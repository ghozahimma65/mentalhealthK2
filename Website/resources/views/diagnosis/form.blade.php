@extends('layouts.main') {{-- Menggunakan layout utama aplikasi Anda --}}

@section('title', 'Kuesioner Kesehatan Mental') {{-- Mengatur judul halaman --}}

@push('styles')
{{-- Memindahkan CSS kustom dari sini, agar dimuat oleh layouts.main --}}
<style>
    /* Styling for body (min-height, display, justify-content, align-items, margin) 
       should ideally be handled by layouts.main's body or a wrapper div */
    body {
        font-family: 'Poppins', sans-serif;
        background-color: #EDF6F9;
        color: #2C3E70;
    }
    .container-form { /* Mengubah nama kelas agar tidak bentrok dengan .container di layout utama */
        background-color: white;
        border-radius: 0.5rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        padding: 2rem;
        max-width: 800px; /* Sesuaikan dengan .max-w-2xl dari kode Anda */
        width: 100%;
        margin: 2rem auto; /* Tambahkan margin atas/bawah agar tidak terlalu mepet header/footer */
    }
    .form-label {
        display: block;
        font-weight: bold;
        margin-bottom: 0.5rem;
        color: #2C3E70;
    }
    .form-input, .form-select {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid #CBD5E0;
        border-radius: 0.25rem;
        box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        margin-bottom: 1rem;
        color: #4A5568;
    }
    .form-select option {
        color: #4A5568;
    }
    .radio-group {
        display: flex;
        align-items: center;
        margin-bottom: 1rem;
    }
    .radio-group label {
        margin-right: 1.5rem;
        color: #4A5568;
    }
    .radio-group input[type="radio"] {
        margin-right: 0.5rem;
    }
    .submit-button {
        background-color: #80CBC4;
        color: white;
        font-weight: bold;
        padding: 0.75rem 1.5rem;
        border-radius: 0.25rem;
        cursor: pointer;
        transition: background-color 0.2s ease-in-out;
    }
    .submit-button:hover {
        background-color: #009688;
    }
    .back-button { /* Styling untuk tombol kembali */
        background-color: #6B7280;
        color: white;
        font-weight: bold;
        padding: 0.75rem 1.5rem;
        border-radius: 0.25rem;
        cursor: pointer;
        transition: background-color 0.2s ease-in-out;
        text-decoration: none; /* Hilangkan underline default */
        display: inline-block;
    }
    .back-button:hover {
        background-color: #4B5563;
    }
    /* Mengubah .text-[#80CBC4] menjadi kelas Tailwind */
    .text-teal-400 { /* Contoh warna Teal-400 */
        color: #80CBC4;
    }

    /* Overrides untuk Tailwind CSS jika Anda punya konflik, atau jika ingin menyesuaikan */
    /* .text-2xl { font-size: 1.5rem; line-height: 2rem; } */
    /* ... dst untuk kelas Tailwind lainnya ... */
</style>
@endpush

@section('content') {{-- Konten utama halaman ini --}}
    <div class="container-form"> {{-- Menggunakan kelas baru untuk menghindari konflik --}}
        <h1 class="mb-6 text-2xl font-bold text-center text-teal-400">Kuesioner Kesehatan Mental</h1>

        <form action="{{ route('diagnosis.submit') }}" method="POST" class="max-w-lg p-6 mx-auto bg-white rounded-lg shadow-md">
            @csrf
            {{-- Mengubah struktur body/div agar tidak bersarang dan hanya menyisakan form --}}
            <h1 class="mb-6 text-3xl font-bold text-center text-gray-800">Kuesioner Diagnosis Kesehatan Mental</h1>
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
                    <option value="1" {{ old('symptom_severity') == '1' ? 'selected' : '' }}>1-Sangat Ringan</option>
                    <option value="2" {{ old('symptom_severity') == '2' ? 'selected' : '' }}>2-Ringan</option>
                    <option value="3" {{ old('symptom_severity') == '3' ? 'selected' : '' }}>3-Sedang</option>
                    <option value="4" {{ old('symptom_severity') == '4' ? 'selected' : '' }}>4-Agak Berat</option>
                    <option value="5" {{ old('symptom_severity') == '5' ? 'selected' : '' }}>5-Berat</option>
                    <option value="6" {{ old('symptom_severity') == '6' ? 'selected' : '' }}>6-Sangat Berat</option>
                    <option value="7" {{ old('symptom_severity') == '7' ? 'selected' : '' }}>7-Ekstrem</option>
                    <option value="8" {{ old('symptom_severity') == '8' ? 'selected' : '' }}>8-Kritis</option>
                    <option value="9" {{ old('symptom_severity') == '9' ? 'selected' : '' }}>9-Sangat Kritis</option>
                    <option value="10" {{ old('symptom_severity') == '10' ? 'selected' : '' }}>10-Maksimal</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="mood_score" class="form-label">4. Bagaimana suasana hati Anda dalam seminggu terakhir?</label>
                <select id="mood_score" name="mood_score" class="form-select" required>
                    <option value="" disabled {{ old('mood_score') == '' ? 'selected' : '' }}>Pilih Suasana Hati Anda</option>
                    <option value="1" {{ old('mood_score') == '1' ? 'selected' : '' }}>1-Sangat Buruk (Depresi/Sedih)</option>
                    <option value="2" {{ old('mood_score') == '2' ? 'selected' : '' }}>2-Buruk (Cemas/Resah)</option>
                    <option value="3" {{ old('mood_score') == '3' ? 'selected' : '' }}>3-Agak Buruk (Kurang Bersemangat)</option>
                    <option value="4" {{ old('mood_score') == '4' ? 'selected' : '' }}>4-Cukup Netral (Biasa Saja)</option>
                    <option value="5" {{ old('mood_score') == '5' ? 'selected' : '' }}>5-Netral (Stabil)</option>
                    <option value="6" {{ old('mood_score') == '6' ? 'selected' : '' }}>6-Agak Baik (Cukup Bersemangat)</option>
                    <option value="7" {{ old('mood_score') == '7' ? 'selected' : '' }}>7-Baik (Senang)</option>
                    <option value="8" {{ old('mood_score') == '8' ? 'selected' : '' }}>8-Sangat Baik (Gembira/Optimis)</option>
                    <option value="9" {{ old('mood_score') == '9' ? 'selected' : '' }}>9-Luar Biasa (Bahagia/Antusias)</option>
                    <option value="10" {{ old('mood_score') == '10' ? 'selected' : '' }}>10-Maksimal (Euforia/Penuh Energi)</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="sleep_quality" class="form-label">5. Seberapa baik kualitas tidur Anda?</label>
                <select id="sleep_quality" name="sleep_quality" class="form-select" required>
                    <option value="" disabled {{ old('sleep_quality') == '' ? 'selected' : '' }}>Pilih Kualitas Tidur Anda</option>
                    <option value="1" {{ old('sleep_quality') == '1' ? 'selected' : '' }}>1-Sangat Buruk (Tidak Tidur Sama Sekali)</option>
                    <option value="2" {{ old('sleep_quality') == '2' ? 'selected' : '' }}>2-Buruk (Tidur Sangat Gelisah)</option>
                    <option value="3" {{ old('sleep_quality') == '3' ? 'selected' : '' }}>3-Agak Buruk (Sulit Tidur Nyenyak)</option>
                    <option value="4" {{ old('sleep_quality') == '4' ? 'selected' : '' }}>4-Cukup Buruk (Terbangun Berkali-kali)</option>
                    <option value="5" {{ old('sleep_quality') == '5' ? 'selected' : '' }}>5-Sedang (Tidur Biasa Saja)</option>
                    <option value="6" {{ old('sleep_quality') == '6' ? 'selected' : '' }}>6-Cukup Baik (Tidur Cukup Nyenyak)</option>
                    <option value="7" {{ old('sleep_quality') == '7' ? 'selected' : '' }}>7-Agak Baik (Tidur Pulas)</option>
                    <option value="8" {{ old('sleep_quality') == '8' ? 'selected' : '' }}>8-Baik (Tidur Sangat Nyenyak)</option>
                    <option value="9" {{ old('sleep_quality') == '9' ? 'selected' : '' }}>9-Sangat Baik (Tidur Berkualitas Tinggi)</option>
                    <option value="10" {{ old('sleep_quality') == '10' ? 'selected' : '' }}>10-Sangat Optimal (Tidur Sempurna dan Segar)</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="physical_activity" class="form-label">6. Berapa sering Anda melakukan aktivitas fisik (olahraga)?</label>
                <select id="physical_activity" name="physical_activity" class="form-select" required>
                    <option value="" disabled {{ old('physical_activity') == '' ? 'selected' : '' }}>Pilih Frekuensi Aktivitas Fisik Anda</option>
                    <option value="1" {{ old('physical_activity') == '1' ? 'selected' : '' }}>1-Sangat Jarang (Tidak Aktif)</option>
                    <option value="2" {{ old('physical_activity') == '2' ? 'selected' : '' }}>2-Jarang (Sangat Sedikit Aktivitas)</option>
                    <option value="3" {{ old('physical_activity') == '3' ? 'selected' : '' }}>3-Cukup (Aktivitas Ringan-Sedang)</option>
                    <option value="4" {{ old('physical_activity') == '4' ? 'selected' : '' }}>4-Sering (Aktivitas Sedang-Tinggi)</option>
                    <option value="5" {{ old('physical_activity') == '5' ? 'selected' : '' }}>5-Sangat Sering (Sangat Aktif)</option>
                    <option value="6" {{ old('physical_activity') == '6' ? 'selected' : '' }}>6-Teratur (Aktivitas Terorganisir)</option>
                    <option value="7" {{ old('physical_activity') == '7' ? 'selected' : '' }}>7-Aktif (Sering Berolahraga)</option>
                    <option value="8" {{ old('physical_activity') == '8' ? 'selected' : '' }}>8-Sangat Aktif (Intensitas Tinggi)</option>
                    <option value="9" {{ old('physical_activity') == '9' ? 'selected' : '' }}>9-Profesional (Latihan Ekstrem)</option>
                    <option value="10" {{ old('physical_activity') == '10' ? 'selected' : '' }}>10-Atlet Elit (Aktivitas Maksimal)</option>
                </select>
            </div>
            <div class="mb-4">
                <label for="stress_level" class="form-label">7. Seberapa sering Anda merasa stres?</label>
                <select id="stress_level" name="stress_level" class="form-select" required>
                    <option value="" disabled {{ old('stress_level') == '' ? 'selected' : '' }}>Pilih Tingkat Stres Anda</option>
                    <option value="1" {{ old('stress_level') == '1' ? 'selected' : '' }}>1-Sangat Rendah (Tidak Stres)</option>
                    <option value="2" {{ old('stress_level') == '2' ? 'selected' : '' }}>2-Rendah</option>
                    <option value="3" {{ old('stress_level') == '3' ? 'selected' : '' }}>3-Sedang</option>
                    <option value="4" {{ old('stress_level') == '4' ? 'selected' : '' }}>4-Cukup Tinggi</option>
                    <option value="5" {{ old('stress_level') == '5' ? 'selected' : '' }}>5-Tinggi</option>
                    <option value="6" {{ old('stress_level') == '6' ? 'selected' : '' }}>6-Sangat Tinggi</option>
                    <option value="7" {{ old('stress_level') == '7' ? 'selected' : '' }}>7-Berlebihan</option>
                    <option value="8" {{ old('stress_level') == '8' ? 'selected' : '' }}>8-Kritis</option>
                    <option value="9" {{ old('stress_level') == '9' ? 'selected' : '' }}>9-Parah</option>
                    <option value="10" {{ old('stress_level') == '10' ? 'selected' : '' }}>10-Sangat Parah (Tidak Terkendali)</option>
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

            <div class="flex items-center justify-between mt-6">
                <a href="{{ route('landing') }}" class="back-button">Kembali</a>
                <button type="submit" class="submit-button">Submit Jawaban</button>
            </div>
        </form>
    </div>
@endsection