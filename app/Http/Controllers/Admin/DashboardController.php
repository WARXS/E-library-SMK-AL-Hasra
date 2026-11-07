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

        $peminjamanAktif = Peminjaman::where('status', 'dipinjam')->count();

        $menunggu = Peminjaman::where('status', 'pending')->count();

        $aktivitasTerbaru = Peminjaman::with(['user:id,name', 'buku:id,judul'])
            ->latest('updated_at')
            ->latest('id')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalBuku',
            'totalSiswa',
            'peminjamanAktif',
            'menunggu',
            'aktivitasTerbaru'
        ));
    }
}
