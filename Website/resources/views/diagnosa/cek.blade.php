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

        <form action="{{ route('simpan-jawaban') }}" method="POST" class="max-w-lg mx-auto bg-white shadow-md rounded-lg p-6">
            @csrf

            <div class="mb-4">
                <label for="age" class="form-label">1. Berapa usia Anda?</label>
                <input type="number" id="age" name="age" class="form-input" required>
            </div>

            <div class="mb-4">
                <label for="gender" class="form-label">2. Apa jenis kelamin Anda?</label>
                <select id="gender" name="gender" class="form-select">
                    <option value="Laki-laki">Laki-laki</option>
                    <option value="Perempuan">Perempuan</option>
                    <option value="Lainnya">Lainnya</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="form-label">3. Apakah Anda pernah didiagnosis dengan masalah kesehatan mental?</label>
                <div class="radio-group">
                    <label><input type="radio" name="diagnosis" value="1"> Ya</label>
                    <label><input type="radio" name="diagnosis" value="0"> Tidak</label>
                </div>
            </div>

            <div class="mb-4">
                <label for="symptom_severity" class="form-label">4. Seberapa parah gejala yang Anda rasakan?</label>
                <select id="symptom_severity" name="symptom_severity" class="form-select">
                    <option value="1">1 - Sangat Ringan</option>
                    <option value="2">2 - Ringan</option>
                    <option value="3">3 - Sedang</option>
                    <option value="4">4 - Berat</option>
                    <option value="5">5 - Sangat Berat</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="mood_score" class="form-label">5. Bagaimana suasana hati Anda dalam seminggu terakhir?</label>
                <select id="mood_score" name="mood_score" class="form-select">
                    <option value="1">1 - Sangat Buruk</option>
                    <option value="2">2 - Buruk</option>
                    <option value="3">3 - Netral</option>
                    <option value="4">4 - Baik</option>
                    <option value="5">5 - Sangat Baik</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="sleep_quality" class="form-label">6. Seberapa baik kualitas tidur Anda?</label>
                <select id="sleep_quality" name="sleep_quality" class="form-select">
                    <option value="1">1 - Sangat Buruk</option>
                    <option value="2">2 - Buruk</option>
                    <option value="3">3 - Sedang</option>
                    <option value="4">4 - Baik</option>
                    <option value="5">5 - Sangat Baik</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="physical_activity" class="form-label">7. Berapa sering Anda melakukan aktivitas fisik (olahraga)?</label>
                <select id="physical_activity" name="physical_activity" class="form-select">
                    <option value="0">Tidak Pernah</option>
                    <option value="1">Kadang-kadang</option>
                    <option value="2">Rutin</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="form-label">8. Apakah Anda sedang menjalani pengobatan (medikasi)?</label>
                <div class="radio-group">
                    <label><input type="radio" name="medication" value="1"> Ya</label>
                    <label><input type="radio" name="medication" value="0"> Tidak</label>
                </div>
            </div>

            <div class="mb-4">
                <label for="therapy_type" class="form-label">9. Apakah Anda sedang menjalani terapi psikologis?</label>
                <select id="therapy_type" name="therapy_type" class="form-select">
                    <option value="Tidak">Tidak</option>
                    <option value="Terapi Individu">Ya, Terapi Individu</option>
                    <option value="Terapi Kelompok">Ya, Terapi Kelompok</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="treatment_duration" class="form-label">10. Berapa lama Anda sudah menjalani perawatan kesehatan mental?</label>
                <input type="number" id="treatment_duration" name="treatment_duration" class="form-input">
                <p class="text-gray-600 text-xs italic">dalam bulan (jika ada)</p>
            </div>

            <div class="mb-4">
                <label for="stress_level" class="form-label">11. Seberapa sering Anda merasa stres?</label>
                <select id="stress_level" name="stress_level" class="form-select">
                    <option value="1">1 - Jarang</option>
                    <option value="2">2 - Kadang-kadang</option>
                    <option value="3">3 - Sering</option>
                    <option value="4">4 - Sangat Sering</option>
                    <option value="5">5 - Hampir Setiap Saat</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="form-label">12. Menurut Anda, apakah Anda mengalami kemajuan dalam perawatan Anda?</label>
                <div class="radio-group">
                    <label><input type="radio" name="treatment_progress" value="1"> Ya</label>
                    <label><input type="radio" name="treatment_progress" value="0"> Tidak</label>
                </div>
            </div>

            <div class="mb-4">
                <label for="emotional_state" class="form-label">13. Seberapa sering Anda merasa emosi negatif seperti sedih, marah, atau cemas?</label>
                <select id="emotional_state" name="emotional_state" class="form-select">
                    <option value="1">1 - Sangat Jarang</option>
                    <option value="2">2 - Jarang</option>
                    <option value="3">3 - Kadang-kadang</option>
                    <option value="4">4 - Sering</option>
                    <option value="5">5 - Sangat Sering</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="adherence_treatment" class="form-label">14. Seberapa patuh Anda mengikuti rencana perawatan atau pengobatan Anda?</label>
                <select id="adherence_treatment" name="adherence_treatment" class="form-select">
                    <option value="1">1 - Tidak Patuh</option>
                    <option value="2">2 - Kurang Patuh</option>
                    <option value="3">3 - Cukup Patuh</option>
                    <option value="4">4 - Patuh</option>
                    <option value="5">5 - Sangat Patuh</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="concentration" class="form-label">15. Apakah Anda mengalami kesulitan untuk berkonsentrasi akhir-akhir ini?</label>
                <select id="concentration" name="concentration" class="form-select">
                    <option value="1">1 - Tidak Pernah</option>
                    <option value="2">2 - Jarang</option>
                    <option value="3">3 - Kadang-kadang</option>
                    <option value="4">4 - Sering</option>
                    <option value="5">5 - Sangat Sering</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="form-label">16. Apakah Anda memiliki dukungan sosial (keluarga/teman)?</label>
                <div class="radio-group">
                    <label><input type="radio" name="social_support" value="1"> Ya</label>
                    <label><input type="radio" name="social_support" value="0"> Tidak</label>
                </div>
            </div>

            <div class="mb-4">
                <label for="optimism" class="form-label">17. Seberapa optimis Anda merasa tentang masa depan Anda?</label>
                <select id="optimism" name="optimism" class="form-select">
                    <option value="1">1 - Sangat Tidak Optimis</option>
                    <option value="2">2 - Tidak Optimis</option>
                    <option value="3">3 - Netral</option>
                    <option value="4">4 - Optimis</option>
                    <option value="5">5 - Sangat Optimis</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="form-label">18. Apakah Anda pernah menghentikan pengobatan atau terapi lebih awal?</label>
                <div class="radio-group">
                    <label><input type="radio" name="stopped_treatment" value="1"> Ya</label>
                    <label><input type="radio" name="stopped_treatment" value="0"> Tidak</label>
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label">19. Apakah Anda mengalami perubahan pola makan akhir-akhir ini?</label>
                <div class="radio-group">
                    <label><input type="radio" name="eating_changes" value="1"> Ya</label>
                    <label><input type="radio" name="eating_changes" value="0"> Tidak</label>
                </div>
            </div>

            <div class="mb-4">
                <label for="meaning_of_life" class="form-label">20. Seberapa besar Anda merasa hidup Anda bermakna saat ini?</label>
                <select id="meaning_of_life" name="meaning_of_life" class="form-select">
                    <option value="1">1 - Sangat Tidak Bermakna</option>
                    <option value="2">2 - Tidak Bermakna</option>
                    <option value="3">3 - Netral</option>
                    <option value="4">4 - Bermakna</option>
                    <option value="5">5 - Sangat Bermakna</option>
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