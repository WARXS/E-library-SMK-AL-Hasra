<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $menunggu = Peminjaman::where('user_id', $userId)
            ->where('status', 'pending')
            ->count();

        $sedangDipinjam = Peminjaman::where('user_id', $userId)
            ->where('status', 'dipinjam')
            ->count();

        $sudahDikembalikan = Peminjaman::where('user_id', $userId)
            ->where('status', 'dikembalikan')
            ->count();

        return view('siswa.dashboard', compact(
            'menunggu',
            'sedangDipinjam',
            'sudahDikembalikan'
        ));
    }
}
