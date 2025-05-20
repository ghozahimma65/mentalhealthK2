<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prediction extends Model
{
    protected $fillable = [
        'admin_id',
        'Age',
        'Gender',
        'Symptom_Severity',
        'Mood_Score',
        'Sleep_Quality',
        'Physical_Activity',
        'Medication',
        'Therapy_Type',
        'Treatment_Duration',
        'Stress_Level',
        'Outcome',
        'Treatment_Progress',
        'AI_Detected_Emotional_State',
        'Adherence_to_Treatment',
        'Diagnosis'
    ];
}
