<?php

// app/Http/Controllers/HistoryController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use App\Models\Prediction; // Jika Anda menyimpan prediksi ke database

class HistoryController extends Controller
{
    public function index()
    {
        // Ambil data riwayat dari database jika disimpan
        // $predictions = Prediction::all(); // Contoh jika Anda menyimpan

        return view('predictions.history'); // Arahkan ke view history
    }
}