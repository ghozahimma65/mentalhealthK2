@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-3xl">
    <h2 class="text-2xl font-semibold mb-6 text-gray-800">Buat Prediksi</h2>
    <form method="POST" action="{{ route('predictions.predict') }}" class="space-y-6 bg-white p-6 rounded-lg shadow-md">
        @csrf
        <input type="hidden" name="admin_id" value="{{ Auth::id() }}">

        <div>
            <label class="block mb-1 font-medium text-gray-700">Usia</label>
            <input type="number" name="Age" min="0" step="1" required
                   class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div>
            <label class="block mb-1 font-medium text-gray-700">Gender</label>
            <select name="Gender" required
                    class="w-full border border-gray-300 rounded-md px-3 py-2 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="0">Laki-laki</option>
                <option value="1">Perempuan</option>
            </select>
        </div>

        <div>
            <label class="block mb-1 font-medium text-gray-700">Severity Gejala (1–10)</label>
            <input type="number" name="Symptom_Severity" min="1" max="10" step="0.1" required
                   class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div>
            <label class="block mb-1 font-medium text-gray-700">Mood Score (1–10)</label>
            <input type="number" name="Mood_Score" min="1" max="10" step="0.1" required
                   class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div>
            <label class="block mb-1 font-medium text-gray-700">Kualitas Tidur (1–10)</label>
            <input type="number" name="Sleep_Quality" min="1" max="10" step="0.1" required
                   class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div>
            <label class="block mb-1 font-medium text-gray-700">Aktivitas Fisik (jam/minggu)</label>
            <input type="number" name="Physical_Activity" min="0" step="1" required
                   class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div>
            <label class="block mb-1 font-medium text-gray-700">Menggunakan Obat?</label>
            <select name="Medication" required
                    class="w-full border border-gray-300 rounded-md px-3 py-2 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="1">Ya</option>
                <option value="0">Tidak</option>
            </select>
        </div>

        <div>
            <label class="block mb-1 font-medium text-gray-700">Jenis Terapi (Kode angka)</label>
            <input type="number" name="Therapy_Type" min="0" step="1" required
                   class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <p class="text-sm text-gray-500 mt-1">Masukkan kode numerik untuk jenis terapi.</p>
        </div>

        <div>
            <label class="block mb-1 font-medium text-gray-700">Durasi Pengobatan (minggu)</label>
            <input type="number" name="Treatment_Duration" min="0" step="1" required
                   class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div>
            <label class="block mb-1 font-medium text-gray-700">Tingkat Stres (1–10)</label>
            <input type="number" name="Stress_Level" min="1" max="10" step="0.1" required
                   class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div>
            <label class="block mb-1 font-medium text-gray-700">Outcome (angka)</label>
            <input type="number" name="Outcome" min="0" step="1" required
                   class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div>
            <label class="block mb-1 font-medium text-gray-700">Perkembangan Treatment (1–10)</label>
            <input type="number" name="Treatment_Progress" min="1" max="10" step="0.1" required
                   class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div>
            <label class="block mb-1 font-medium text-gray-700">Emosi Terdeteksi AI (angka)</label>
            <input type="number" name="AI_Detected_Emotional_State" min="0" step="1" required
                   class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div>
            <label class="block mb-1 font-medium text-gray-700">Kepatuhan terhadap Treatment (%)</label>
            <input type="number" name="Adherence_to_Treatment" min="0" max="100" step="1" required
                   class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <button type="submit" 
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-md transition-colors">
            Prediksi
        </button>
    </form>
</div>
@endsection
