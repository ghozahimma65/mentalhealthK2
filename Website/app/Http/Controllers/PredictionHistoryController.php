<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DiagnosisResult;
use App\Models\MentalHealthOutcome;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PredictionHistoryController extends Controller
{
    /**
     * Menampilkan daftar riwayat diagnosis awal saja (seperti sebelumnya).
     * Ini dipanggil oleh route('predictions.history').
     */
    public function diagnosisHistoryIndex()
    {
        $user = Auth::user();
        $diagnosisResults = DiagnosisResult::where('user_id', $user->id)
                                             ->latest('timestamp')
                                             ->paginate(10); 
        $diagnosisNameMap = $this->getDiagnosisNameMap();
        return view('diagnosis.history', compact('diagnosisResults', 'diagnosisNameMap'));
    }

    /**
     * Menampilkan detail spesifik dari satu record diagnosis awal.
     * Dipanggil oleh route('predictions.show').
     */
    public function diagnosisHistoryShow(DiagnosisResult $diagnosisResult)
    {
        $user = Auth::user();
        if ($diagnosisResult->user_id !== $user->id && !$user->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }
        $diagnosisNameMap = $this->getDiagnosisNameMap();
        return view('diagnosis.show', compact('diagnosisResult', 'diagnosisNameMap'));
    }

    /**
     * Menampilkan halaman pilihan tipe riwayat.
     * Ini adalah halaman utama yang akan menampilkan pilihan antara riwayat diagnosis atau outcome.
     * Dipanggil oleh route('history.select_type').
     *
     * @return \Illuminate\View\View
     */
    public function selectHistoryType()
    {
        return view('history.select_type'); // Mengembalikan view untuk halaman pilihan
    }


    // --- HELPER FUNCTIONS ---
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
    private function getOutcomeNameMap()
    {
        return [
            0 => 'Deteriorated',
            1 => 'Improved',
            2 => 'No Change',
        ];
    }
}