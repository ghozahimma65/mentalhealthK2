<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Plan extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'plans'; // Sesuai dengan nama koleksi di MongoDB

    protected $fillable = [
        'title',
        'description',
        // Tambahkan field lain jika ada, seperti user_id jika ini terkait dengan pengguna
    ];

    // Jika Anda ingin mengelola timestamps secara otomatis (created_at, updated_at)
    // pastikan field ini ada di MongoDB atau biarkan Eloquent yang menambahkannya
    protected $dates = ['created_at', 'updated_at'];
}