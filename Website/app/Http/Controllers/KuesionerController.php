<?php

namespace App\Http\Controllers;

use App\Models\JawabanKuesioner; // Import model JawabanKuesioner
use Illuminate\Http\Request;

class KuesionerController extends Controller
{
    public function simpanJawaban(Request $request)
    {
        // Validasi data yang masuk dari formulir
        $request->validate([
            'age' => 'required|integer|min:0',
            'gender' => 'required|string|max:255',
            'diagnosis' => 'nullable|boolean',
            'symptom_severity' => 'required|integer|min:1|max:5',
            'mood_score' => 'required|integer|min:1|max:5',
            'sleep_quality' => 'required|integer|min:1|max:5',
            'physical_activity' => 'required|integer|min:0|max:2',
            'medication' => 'nullable|boolean',
            'therapy_type' => 'nullable|string|max:255',
            'treatment_duration' => 'nullable|integer|min:0',
            'stress_level' => 'required|integer|min:1|max:5',
            'treatment_progress' => 'nullable|boolean',
            'emotional_state' => 'required|integer|min:1|max:5',
            'adherence_treatment' => 'required|integer|min:1|max:5',
            'concentration' => 'required|integer|min:1|max:5',
            'social_support' => 'nullable|boolean',
            'optimism' => 'required|integer|min:1|max:5',
            'stopped_treatment' => 'nullable|boolean',
            'eating_changes' => 'nullable|boolean',
            'meaning_of_life' => 'required|integer|min:1|max:5',
        ]);

        try {
            // Simpan jawaban menggunakan Model Eloquent
            JawabanKuesioner::create($request->all());

            // Redirect pengguna ke halaman hasil dengan pesan sukses
            return redirect()->route('hasil')->with('success', 'Jawaban Anda berhasil disimpan.');

        } catch (\Exception $e) {
            // Tangani error jika gagal menyimpan ke MongoDB
            return back()->withErrors(['error' => 'Gagal menyimpan jawaban: ' . $e->getMessage()])->withInput();
        }
    }
}