<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\FlaskApiService; // Import service yang sudah dibuat
use MongoDB\Laravel\Eloquent\Model; // Atau sesuaikan dengan model MongoDB Anda

class OutcomeController extends Controller
{
    protected $flaskApiService;

    public function __construct(FlaskApiService $flaskApiService)
    {
        $this->flaskApiService = $flaskApiService;
        // Middleware untuk otentikasi admin, jika diperlukan
        // $this->middleware('auth:admin');
    }

    public function showOutcomeForm()
    {
        return view('admin.outcome.form'); // Tampilkan form untuk prediksi outcome
    }

    public function predictOutcome(Request $request)
    {
        // Validasi input dari form
        $validatedData = $request->validate([
            'diagnosis' => 'required|integer',
            'symptom_severity' => 'required|integer|min:1|max:10',
            'mood_score' => 'required|integer|min:1|max:10',
            'physical_activity' => 'required|numeric|min:0',
            'medication' => 'required|integer', // Sesuaikan dengan encoding
            'therapy_type' => 'required|integer', // Sesuaikan dengan encoding
            'treatment_duration' => 'required|integer|min:0',
            'stress_level' => 'required|integer|min:1|max:10',
        ]);

        // Mapping nama kolom ke nama yang diharapkan oleh Flask API
        $inputForFlask = [
            'Diagnosis' => (int)$validatedData['diagnosis'],
            'Symptom Severity (1-10)' => (int)$validatedData['symptom_severity'],
            'Mood Score (1-10)' => (int)$validatedData['mood_score'],
            'Physical Activity (hrs/week)' => (float)$validatedData['physical_activity'],
            'Medication' => (int)$validatedData['medication'],
            'Therapy Type' => (int)$validatedData['therapy_type'],
            'Treatment Duration (weeks)' => (int)$validatedData['treatment_duration'],
            'Stress Level (1-10)' => (int)$validatedData['stress_level'],
        ];

        // Panggil Flask API untuk prediksi outcome
        $prediction = $this->flaskApiService->predictOutcome($inputForFlask);

        if ($prediction && isset($prediction['outcome_prediction'])) {
            // Anda bisa menyimpan input dan hasil prediksi ke MongoDB
            // Misalnya, jika ada model PatientTreatmentOutcome
            // PatientTreatmentOutcome::create([
            //     'admin_id' => auth()->id(),
            //     'input_data' => $inputForFlask,
            //     'predicted_outcome' => $prediction['outcome_prediction'],
            //     'timestamp' => now()
            // ]);

            return view('admin.outcome.result', ['outcome' => $prediction['outcome_prediction']]);
        } else {
            return back()->with('error', 'Gagal mendapatkan prediksi outcome. Silakan coba lagi.');
        }
    }
}