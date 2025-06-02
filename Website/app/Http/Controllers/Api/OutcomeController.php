<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\FlaskApiService;
use App\Models\MentalHealthOutcome;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class OutcomeController extends Controller
{
    protected $flaskApiService;

    private const FLASK_OUTCOME_FEATURE_MAP = [
        'diagnosis' => 'Diagnosis',
        'symptom_severity' => 'Symptom Severity (1-10)',
        'mood_score' => 'Mood Score (1-10)',
        'physical_activity' => 'Physical Activity (hrs/week)',
        'medication' => 'Medication',
        'therapy_type' => 'Therapy Type',
        'treatment_duration' => 'Treatment Duration (weeks)',
        'stress_level' => 'Stress Level (1-10)'
    ];

    public function __construct(FlaskApiService $flaskApiService)
    {
        $this->flaskApiService = $flaskApiService;
    }

    public function submitOutcome(Request $request)
    {
        $validationRules = [];
        foreach (array_keys(self::FLASK_OUTCOME_FEATURE_MAP) as $mobileKey) {
            if ($mobileKey === 'physical_activity') {
                $validationRules[$mobileKey] = 'required|numeric|min:0';
            } else {
                $validationRules[$mobileKey] = 'required|integer';
            }
            if (in_array($mobileKey, ['symptom_severity', 'mood_score', 'stress_level'])) {
                $validationRules[$mobileKey] .= '|min:1|max:10';
            }
            if ($mobileKey === 'treatment_duration') {
                 $validationRules[$mobileKey] .= '|min:0';
            }
            if ($mobileKey === 'diagnosis') {
                 $validationRules[$mobileKey] .= '|in:0,1,2,3,99';
            }
             if ($mobileKey === 'medication') {
                 $validationRules[$mobileKey] .= '|in:0,1,2,3,4,5,99';
            }
            if ($mobileKey === 'therapy_type') {
                 $validationRules[$mobileKey] .= '|in:0,1,2,3,99';
            }
        }

        $validator = Validator::make($request->all(), $validationRules);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'Validasi input gagal.', 'errors' => $validator->errors()], 422);
        }

        $validatedData = $validator->validated();
        $inputForFlask = [];

        foreach (self::FLASK_OUTCOME_FEATURE_MAP as $mobileKey => $flaskKey) {
            if (isset($validatedData[$mobileKey])) {
                if ($mobileKey === 'physical_activity') {
                    $inputForFlask[$flaskKey] = (float)$validatedData[$mobileKey];
                } else {
                    $inputForFlask[$flaskKey] = (int)$validatedData[$mobileKey];
                }
            } else {
                 Log::error("API Mobile (Outcome): Fitur WAJIB '$mobileKey' untuk mapping ke Flask '$flaskKey' tidak ada di validatedData!");
                return response()->json(['success' => false, 'message' => "Data input tidak lengkap: $mobileKey hilang."], 400);
            }
        }

        $prediction = null;
        // feedback_message sudah dihilangkan

        try {
            Log::info('API Mobile (Outcome): Mengirim data ke Flask: ', $inputForFlask);
            $predictionResultFromFlask = $this->flaskApiService->predictOutcome($inputForFlask);
            Log::info('API Mobile (Outcome): Respons dari Flask: ', is_array($predictionResultFromFlask) ? $predictionResultFromFlask : (array) $predictionResultFromFlask);

            // --- PERBAIKAN KUNCI DI SINI ---
            // Flask API Anda mengembalikan 'outcome_prediction', bukan 'predicted_outcome'
            if ($predictionResultFromFlask && isset($predictionResultFromFlask['outcome_prediction']) && is_int($predictionResultFromFlask['outcome_prediction'])) {
                $prediction = (int)$predictionResultFromFlask['outcome_prediction'];
            } else {
                Log::warning('API Mobile (Outcome): Prediksi dari Flask API gagal atau data tidak valid.', ['response' => $predictionResultFromFlask]);
                // Pesan error disesuaikan
                return response()->json(['success' => false, 'message' => 'Gagal mendapatkan hasil prediksi outcome dari layanan. Respon tidak sesuai atau kunci "outcome_prediction" tidak ditemukan/bukan integer.'], 500);
            }
        } catch (\Exception $e) {
            Log::error('API Mobile (Outcome): Error memanggil Flask API: ' . $e->getMessage(), ['exception' => $e]);
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan saat menghubungi layanan prediksi outcome.', 'error' => $e->getMessage()], 500);
        }

        try {
            MentalHealthOutcome::create([
                'user_id' => Auth::check() ? Auth::id() : null,
                'input_data' => $inputForFlask,
                'predicted_outcome' => $prediction,
                'timestamp' => now(),
                'admin_processed' => false,
            ]);
        } catch (\Exception $e) {
            Log::error('API Mobile (Outcome): Gagal menyimpan hasil ke MongoDB: ' . $e->getMessage(), ['exception' => $e]);
            return response()->json(['success' => false, 'message' => 'Prediksi berhasil, namun gagal menyimpan data ke riwayat.'], 500);
        }

        return response()->json([
            'success' => true,
            'message' => 'Hasil tes perkembangan berhasil dikirim.',
            'predicted_outcome' => $prediction, // Ini adalah integer yang akan dikirim ke Flutter
            'timestamp' => now()->toIso8601String(),
            'input_data' => $inputForFlask
        ], 200);
    }

    public function history(Request $request)
    {
        // ... (logika history Anda sudah baik, pastikan $item->predicted_outcome
        // dikirim sebagai integer) ...
        if (!Auth::check()) {
            return response()->json(['success' => false, 'message' => 'Anda harus login untuk melihat riwayat.'], 401);
        }

        try {
            $history = MentalHealthOutcome::where('user_id', Auth::id())
                                    ->orderBy('timestamp', 'desc')
                                    ->get();

            $formattedHistory = $history->map(function($item) {
                $inputData = is_array($item->input_data) ? $item->input_data : (is_object($item->input_data) ? (array) $item->input_data : []);
                return [
                    '_id' => $item->_id,
                    'user_id' => $item->user_id,
                    'predicted_outcome' => $item->predicted_outcome, // Ini sudah integer dari database
                    'timestamp' => $item->timestamp ? $item->timestamp->toIso8601String() : null,
                    'input_data' => $inputData,
                ];
            });

            return response()->json(['success' => true, 'message' => 'Riwayat tes perkembangan berhasil diambil.', 'data' => $formattedHistory], 200);
        } catch (\Exception $e) {
            Log::error('API Mobile (Outcome): Error mengambil riwayat tes perkembangan user ' . Auth::id() . ': ' . $e->getMessage(), ['exception' => $e]);
            return response()->json(['success' => false, 'message' => 'Gagal mengambil riwayat tes perkembangan.', 'error' => $e->getMessage()], 500);
        }
    }
}