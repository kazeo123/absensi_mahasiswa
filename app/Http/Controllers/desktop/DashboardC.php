<?php

namespace App\Http\Controllers\desktop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardC extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Dashboard Presensi',
        ];
        return view('desktop.dashboard', $data);
    }
}
