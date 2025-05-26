<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model; // <-- PASTIKAN INI!
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use App\Models\User; // Jika relasi dibutuhkan

class DiagnosisResult extends Model
{
    use HasFactory;

    protected $connection = 'mongodb';
    protected $collection = 'diagnosis_results';
    protected $primaryKey = '_id';

    protected $fillable = [
        'user_id',          // Pastikan user_id ada dan tipe datanya sesuai dengan ID di Auth::id()
        'input_data',
        'predicted_diagnosis',
        'timestamp',        // Pastikan ini ada di fillable
    ];

    protected $casts = [
        'input_data' => 'array',
        'timestamp' => 'datetime',
    ];

    public $timestamps = false;
}