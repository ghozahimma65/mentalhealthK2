<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Diagnosis; // Asumsi Anda punya model Diagnosis
use App\Models\Notification; // Asumsi Anda punya model Notification

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Statistik Diagnosa
        $diagnosesCount = $user->diagnoses()->count(); // Hitung jumlah diagnosa
        $latestDiagnosis = $user->diagnoses()->latest()->first(); // Ambil diagnosa terakhir

        // Contoh Notifikasi (sesuaikan dengan logika aplikasi Anda)
        $notifications = Notification::where('user_id', $user->id)
                                     ->where('is_read', false)
                                     ->orderBy('created_at', 'desc')
                                     ->take(3) // Ambil 3 notifikasi terbaru
                                     ->get();

        // Contoh untuk memberi warna pada hasil diagnosis terakhir
        // Anda perlu menyesuaikan ini dengan logika hasil diagnosis di aplikasi Anda
        if ($latestDiagnosis) {
            // Contoh sederhana: jika hasil adalah 'Positif', beri warna merah
            // Anda mungkin memiliki kolom 'severity' atau 'status' di tabel diagnosis
            if (strpos(strtolower($latestDiagnosis->result_name), 'positif') !== false) {
                $latestDiagnosis->result_class = 'text-red-600';
            } elseif (strpos(strtolower($latestDiagnosis->result_name), 'negatif') !== false || strpos(strtolower($latestDiagnosis->result_name), 'normal') !== false) {
                $latestDiagnosis->result_class = 'text-green-600';
            } else {
                $latestDiagnosis->result_class = 'text-blue-600'; // Default
            }
        }


        return view('dashboard', compact('diagnosesCount', 'latestDiagnosis', 'notifications'));
    }
}