<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kuesioner Kesehatan Mental</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #EDF6F9;
            color: #2C3E70;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }
        .container {
            background-color: white;
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            padding: 2rem;
            max-width: 800px;
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
        .text-center {
            text-align: center;
        }
        .text-2xl {
            font-size: 1.5rem;
            line-height: 2rem;
        }
        .font-bold {
            font-weight: 700;
        }
        .mb-6 {
            margin-bottom: 1.5rem;
        }
        .py-8 {
            padding-top: 2rem;
            padding-bottom: 2rem;
        }
        .mx-auto {
            margin-left: auto;
            margin-right: auto;
        }
        .max-w-lg {
            max-width: 32rem;
        }
        .bg-white {
            background-color: #fff;
        }
        .shadow-md {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
        .rounded-lg {
            border-radius: 0.5rem;
        }
        .p-6 {
            padding: 1.5rem;
        }
        .block {
            display: block;
        }
        .text-gray-700 {
            color: #4A5568;
        }
        .text-sm {
            font-size: 0.875rem;
            line-height: 1.25rem;
        }
        .mb-2 {
            margin-bottom: 0.5rem;
        }
        .leading-tight {
            line-height: 1.5;
        }
        .focus:outline-none {
            outline: 2px solid transparent;
            outline-offset: 2px;
        }
        .focus:shadow-outline {
            box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.5);
        }
        .flex {
            display: flex;
        }
        .items-center {
            align-items: center;
        }
        .space-x-4 > * + * {
            margin-left: 1rem;
        }
        .text-gray-600 {
            color: #718096;
        }
        .text-xs {
            font-size: 0.75rem;
            line-height: 1rem;
        }
        .italic {
            font-style: italic;
        }
        .justify-between {
            justify-content: space-between;
        }
        .text-[#80CBC4] {
            color: #80CBC4;
        }
    </style>
</head>
<body>
    <div class="container py-8">
        <h1 class="text-2xl font-bold mb-6 text-center text-[#80CBC4]">Kuesioner Kesehatan Mental</h1>

        <form action="{{ route('diagnosis.submit') }}" method="POST" class="max-w-lg p-6 mx-auto bg-white rounded-lg shadow-md">
            @csrf
        <body class="flex items-center justify-center min-h-screen p-4">
    <div class="w-full max-w-2xl p-8 bg-white border border-gray-200 rounded-lg shadow-xl">
        <h1 class="mb-6 text-3xl font-bold text-center text-gray-800">Kuesioner Diagnosis Kesehatan Mental</h1>
        <p class="mb-8 text-center text-gray-600">
            Silakan isi informasi di bawah ini untuk mendapatkan diagnosis awal. Data Anda akan dijaga kerahasiaannya.
        </p>
            {{-- <div class="mb-4">
    <label for="name" class="form-label">Nama Lengkap</label>
    <input type="text" id="name" name="name" class="form-input" required>
</div> --}}

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
                    <option value="1">Sangat Ringan</option>
                    <option value="2">Ringan</option>
                    <option value="3">Sedang</option>
                    <option value="4">Agak Berat</option>
                    <option value="5">Berat</option>
                    <option value="6">Sangat Berat</option>
                    <option value="7">Ekstrem</option>
                    <option value="8">Kritis</option>
                    <option value="9">Sangat Kritis</option>
                    <option value="10">Maksimal</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="mood_score" class="form-label">4. Bagaimana suasana hati Anda dalam seminggu terakhir?</label>
                <select id="mood_score" name="mood_score" class="form-select">
                    <option value="1">Sangat Buruk (Depresi/Sedih)</option>
<option value="2">Buruk (Cemas/Resah)</option>
<option value="3">Agak Buruk (Kurang Bersemangat)</option>
<option value="4">Cukup Netral (Biasa Saja)</option>
<option value="5">Netral (Stabil)</option>
<option value="6">Agak Baik (Cukup Bersemangat)</option>
<option value="7">Baik (Senang)</option>
<option value="8">Sangat Baik (Gembira/Optimis)</option>
<option value="9">Luar Biasa (Bahagia/Antusias)</option>
<option value="10">Maksimal (Euforia/Penuh Energi)</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="sleep_quality" class="form-label">5. Seberapa baik kualitas tidur Anda?</label>
                <select id="sleep_quality" name="sleep_quality" class="form-select">
                    <option value="1">Sangat Buruk (Tidak Tidur Sama Sekali)</option>
<option value="2">Buruk (Tidur Sangat Gelisah)</option>
<option value="3">Agak Buruk (Sulit Tidur Nyenyak)</option>
<option value="4">Cukup Buruk (Terbangun Berkali-kali)</option>
<option value="5">Sedang (Tidur Biasa Saja)</option>
<option value="6">Cukup Baik (Tidur Cukup Nyenyak)</option>
<option value="7">Agak Baik (Tidur Pulas)</option>
<option value="8">Baik (Tidur Sangat Nyenyak)</option>
<option value="9">Sangat Baik (Tidur Berkualitas Tinggi)</option>
<option value="10">Sangat Optimal (Tidur Sempurna dan Segar)</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="physical_activity" class="form-label">6. Berapa sering Anda melakukan aktivitas fisik (olahraga)?</label>
                <select id="physical_activity" name="physical_activity" class="form-select">
                   <option value="1">Sangat Jarang (Tidak Aktif)</option>
<option value="2">Jarang (Sangat Sedikit Aktivitas)</option>
<option value="3">Cukup (Aktivitas Ringan-Sedang)</option>
<option value="4">Sering (Aktivitas Sedang-Tinggi)</option>
<option value="5">Sangat Sering (Sangat Aktif)</option>
<option value="6">Teratur (Aktivitas Terorganisir)</option>
<option value="7">Aktif (Sering Berolahraga)</option>
<option value="8">Sangat Aktif (Intensitas Tinggi)</option>
<option value="9">Profesional (Latihan Ekstrem)</option>
<option value="10">Atlet Elit (Aktivitas Maksimal)</option>
                </select>
            </div>
            <div class="mb-4">
                <label for="stress_level" class="form-label">7. Seberapa sering Anda merasa stres?</label>
                <select id="stress_level" name="stress_level" class="form-select">
                    <option value="1">😌 Sangat Rendah (Tidak Stres)</option>
                    <option value="2">😊 Rendah</option>
                    <option value="3">😐 Sedang</option>
                    <option value="4">😟 Cukup Tinggi</option>
                    <option value="5">😰 Tinggi</option>
                    <option value="6">😥 Sangat Tinggi</option>
                    <option value="7">😩 Berlebihan</option>
                    <option value="8">🤯 Kritis</option>
                    <option value="9">😵 Parah</option>
                    <option value="10">💀 Sangat Parah (Tidak Terkendali)</option>
                </select>
            </div>
            <div class="mb-4">
                <label for="ai_detected_emotional_state" class="form-label">8. Bagaimana Suasana Hati Anda Saat ini?</label>
                <select id="ai_detected_emotional_state" name="ai_detected_emotional_state" class="form-select">
                    <option value="0">😟 Anxious (Cemas)</option>
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
        </form>
    </div>
</body>
</html>