<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\User;
use App\Models\Peminjaman;

class DashboardController extends Controller
{
    public function index()
    {
        $totalBuku = Buku::count();

        $totalSiswa = User::where('role', 'siswa')->count();

        $totalPeminjaman = Peminjaman::count();

        $menunggu = Peminjaman::where('status', 'pending')->count();

        return view('admin.dashboard', compact(
            'totalBuku',
            'totalSiswa',
            'totalPeminjaman',
            'menunggu'
        ));
    }
}