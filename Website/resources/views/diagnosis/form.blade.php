@extends('layouts.base') {{-- Meng-extend layout publik baru --}}

@section('title', 'Kuesioner Kesehatan Mental') {{-- Mengatur judul halaman --}}

@push('styles')
{{-- Memindahkan CSS kustom dari file HTML asli ke sini --}}
<style>
    /* Container styling untuk form */
    .container {
        background-color: white;
        border-radius: 0.5rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        padding: 2rem;
        max-width: 800px; /* Dipertahankan dari aslinya */
        width: 100%;
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
    .back-button { /* Menambahkan gaya untuk tombol kembali */
        background-color: #CBD5E0;
        color: #2C3E70;
        font-weight: bold;
        padding: 0.75rem 1.5rem;
        border-radius: 0.25rem;
        cursor: pointer;
        transition: background-color 0.2s ease-in-out;
    }
    .back-button:hover {
        background-color: #A0AEC0;
    }
</style>
@endpush

@section('content')
    {{-- Kontainer utama formulir --}}
    <div class="container mx-auto py-8"> {{-- mx-auto untuk centering horizontal, py-8 untuk padding vertikal --}}
        <h1 class="text-2xl font-bold mb-6 text-center text-[#80CBC4]">Kuesioner Kesehatan Mental</h1>

        <form action="{{ route('diagnosis.submit') }}" method="POST" class="max-w-lg p-6 mx-auto bg-white rounded-lg shadow-md">
            @csrf
            {{-- Konten formulir utama --}}
            <div class="w-full max-w-2xl p-8 bg-white border border-gray-200 rounded-lg shadow-xl">
                <h1 class="mb-6 text-3xl font-bold text-center text-gray-800">Kuesioner Diagnosis Kesehatan Mental</h1>
                <p class="mb-8 text-center text-gray-600">
                    Silakan isi informasi di bawah ini untuk mendapatkan diagnosis awal. Data Anda akan dijaga kerahasiaannya.
                </p>
                
                <div class="mb-4">
                    <label for="age" class="form-label">1. Berapa usia Anda?</label>
                    <input type="number" id="age" name="age" class="form-input" required>
                </div>

            <div class="mb-4">
                <label for="gender" class="form-label">2. Apa jenis kelamin Anda?</label>
                <select id="gender" name="gender" class="form-select">
                    <option value="0">Pria 👨</option>
                    <option value="1">Wanita 👩</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="symptom_severity" class="form-label">3. Seberapa parah gejala yang Anda rasakan?</label>
                <select id="symptom_severity" name="symptom_severity" class="form-select">
                    <option value="" disabled selected>Pilih Tingkat Keparahan Gejala</option> <option value="1">1-Sangat Ringan</option>
                    <option value="2">2-Ringan</option>
                    <option value="3">3-Sedang</option>
                    <option value="4">4-Agak Berat</option>
                    <option value="5">5-Berat</option>
                    <option value="6">6-Sangat Berat</option>
                    <option value="7">7-Ekstrem</option>
                    <option value="8">8-Kritis</option>
                    <option value="9">9-Sangat Kritis</option>
                    <option value="10">10-Maksimal</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="mood_score" class="form-label">4. Bagaimana suasana hati Anda dalam seminggu terakhir?</label>
                <select id="mood_score" name="mood_score" class="form-select">
                    <option value="" disabled selected>Pilih Suasana Hati Anda</option> <option value="1">1-Sangat Buruk (Depresi/Sedih)</option>
<option value="2">2-Buruk (Cemas/Resah)</option>
<option value="3">3-Agak Buruk (Kurang Bersemangat)</option>
<option value="4">4-Cukup Netral (Biasa Saja)</option>
<option value="5">5-Netral (Stabil)</option>
<option value="6">6-Agak Baik (Cukup Bersemangat)</option>
<option value="7">7-Baik (Senang)</option>
<option value="8">8-Sangat Baik (Gembira/Optimis)</option>
<option value="9">9-Luar Biasa (Bahagia/Antusias)</option>
<option value="10">10-Maksimal (Euforia/Penuh Energi)</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="sleep_quality" class="form-label">5. Seberapa baik kualitas tidur Anda?</label>
                <select id="sleep_quality" name="sleep_quality" class="form-select">
                    <option value="" disabled selected>Pilih Kualitas Tidur Anda</option> <option value="1">1-Sangat Buruk (Tidak Tidur Sama Sekali)</option>
<option value="2">2-Buruk (Tidur Sangat Gelisah)</option>
<option value="3">3-Agak Buruk (Sulit Tidur Nyenyak)</option>
<option value="4">4-Cukup Buruk (Terbangun Berkali-kali)</option>
<option value="5">5-Sedang (Tidur Biasa Saja)</option>
<option value="6">6-Cukup Baik (Tidur Cukup Nyenyak)</option>
<option value="7">7-Agak Baik (Tidur Pulas)</option>
<option value="8">8-Baik (Tidur Sangat Nyenyak)</option>
<option value="9">9-Sangat Baik (Tidur Berkualitas Tinggi)</option>
<option value="10">10-Sangat Optimal (Tidur Sempurna dan Segar)</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="physical_activity" class="form-label">6. Berapa sering Anda melakukan aktivitas fisik (olahraga)?</label>
                <select id="physical_activity" name="physical_activity" class="form-select">
                    <option value="" disabled selected>Pilih Frekuensi Aktivitas Fisik Anda</option> <option value="1">1-Sangat Jarang (Tidak Aktif)</option>
<option value="2">2-Jarang (Sangat Sedikit Aktivitas)</option>
<option value="3">3-Cukup (Aktivitas Ringan-Sedang)</option>
<option value="4">4-Sering (Aktivitas Sedang-Tinggi)</option>
<option value="5">5-Sangat Sering (Sangat Aktif)</option>
<option value="6">6-Teratur (Aktivitas Terorganisir)</option>
<option value="7">7-Aktif (Sering Berolahraga)</option>
<option value="8">8-Sangat Aktif (Intensitas Tinggi)</option>
<option value="9">9-Profesional (Latihan Ekstrem)</option>
<option value="10">10-Atlet Elit (Aktivitas Maksimal)</option>
                </select>
            </div>
            <div class="mb-4">
                <label for="stress_level" class="form-label">7. Seberapa sering Anda merasa stres?</label>
                <select id="stress_level" name="stress_level" class="form-select">
                    <option value="" disabled selected>Pilih Tingkat Stres Anda</option> <option value="1">1-Sangat Rendah (Tidak Stres)</option>
                    <option value="2">2-Rendah</option>
                    <option value="3">3-Sedang</option>
                    <option value="4">4-Cukup Tinggi</option>
                    <option value="5">5-Tinggi</option>
                    <option value="6">6-Sangat Tinggi</option>
                    <option value="7">7-Berlebihan</option>
                    <option value="8">8-Kritis</option>
                    <option value="9">9-Parah</option>
                    <option value="10">10-Sangat Parah (Tidak Terkendali)</option>
                </select>
            </div>
            <div class="mb-4">
                <label for="ai_detected_emotional_state" class="form-label">8. Bagaimana Suasana Hati Anda Saat ini?</label>
                <select id="ai_detected_emotional_state" name="ai_detected_emotional_state" class="form-select">
                    <option value="" disabled selected>Pilih Suasana Hati Saat Ini</option> <option value="0">😟 Anxious (Cemas)</option>
<option value="1">😔 Depressed (Sedih)</option>
<option value="2">🤩 Excited (Gembira)</option>
<option value="3">😊 Happy (Senang)</option>
<option value="4">😐 Neutral (Netral)</option>
<option value="5">😥 Stressed (Stres)</option>
                </select>
            </div>

                <div class="flex items-center justify-between">
                    <a href="{{ route('landing') }}" class="back-button">Kembali</a>
                    <button type="submit" class="submit-button">Submit Jawaban</button>
                </div>
            </div>
        </form>
    </div>
@endsection
