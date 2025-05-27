<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\FlaskApiService; // Pastikan ini diimport
use App\Models\MentalHealthOutcome; // Pastikan ini diimport
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log; // Pastikan ini diimport

class OutcomeController extends Controller
{
    // <--- PASTIKAN DEKLARASI PROPERTI INI ADA DAN BENAR --->
    protected $flaskApiService; 

    public function __construct(FlaskApiService $flaskApiService)
    {
        $this->flaskApiService = $flaskApiService;
    }

    // ... (metode create(), store(), progress(), show()) ...

    /**
     * Menampilkan form kuesioner perkembangan pengobatan.
     * Dapat diakses oleh pengguna biasa dan admin (sesuai pengaturan rute).
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('outcome.create');
    }

    /**
     * Memproses data yang disubmit dari form perkembangan pengobatan.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response|\Illuminate\View\View
     */
    public function store(Request $request)
    {
        // ... (kode store Anda, menggunakan $this->flaskApiService->predictOutcome) ...
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

        $prediction = $this->flaskApiService->predictOutcome($inputForFlask); // Mengakses properti

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
     */
    public function progress()
    {
        // ... (kode progress Anda, mungkin tidak langsung menggunakan flaskApiService) ...
        if (Auth::user()->isAdmin()) {
            $outcomes = MentalHealthOutcome::latest()->paginate(10);
            return view('admin.outcome.progress', compact('outcomes'));
        } else {
            $outcomes = MentalHealthOutcome::where('user_id', Auth::id())
                                           ->latest()
                                           ->paginate(10);
            return view('outcome.progress', compact('outcomes'));
        }
    }

    /**
     * Menampilkan detail spesifik dari satu record perkembangan.
     */
    public function show(MentalHealthOutcome $outcome)
    {
        // ... (kode show Anda) ...
        if (Auth::user()->isAdmin() || $outcome->user_id == Auth::id()) {
            return view('outcome.show', compact('outcome'));
        }
        abort(403, 'Unauthorized action.');
    }
}