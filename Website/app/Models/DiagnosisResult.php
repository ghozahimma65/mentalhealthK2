<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model; // Import model dari package MongoDB
use Illuminate\Database\Eloquent\Factories\HasFactory;
class DiagnosisResult extends Model
{
    protected $connection = 'mongodb'; // Pastikan koneksi ke MongoDB
    protected $collection = 'diagnosis_results'; // Nama koleksi di MongoDB

     protected $fillable = [
        'user_id',          // Bisa null
        'input_data',       // Array/Object dari input
        'predicted_diagnosis', // Hasil prediksi
        'timestamp',        // Waktu
    ];
}