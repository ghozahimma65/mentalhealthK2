<?php

namespace App\Http\Controllers\Admin; // Pastikan namespace ini sesuai dengan lokasi file

use Illuminate\Http\Request;
use App\Models\MentalHealthOutcome; // Impor model MentalHealthOutcome yang sudah Anda buat
use App\Models\User; // Digunakan untuk eager loading relasi user
use App\Http\Controllers\Controller; // Impor base Controller

class RiwayatOutcomeController extends Controller
{
    /**
     * Menampilkan daftar semua riwayat outcome yang telah diproses oleh admin.
     * Logika ini disamakan dengan RiwayatDiagnosisController.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Mengambil semua riwayat outcome dari koleksi 'mental_health_outcomes'
        // Melakukan eager loading pada relasi 'user' untuk mendapatkan data nama pengguna
        // FILTER KUNCI: Ambil hanya outcome yang ditandai telah diproses oleh admin
        $riwayatOutcomes = MentalHealthOutcome::with('user')
                                           ->where('admin_processed', true) // Hanya tampilkan yang sudah diproses admin
                                           ->orderBy('timestamp', 'desc')
                                           ->get();

        // Mengarahkan ke view 'admin.riwayatoutcome' dan mengirimkan data
        return view('admin.riwayatoutcome', compact('riwayatOutcomes'));
    }
}
