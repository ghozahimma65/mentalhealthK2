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
        'gender' => 'required|integer|min:0|max:1', // Sudah sesuai dengan Pria (0) dan Wanita (1)
        'symptom_severity' => 'required|integer|min:1|max:10',
        'mood_score' => 'required|integer|min:1|max:10',
        'sleep_quality' => 'required|integer|min:1|max:10',
        'physical_activity' => 'required|integer|min:0',
        'stress_level' => 'required|integer|min:1|max:10',
        'ai_detected_emotional_state' => 'required|integer|min:0|max:5',// Menyesuaikan dengan 'AI Detected Emotional State'
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