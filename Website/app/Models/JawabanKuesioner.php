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
        'diagnosis',
        'symptom_severity',
        'mood_score',
        'sleep_quality',
        'physical_activity',
        'medication',
        'therapy_type',
        'treatment_duration',
        'stress_level',
        'treatment_progress',
        'emotional_state',
        'adherence_treatment',
        'concentration',
        'social_support',
        'optimism',
        'stopped_treatment',
        'eating_changes',
        'meaning_of_life',
    ];

    // Jika ada relasi, definisikan di sini
}