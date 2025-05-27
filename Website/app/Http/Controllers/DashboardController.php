<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\DiagnosisResult;
use App\Models\Notification;
use App\Models\MentalHealthArticle;
use App\Models\MentalHealthOutcome; 

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Statistik Diagnosa
        $diagnosesCount = DiagnosisResult::where('user_id', $user->id)->count();

        // Hasil Diagnosa Terakhir
        $latestDiagnosis = DiagnosisResult::where('user_id', $user->id)
                                          ->latest('timestamp')
                                          ->first();

        if ($latestDiagnosis) {
            $diagnosisCode = $latestDiagnosis->predicted_diagnosis;
            $latestDiagnosis->result_name = $this->mapDiagnosisCodeToName($diagnosisCode);
            $latestDiagnosis->result_class = $this->getDiagnosisColorClass($diagnosisCode);
        }

        // Notifikasi
        $notifications = Notification::where('user_id', $user->id)
                                         ->where('is_read', false)
                                         ->orderBy('created_at', 'desc')
                                         ->take(3)
                                         ->get();
        
        // Mengambil artikel kesehatan mental (jika digunakan di dashboard)
        $mentalHealthArticles = MentalHealthArticle::where('is_published', true)
                                                    ->latest()
                                                    ->take(4)
                                                    ->get();

        // --- Data untuk Grafik Tren Outcome ---
        $userOutcomes = MentalHealthOutcome::where('user_id', $user->id)
                                           ->orderBy('timestamp', 'asc') // Urutkan berdasarkan waktu paling awal
                                           ->get();

        $chartLabels = []; // Akan berisi tanggal (misal: "26 Mei")
        $chartData = [];   // Akan berisi nilai numerik untuk plot (0, 1, 2)

        // Peta nilai outcome ke nilai plot yang intuitif (lebih tinggi = lebih baik)
        $plotValueMap = [
            0 => 0, // Deteriorated
            2 => 1, // No Change
            1 => 2, // Improved
        ];
        // Peta nilai plot ke label teks yang akan ditampilkan di Y-axis Chart.js
        $plotLabelsMap = [
            0 => 'Memburuk',
            1 => 'Tidak Berubah',
            2 => 'Membaik',
        ];

        foreach ($userOutcomes as $outcome) {
            // Pastikan timestamp ada dan valid
            $chartLabels[] = \Carbon\Carbon::parse($outcome->timestamp)->format('d M'); 
            $chartData[] = $plotValueMap[$outcome->predicted_outcome] ?? null; // Gunakan nilai yang di-map
        }
        // --- Akhir Data untuk Grafik Tren Outcome ---

        return view('dashboard', compact(
            'diagnosesCount',
            'latestDiagnosis',
            'notifications',
            'mentalHealthArticles',
            'chartLabels',
            'chartData',
            'plotLabelsMap' // Kirim juga map label untuk Y-axis di Chart.js
        ));
    }

    /**
     * Helper function untuk memetakan kode diagnosis (dari Flask API) ke nama yang mudah dibaca.
     * @param int $code
     * @return string
     */
    private function mapDiagnosisCodeToName($code)
    {
        switch ($code) {
            case 0: return 'Gangguan Bipolar';
            case 1: return 'Gangguan Kecemasan Umum';
            case 2: return 'Gangguan Depresi Mayor';
            case 3: return 'Gangguan Panik';
            default: return 'Tidak Diketahui';
        }
    }

    /**
     * Helper function untuk mendapatkan kelas warna berdasarkan kode diagnosis.
     * @param int $code
     * @return string
     */
    private function getDiagnosisColorClass($code)
    {
        switch ($code) {
            case 0: return 'text-purple-600';
            case 1: return 'text-orange-600';
            case 2: return 'text-red-600';
            case 3: return 'text-yellow-600';
            default: return 'text-gray-800';
        }
    }
}