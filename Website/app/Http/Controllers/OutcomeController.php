<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\FlaskApiService;
use App\Models\MentalHealthOutcome;
use App\Models\DiagnosisResult; // <--- PASTIKAN INI DIIMPORT
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon; // <--- PASTIKAN INI DIIMPORT untuk format tanggal

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
     * Menampilkan riwayat atau tren perkembangan pengobatan.
     * Dapat diakses oleh pengguna biasa dan admin.
     *
     * @return \Illuminate\View\View
     */
    public function progress()
    {
        $user = Auth::user();

        // Ambil riwayat diagnosis awal untuk pengguna
        $diagnosisResults = DiagnosisResult::where('user_id', $user->id)
                                          ->latest('timestamp')
                                          ->get(); // Ambil semua untuk digabungkan

        // Ambil riwayat perkembangan (outcome) untuk pengguna
        $outcomeResults = MentalHealthOutcome::where('user_id', $user->id)
                                           ->latest('timestamp')
                                           ->get(); // Ambil semua untuk digabungkan
        
        // Data untuk Chart.js (dari outcome saja) - Ini akan ditampilkan di halaman progress juga
        $chartLabels = [];
        $chartData = [];
        $plotValueMap = [0 => 0, 2 => 1, 1 => 2]; // Map untuk nilai plot (0=Memburuk, 1=Tidak Berubah, 2=Membaik)
        $plotLabelsMap = [0 => 'Memburuk', 1 => 'Tidak Berubah', 2 => 'Membaik']; // Map untuk label Y-axis

        foreach ($outcomeResults as $outcome) {
            $chartLabels[] = Carbon::parse($outcome->timestamp)->format('d M'); 
            $chartData[] = $plotValueMap[$outcome->predicted_outcome] ?? null; 
        }

        // Helper maps untuk ditampilkan di tabel
        $diagnosisNameMap = $this->getDiagnosisNameMap();
        $outcomeNameMap = $this->getOutcomeNameMap();


        // Logika untuk Admin melihat semua data
        if (Auth::user()->isAdmin()) {
            // Ambil semua data diagnosis & outcome untuk admin
            $allDiagnosisResults = DiagnosisResult::latest('timestamp')->get();
            $allOutcomeResults = MentalHealthOutcome::latest('timestamp')->get();

            return view('admin.outcome.progress', compact(
                'allDiagnosisResults', 
                'allOutcomeResults', 
                'diagnosisNameMap', 
                'outcomeNameMap'
            ));
        } else {
            // Untuk pengguna biasa, kirim data yang difilter dan data chart
            return view('outcome.progress', compact(
                'diagnosisResults', 
                'outcomeResults', 
                'diagnosisNameMap', 
                'outcomeNameMap',
                'chartLabels',
                'chartData',
                'plotLabelsMap'
            ));
        }
    }

    /**
     * Menampilkan detail spesifik dari satu record perkembangan.
     *
     * @param MentalHealthOutcome $outcome
     * @return \Illuminate\View\View
     */
    public function show(MentalHealthOutcome $outcome)
    {
        // Pastikan pengguna memiliki hak akses untuk melihat outcome ini
        // (Misalnya, hanya pemilik atau admin)
        if (Auth::user()->isAdmin() || $outcome->user_id == Auth::id()) {
            return view('outcome.show', compact('outcome')); // Asumsi outcome.show menampilkan detail satu record
        }
        abort(403, 'Unauthorized action.');
    }

    /**
     * Helper: Memetakan kode diagnosis ke nama.
     * Harus ada di dalam kelas ini.
     * @return array
     */
    private function getDiagnosisNameMap()
    {
        return [
            0 => 'Gangguan Bipolar',
            1 => 'Gangguan Kecemasan Umum',
            2 => 'Gangguan Depresi Mayor',
            3 => 'Gangguan Panik',
            99 => 'Lainnya / Tidak Tahu',
        ];
    }

    /**
     * Helper: Memetakan kode outcome ke nama.
     * Harus ada di dalam kelas ini.
     * @return array
     */
    private function getOutcomeNameMap()
    {
        return [
            0 => 'Deteriorated',
            1 => 'Improved',
            2 => 'No Change',
        ];
    }
    // Jika Anda juga perlu mapDiagnosisCodeToName dan getDiagnosisColorClass di controller ini
    // dan belum ada, Anda bisa menambahkannya di sini.
    // private function mapDiagnosisCodeToName($code) { /* ... */ return ''; }
    // private function getDiagnosisColorClass($code) { /* ... */ return ''; }
}