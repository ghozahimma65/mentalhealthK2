<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gejala;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {

        return view('admin.dashboard');
    }
}
