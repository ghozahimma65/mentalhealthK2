<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DiagnosisResult;
use App\Models\User;

class RiwayatDiagnosisController extends Controller
{
    public function index()
    {
        // FILTER KUNCI: Ambil hanya diagnosis yang ditandai telah diproses oleh admin
        $riwayatDiagnoses = DiagnosisResult::with('user')
                                ->where('admin_processed', true)
                                ->orderBy('timestamp', 'desc')
                                ->get();

        return view('admin.riwayatdiagnosis', compact('riwayatDiagnoses'));
    }
}