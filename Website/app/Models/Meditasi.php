<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Meditasi extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'meditasis';

    protected $fillable = [
        'title',
        'description',
        'audio_path',
    ];
}
