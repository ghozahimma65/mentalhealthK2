<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model; // Gunakan ini, bukan Eloquent biasa

class JawabanKuesioner extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'jawaban_kuesioner';

    protected $fillable = [
        'age',
        'gender',
        'symptom_severity',
        'mood_score',
        'sleep_quality',
        'physical_activity',
        'stress_level',
        'ai_detected_emotional_state'
    ];

    // Jika ada relasi, definisikan di sini
}