<?php

namespace App\Http\Controllers\Admin;

use App\Models\MentalHealthOutcome;
use Illuminate\Http\Request;
use App\Services\FlaskApiService;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class AdminOutcomeController extends Controller
{
    protected $flaskApiService;

    // NAMA FITUR FLASK YANG DIHARAPKAN OLEH MODEL /predict_outcome
    private const FLASK_OUTCOME_FEATURES_EXPECTED_BY_FLASK = [
        'Diagnosis', 'Symptom Severity (1-10)', 'Mood Score (1-10)',
        'Physical Activity (hrs/week)', 'Medication', 'Therapy Type',
        'Treatment Duration (weeks)', 'Stress Level (1-10)'
    ];

    public function __construct(FlaskApiService $flaskApiService)
    {
        $this->flaskApiService = $flaskApiService;
    }

    public function listForPrediction()
    {
        $outcomeResults = MentalHealthOutcome::with('user')
            ->where('admin_processed', false)
            ->orderBy('timestamp', 'desc')
            ->get();

        foreach ($outcomeResults as $outcome) {
            $inputData = $outcome->input_data;
            if (is_string($inputData)) {
                $decoded = json_decode($inputData, true);
                $outcome->input_data_for_view = is_array($decoded) ? $decoded : [];
            } elseif (is_array($inputData)) {
                $outcome->input_data_for_view = $inputData;
            } elseif (is_object($inputData)) {
                $outcome->input_data_for_view = (array) $inputData;
            } else {
                $outcome->input_data_for_view = [];
            }
        }
        return view('admin.adminoutcome', compact('outcomeResults'));
    }

    public function prediksi($id)
    {
        $originalOutcomeRecord = MentalHealthOutcome::find($id);

        if (!$originalOutcomeRecord) {
            return redirect()->back()->with('error', 'Data outcome pasien tidak ditemukan.');
        }

        $inputDataFromDb = null;
        if (is_string($originalOutcomeRecord->input_data)) {
            $inputDataFromDb = json_decode($originalOutcomeRecord->input_data, true);
        } elseif (is_array($originalOutcomeRecord->input_data)) {
            $inputDataFromDb = $originalOutcomeRecord->input_data;
        } elseif (is_object($originalOutcomeRecord->input_data)) {
            $inputDataFromDb = (array) $originalOutcomeRecord->input_data;
        }

        if (empty($inputDataFromDb) || !is_array($inputDataFromDb)) {
            Log::warning('Admin Panel: Data input (outcome) tidak valid untuk record ID: ' . $id, ['data_asli' => $originalOutcomeRecord->input_data]);
            return redirect()->back()->with('error', 'Data input (outcome) dari database tidak ditemukan atau formatnya tidak valid.');
        }

        $inputForFlask = [];
        $missingFeatures = [];
        foreach (self::FLASK_OUTCOME_FEATURES_EXPECTED_BY_FLASK as $flaskFeatureName) {
            if (array_key_exists($flaskFeatureName, $inputDataFromDb) && $inputDataFromDb[$flaskFeatureName] !== null) {
                if ($flaskFeatureName === 'Physical Activity (hrs/week)') {
                    $inputForFlask[$flaskFeatureName] = (float)$inputDataFromDb[$flaskFeatureName];
                } else {
                    $inputForFlask[$flaskFeatureName] = (int)$inputDataFromDb[$flaskFeatureName];
                }
            } else {
                $missingFeatures[] = $flaskFeatureName;
                Log::warning("Admin Panel: Fitur Flask '$flaskFeatureName' tidak ditemukan atau null di input_data untuk prediksi ulang record ID: $id");
            }
        }

        if (!empty($missingFeatures)) {
            $errorMessage = 'Admin Panel: Data input tidak lengkap untuk prediksi. Fitur berikut tidak ditemukan atau null di data tersimpan: ' . implode(', ', $missingFeatures) . '. Mohon periksa data sumber.';
            Log::error($errorMessage, ['record_id' => $id, 'input_data_from_db' => $inputDataFromDb]);
            return redirect()->back()->with('error', $errorMessage);
        }

        $predictedOutcomeFromFlask = null;
        $errorMessage = null;

        try {
            Log::info('Admin Panel: Mengirim data ke Flask untuk prediksi outcome: ', $inputForFlask);
            $prediction = $this->flaskApiService->predictOutcome($inputForFlask);
            Log::info('Admin Panel: Respons dari Flask untuk prediksi outcome: ', is_array($prediction) ? $prediction : (array) $prediction);

            // --- PERBAIKAN KUNCI DI SINI ---
            // Flask API Anda mengembalikan 'outcome_prediction', bukan 'predicted_outcome'
            if ($prediction && isset($prediction['outcome_prediction']) && is_int($prediction['outcome_prediction'])) {
                $predictedOutcomeFromFlask = (int)$prediction['outcome_prediction'];
            } else {
                // Pesan error disesuaikan untuk mencerminkan kunci yang dicari
                $errorMessage = 'Admin Panel: Gagal mendapatkan outcome dari layanan prediksi. Respon tidak valid atau kunci "outcome_prediction" tidak ditemukan atau bukan integer.';
                Log::error('Admin Panel: Flask API Invalid Response (Outcome): ' . json_encode($prediction), ['input_sent_to_flask' => $inputForFlask]);
            }
        } catch (\Exception $e) {
            $errorMessage = 'Admin Panel: Gagal terhubung ke layanan prediksi outcome. Error: ' . $e->getMessage();
            Log::error('Admin Panel: Flask API Connection Error (Outcome): ' . $e->getMessage(), ['exception' => $e, 'input_sent_to_flask' => $inputForFlask]);
        }

        if ($predictedOutcomeFromFlask === null) {
            return redirect()->back()->with('error', $errorMessage ?? 'Admin Panel: Tidak dapat melakukan prediksi outcome.');
        }

        try {
            $originalOutcomeRecord->predicted_outcome = $predictedOutcomeFromFlask;
            $originalOutcomeRecord->admin_processed = true;
            $originalOutcomeRecord->save();

            $outcomeDescription = $originalOutcomeRecord->getOutcomeDescription();
            $message = 'Prediksi outcome oleh admin berhasil disimpan: ' . $outcomeDescription;
        } catch (\Exception $e) {
            Log::error('Admin Panel: Gagal menyimpan update hasil outcome admin: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Prediksi berhasil, tapi gagal menyimpan pembaruan admin. Error: ' . $e->getMessage());
        }
        return redirect()->route('admin.riwayatoutcome.index')->with('success', $message);
    }

    public function history()
    {
        $outcomes = MentalHealthOutcome::with('user')
            ->orderBy('timestamp', 'desc')
            ->paginate(15);

        foreach ($outcomes as $outcome) {
            $inputData = $outcome->input_data;
            if (is_string($inputData)) {
                $decoded = json_decode($inputData, true);
                $outcome->input_data_for_view = is_array($decoded) ? $decoded : [];
            } elseif (is_array($inputData)) {
                $outcome->input_data_for_view = $inputData;
            } elseif (is_object($inputData)) {
                $outcome->input_data_for_view = (array) $inputData;
            } else {
                $outcome->input_data_for_view = [];
            }
        }
        return view('admin.riwayatoutcome', compact('outcomes'));
    }
}