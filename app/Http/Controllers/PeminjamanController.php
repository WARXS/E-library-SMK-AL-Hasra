<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\Buku;
use Illuminate\Support\Facades\Auth;

class PeminjamanController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'buku_id' => 'required|exists:bukus,id',
        ]);

        $buku = Buku::findOrFail($request->buku_id);

        if ($buku->stok < 1) {
            return back()->with('error', 'Maaf, stok buku sedang habis!');
        }

        Peminjaman::create([
            'user_id' => Auth::id(),
            'buku_id' => $buku->id,
            'tanggal_pinjam' => now()->toDateString(),
            'tanggal_kembali' => now()->addDays(7)->toDateString(),
            'status' => 'pending',
        ]);

        return back()->with('success', 'Pengajuan peminjaman berhasil dikirim! Menunggu persetujuan admin.');
    }

    
    public function riwayat()
    {
    $peminjamans = Peminjaman::with('buku')
        ->where('user_id', Auth::id())
        ->latest()
        ->get();

    return view('admin.peminjaman.riwayat', compact('peminjamans'));
    }

}