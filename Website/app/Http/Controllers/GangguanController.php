<?php

namespace App\Http\Controllers;

use App\Models\Gangguan;
use Illuminate\Http\Request;

class GangguanController extends Controller
{
    public function show($id)
    {
        $gangguan = Gangguan::findOrFail($id);
        return view('gangguan.detail', [
            'kode' => $gangguan->kode,
            'nama_gangguan' => $gangguan->nama,
            'kesimpulan' => $gangguan->kesimpulan,
            'path_gambar' => $gangguan->path_gambar,
            'deskripsi_gangguan' => $gangguan->deskripsi,
            'poin_deskripsi' => $gangguan->poin_deskripsi,
        ]);
    }
}

