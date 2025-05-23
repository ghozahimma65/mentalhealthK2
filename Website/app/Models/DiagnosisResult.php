<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model; // Import model dari package MongoDB

class DiagnosisResult extends Model
{
    protected $connection = 'mongodb'; // Pastikan koneksi ke MongoDB
    protected $collection = 'diagnosis_results'; // Nama koleksi di MongoDB

    protected $fillable = [
        'user_id',
        'input_data',
        'predicted_diagnosis',
        'timestamp',
    ];
}