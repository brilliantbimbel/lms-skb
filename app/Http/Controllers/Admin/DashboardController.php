<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_admin' => User::where('role', 'admin')->count(),
            'total_tutor' => User::where('role', 'guru')->count(), // Menghitung Tutor / Pamong
            'total_siswa' => User::where('role', 'siswa')->count(), // Menghitung Warga Belajar
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
