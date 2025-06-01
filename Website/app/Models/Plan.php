<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model; // Atau use Illuminate\Database\Eloquent\Model; jika SQL

class Plan extends Model
{
    // ... (baris $connection, $collection jika ada) ...

    protected $fillable = [
        'title',
        'description',
        'is_completed', // Jika Anda punya field ini
        'user_id',      // <-- TAMBAHKAN INI
    ];

    // ... (casts atau relasi lainnya jika ada) ...
}