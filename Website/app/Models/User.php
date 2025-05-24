<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use MongoDB\Laravel\Auth\User as Authenticatable; // Menggunakan Authenticatable dari package MongoDB Laravel
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Tentukan koneksi database yang digunakan oleh model.
     * Ini harus sesuai dengan nama koneksi di config/database.php
     * yang mengarah ke MongoDB.
     *
     * @var string
     */
    protected $connection = 'mongodb';

    /**
     * Tentukan nama koleksi MongoDB yang digunakan oleh model.
     * Secara default, Eloquent akan mencari nama koleksi plural dari nama model (misal: 'users').
     * Menentukannya secara eksplisit di sini untuk kejelasan.
     *
     * @var string
     */
    protected $collection = 'users';

    /**
     * Atribut yang dapat diisi secara massal (mass assignable).
     * Pastikan 'role' ada di sini agar bisa disimpan saat membuat atau memperbarui user.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role', 
    ];

    /**
     * Atribut yang harus disembunyikan untuk serialisasi.
     * Ini berarti atribut ini tidak akan disertakan saat model diubah menjadi array atau JSON.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Dapatkan atribut yang harus di-cast ke tipe tertentu.
     * 'email_verified_at' di-cast ke 'datetime' untuk penanganan tanggal yang tepat.
     * 'password' di-cast ke 'hashed' untuk memastikan password selalu di-hash.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Fungsi helper untuk memeriksa apakah pengguna saat ini adalah admin.
     * Ini akan mempermudah pengecekan peran di middleware atau view.
     *
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Fungsi helper untuk memeriksa apakah pengguna saat ini adalah pengguna biasa.
     *
     * @return bool
     */
    public function isUser(): bool
    {
        return $this->role === 'user';
    }
}