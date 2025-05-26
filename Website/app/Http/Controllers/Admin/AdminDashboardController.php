<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gejala; // Pastikan model ini ada
// use App\Models\Depresi; // Jika Anda punya model Depresi, uncomment ini
// use App\Models\User; // Jika Anda ingin menghitung admin dari model User, uncomment ini
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Pastikan Anda sudah memiliki Model 'Gejala' atau sesuaikan dengan model Anda
        // Untuk sementara, kita pakai data dummy agar tampilan bisa diuji tanpa database error
        $gejalaCount = 10; // Nilai dummy
        $depresiCount = 5; // Nilai dummy
        $adminCount = 3;   // Nilai dummy

        // Jika Anda memiliki model dan database, ini adalah cara yang benar untuk mengambil datanya:
        // try {
        //     $gejalaCount = Gejala::count();
        // } catch (\Exception $e) {
        //     $gejalaCount = 0; // Fallback jika tabel Gejala belum ada atau error
        // }

        // try {
        //     // Ganti Depresi dengan nama model Anda yang sesuai jika ada
        //     // $depresiCount = Depresi::count();
        //     $depresiCount = 0; // Contoh jika model Depresi belum ada
        // } catch (\Exception $e) {
        //     $depresiCount = 0;
        // }

        // try {
        //     // Jika admin adalah User dengan role tertentu, contoh:
        //     // use App\Models\User;
        //     // $adminCount = User::where('role', 'admin')->count();
        //     $adminCount = 0; // Contoh jika model User atau role belum diatur
        // } catch (\Exception $e) {
        //     $adminCount = 0;
        // }
        

        // PERHATIKAN: Ubah nama view dari 'admin.dashboard' menjadi 'admin.dashboard.index'
        // karena file view Anda adalah resources/views/admin/dashboard/index.blade.php
        return view('admin.dashboard', compact('gejalaCount', 'depresiCount', 'adminCount'));
    }
}