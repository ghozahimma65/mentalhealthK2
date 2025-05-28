<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model; 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User; 

class DiagnosisResult extends Model
{
    use HasFactory;

    protected $connection = 'mongodb';
    protected $collection = 'diagnosis_results';
    protected $primaryKey = '_id';

    protected $fillable = [
        'user_id',          
        'input_data',
        'predicted_diagnosis',
        'timestamp',        
    ];

    protected $casts = [
        'user_id' => 'string',
        'input_data' => 'array',
        'timestamp' => 'datetime',
    ];

    public $timestamps = false;
}