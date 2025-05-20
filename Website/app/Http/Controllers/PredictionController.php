<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;

class PredictionController extends Controller
{
    /**
     * Tampilkan form input prediksi
     */
    public function showCreateForm()
    {
        return view('predictions.create');
    }

    /**
     * Kirim data ke Flask dan simpan hasil prediksi
     */
public function predict(Request $request)
{
    $validated = $request->validate([
        'Age' => 'required|integer',
        'Gender' => 'required|integer',               // ubah jadi integer
        //'Diagnosis' => 'required|integer',          // Biasanya diagnosis hasil output, jadi gak perlu input
        'Symptom_Severity' => 'required|numeric',    // float64
        'Mood_Score' => 'required|numeric',          // float64
        'Sleep_Quality' => 'required|numeric',       // float64
        'Physical_Activity' => 'required|integer',   // int64
        'Medication' => 'required|integer',           // int64 (boolean juga bisa int)
        'Therapy_Type' => 'required|integer',        // int64
        'Treatment_Duration' => 'required|integer',  // int64
        'Stress_Level' => 'required|numeric',        // float64
        'Outcome' => 'required|integer',              // int64
        'Treatment_Progress' => 'required|numeric',  // float64
        'AI_Detected_Emotional_State' => 'required|integer', // int64
        'Adherence_to_Treatment' => 'required|integer',       // int64
    ]);

    $data = array_merge($validated, [
        'admin_id' => Auth::id()
    ]);

    // Kirim ke Flask
    $response = Http::post('http://127.0.0.1:5000/predict', $data);

    $result = $response->json();

    return redirect()->route('predictions.history')->with('success', 'Prediksi berhasil! Diagnosis: ' . $result['diagnosis']);
}
}