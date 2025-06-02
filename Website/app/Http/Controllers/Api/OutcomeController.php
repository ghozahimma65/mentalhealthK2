<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

use App\Services\FlaskApiService;
use App\Models\MentalHealthOutcome;

class OutcomeController extends Controller
{
    protected $flaskApiService;

    public function __construct(FlaskApiService $flaskApiService) { $this->flaskApiService = $flaskApiService; }

    public function store(Request $request): JsonResponse {
        try {
            $validatedData = $request->validate([
                'diagnosis' => 'required|integer', 'symptom_severity' => 'required|integer|min:1|max:10',
                'mood_score' => 'required|integer|min:1|max:10', 'physical_activity' => 'required|numeric|min:0',
                'medication' => 'required|integer', 'therapy_type' => 'required|integer',
                'treatment_duration' => 'required|integer|min:0', 'stress_level' => 'required|integer|min:1|max:10',
            ]);
        } catch (ValidationException $e) { return response()->json(['message' => 'Validasi input gagal.', 'errors' => $e->errors(),], 422); }

        $inputForFlask = [
            'Diagnosis' => (int)$validatedData['diagnosis'], 'Symptom Severity (1-10)' => (int)$validatedData['symptom_severity'],
            'Mood Score (1-10)' => (int)$validatedData['mood_score'], 'Physical Activity (hrs/week)' => (float)$validatedData['physical_activity'],
            'Medication' => (int)$validatedData['medication'], 'Therapy Type' => (int)$validatedData['therapy_type'],
            'Treatment Duration (weeks)' => (int)$validatedData['treatment_duration'], 'Stress Level (1-10)' => (int)$validatedData['stress_level'],
        ];

        try {
            $prediction = $this->flaskApiService->predictOutcome($inputForFlask);
            if ($prediction && isset($prediction['outcome_prediction'])) {
                $outcome = MentalHealthOutcome::create([
                    'user_id' => Auth::id(), 'input_data' => $inputForFlask,
                    'predicted_outcome' => $prediction['outcome_prediction'], 'timestamp' => now(),
                ]);
                return response()->json(['message' => 'Data outcome berhasil disimpan dan diprediksi!', 'outcome_id' => $outcome->_id, 'predicted_outcome' => $outcome->predicted_outcome, 'timestamp' => $outcome->timestamp->toDateTimeString(),], 201);
            } else {
                Log::warning('Flask API prediction failed for outcome.', ['response' => $prediction, 'user_id' => Auth::id()]);
                return response()->json(['message' => 'Gagal mendapatkan prediksi outcome dari AI. Respon tidak valid.',], 500);
            }
        } catch (\Exception $e) {
            Log::error('Error menyimpan data outcome dari API: ' . $e->getMessage(), ['user_id' => Auth::id(), 'input' => $inputForFlask]);
            return response()->json(['message' => 'Terjadi kesalahan server. Silakan coba lagi.', 'error_detail' => $e->getMessage()], 500);
        }
    }

    public function history(Request $request): JsonResponse {
        $user = Auth::user();
        $outcomes = MentalHealthOutcome::where('user_id', $user->id)->latest('timestamp')->get();
        $formattedOutcomes = $outcomes->map(function($outcome) {
            return [
                'id' => $outcome->_id, 'predicted_outcome' => $outcome->predicted_outcome, 'timestamp' => $outcome->timestamp->toDateTimeString(),
                'input_data_summary' => ['diagnosis' => $outcome->input_data['Diagnosis'] ?? null, 'mood_score' => $outcome->input_data['Mood Score (1-10)'] ?? null, 'stress_level' => $outcome->input_data['Stress Level (1-10)'] ?? null,]
            ];
        });
        return response()->json(['message' => 'History fetched successfully.', 'data' => $formattedOutcomes], 200);
    }
}