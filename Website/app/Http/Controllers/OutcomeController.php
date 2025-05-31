<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\FlaskApiService;
use App\Models\MentalHealthOutcome;
use App\Models\DiagnosisResult; // Tetap diimport jika digunakan oleh metode lain atau sebagai helper
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class OutcomeController extends Controller
{
    protected $flaskApiService;

    public function __construct(FlaskApiService $flaskApiService)
    {
        $this->flaskApiService = $flaskApiService;
    }

    public function create()
    {
        return view('outcome.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'diagnosis' => 'required|integer',
            'symptom_severity' => 'required|integer|min:1|max:10',
            'mood_score' => 'required|integer|min:1|max:10',
            'physical_activity' => 'required|numeric|min:0',
            'medication' => 'required|integer',
            'therapy_type' => 'required|integer',
            'treatment_duration' => 'required|integer|min:0',
            'stress_level' => 'required|integer|min:1|max:10',
        ]);

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

        $prediction = $this->flaskApiService->predictOutcome($inputForFlask);

        if ($prediction && isset($prediction['outcome_prediction'])) {
            try {
                MentalHealthOutcome::create([
                    'user_id' => Auth::id(),
                    'input_data' => $inputForFlask,
                    'predicted_outcome' => $prediction['outcome_prediction'],
                    'timestamp' => now(),
                ]);
            } catch (\Exception $e) {
                Log::error('Gagal menyimpan prediksi outcome ke MongoDB: ' . $e->getMessage());
            }

            return view('outcome.result', ['outcome_prediction' => $prediction['outcome_prediction']]);
        } else {
            Log::warning('Prediksi outcome Flask API gagal atau mengembalikan data tidak valid.', ['response' => $prediction]);
            return back()->with('error', 'Gagal mendapatkan prediksi perkembangan. Silakan coba lagi. Pastikan Flask API berjalan.');
        }
    }

    /**
     * Menampilkan riwayat perkembangan pengobatan SAJA (tabel tanpa grafik).
     * Nama metode diubah dari 'progress' menjadi 'viewComprehensiveHistory'
     * Ini sekarang akan menjadi halaman riwayat outcome saja.
     *
     * @return \Illuminate\View\View
     */
    public function viewComprehensiveHistory() // <--- METODE UNTUK RIWAYAT OUTCOME SAJA
    {
        $user = Auth::user();

        // Ambil riwayat perkembangan (outcome) untuk pengguna
        $outcomeResults = MentalHealthOutcome::where('user_id', $user->id)
                                           ->latest('timestamp')
                                           ->paginate(10); // Gunakan paginate

        // Helper maps untuk ditampilkan di tabel (hanya outcome)
        $outcomeNameMap = $this->getOutcomeNameMap();
        $diagnosisNameMap = $this->getDiagnosisNameMap(); // Diperlukan untuk mapping di tabel outcome

        // Logika untuk Admin melihat semua data
        if (Auth::user()->isAdmin()) {
            $allOutcomeResults = MentalHealthOutcome::latest('timestamp')->paginate(10); // Gunakan paginate untuk admin

            return view('outcome.full_history', compact( // View ini akan menampilkan tabel
                'allOutcomeResults', 
                'outcomeNameMap', 
                'diagnosisNameMap' // Diperlukan untuk mapping Diagnosis di input_data
            ));
        } else {
            // Untuk pengguna biasa, kirim data yang difilter
            return view('outcome.full_history', compact( // View ini akan menampilkan tabel
                'outcomeResults', 
                'outcomeNameMap',
                'diagnosisNameMap' // Diperlukan untuk mapping Diagnosis di input_data
            ));
        }
    }

    /**
     * Menampilkan detail spesifik dari satu record perkembangan.
     */
    public function show(MentalHealthOutcome $outcome)
    {
        if (Auth::user()->isAdmin() || $outcome->user_id == Auth::id()) {
            return view('outcome.show', compact('outcome'));
        }
        abort(403, 'Unauthorized action.');
    }

    /**
     * Metode ini sebelumnya 'outcomeHistoryIndex' dan sekarang tidak lagi dibutuhkan
     * jika 'viewComprehensiveHistory' menjadi halaman riwayat outcome saja.
     * Saya akan mengomentari atau menghapusnya.
     */
    /*
    public function outcomeHistoryIndex()
    {
        // Kode ini sekarang digabungkan/digantikan oleh viewComprehensiveHistory
        // jika itu yang menjadi halaman riwayat outcome tunggal.
        // Jika Anda masih ingin halaman riwayat outcome terpisah yang tidak dipaginasi,
        // maka Anda perlu nama view yang berbeda dan logika berbeda.
    }
    */

    // ... (metode helper getDiagnosisNameMap, getOutcomeNameMap, mapDiagnosisCodeToName, getDiagnosisColorClass) ...
    private function getDiagnosisNameMap() {
        return [
            0 => 'Gangguan Bipolar', 1 => 'Gangguan Kecemasan Umum',
            2 => 'Gangguan Depresi Mayor', 3 => 'Gangguan Panik',
            99 => 'Lainnya / Tidak Tahu',
        ];
    }
    private function getOutcomeNameMap() {
        return [
            0 => 'Deteriorated', 1 => 'Improved', 2 => 'No Change',
        ];
    }
    private function mapDiagnosisCodeToName($code) {
        switch ($code) {
            case 0: return 'Gangguan Bipolar'; case 1: return 'Gangguan Kecemasan Umum';
            case 2: return 'Gangguan Depresi Mayor'; case 3: return 'Gangguan Panik';
            default: return 'Tidak Diketahui';
        }
    }
    private function getDiagnosisColorClass($code) {
        switch ($code) {
            case 0: return 'text-purple-600'; case 1: return 'text-orange-600';
            case 2: return 'text-red-600';    case 3: return 'text-yellow-600';
            default: return 'text-gray-800';
        }
    }
}