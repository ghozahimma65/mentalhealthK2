@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Form Kuesioner Pasien</h2>
    <form action="{{ route('predict') }}" method="POST">
        @csrf

        {{-- <div class="mb-3">
            <label for="name">Nama Pasien</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" class="form-control" required>
        </div> --}}

        <div class="mb-3">
            <label for="age">Usia</label>
            <input type="number" name="age" id="age" class="form-control" required>
        </div>

        {{-- FITUR UNTUK MODEL ANDA - SESUAIKAN URUTAN DAN NAMA JIKA PERLU --}}
        {{-- PASTIKAN URUTAN INPUT DI SINI SAMA DENGAN URUTAN FITUR SAAT MODEL DILATIH --}}
        {{-- ASUMSI URUTAN FITUR: Symptom Severity, Mood Score, Physical Activity, Medication, Therapy Type, Treatment Duration, Stress Level --}}

        <div class="mb-3">
            <label for="symptom_severity">Symptom Severity (1-10)</label>
            <input type="number" name="features[]" id="symptom_severity" class="form-control" min="1" max="10" required>
        </div>

        <div class="mb-3">
            <label for="mood_score">Mood Score (1-10)</label>
            <input type="number" name="features[]" id="mood_score" class="form-control" min="1" max="10" required>
        </div>

        <div class="mb-3">
            <label for="physical_activity">Physical Activity (hrs/week)</label>
            <input type="number" name="features[]" id="physical_activity" class="form-control" min="0" required>
        </div>

        <div class="mb-3">
            <label for="medication">Medication (0-5, sesuai encoding)</label>
            <input type="number" name="features[]" id="medication" class="form-control" min="0" max="5" required>
            {{-- Atau gunakan <select> dropdown jika Anda ingin label yang lebih user-friendly --}}
            {{-- Contoh dropdown: --}}
            {{-- <select name="features[]" id="medication" class="form-control" required>
                <option value="0">Antidepressants</option>
                <option value="1">Antipsychotics</option>
                <option value="2">Benzodiazepines</option>
                <option value="3">Mood Stabilizers</option>
                <option value="4">SSRIs</option>
                <option value="5">Anxiolytics</option>
            </select> --}}
        </div>

        <div class="mb-3">
            <label for="therapy_type">Therapy Type (0-3, sesuai encoding)</label>
            <input type="number" name="features[]" id="therapy_type" class="form-control" min="0" max="3" required>
            {{-- Contoh dropdown: --}}
            {{-- <select name="features[]" id="therapy_type" class="form-control" required>
                <option value="0">Cognitive Behavioral Therapy</option>
                <option value="1">Dialectical Behavioral Therapy</option>
                <option value="2">Interpersonal Therapy</option>
                <option value="3">Mindfulness-Based Therapy</option>
            </select> --}}
        </div>

        <div class="mb-3">
            <label for="treatment_duration">Treatment Duration (weeks)</label>
            <input type="number" name="features[]" id="treatment_duration" class="form-control" min="0" required>
        </div>

        <div class="mb-3">
            <label for="stress_level">Stress Level (1-10)</label>
            <input type="number" name="features[]" id="stress_level" class="form-control" min="1" max="10" required>
        </div>

        {{-- Catatan: Fitur 'Diagnosis' dan 'Outcome' di info kolom Anda kemungkinan besar adalah target yang diprediksi, bukan input.
                     AI-Detected Emotional State (dari info kolom sebelumnya) juga tidak ada di sini.
                     Pastikan semua fitur input yang diharapkan model sudah ada di form ini dan dalam urutan yang benar. --}}

        <button type="submit" class="btn btn-primary">Prediksi Diagnosis & Outcome</button>
    </form>
</div>
@endsection