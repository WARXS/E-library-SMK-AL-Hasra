<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\Buku;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PeminjamanController extends Controller
{
    // Menampilkan seluruh data peminjaman
    public function index()
    {
        $peminjamans = Peminjaman::with(['user', 'buku'])
            ->latest()
            ->get();

        return view('admin.peminjaman.index', compact('peminjamans'));
    }

    // Menampilkan formulir peminjaman langsung
    public function create()
    {
        $siswas = User::where('role', 'siswa')
            ->orderBy('name')
            ->get();

        $bukus = Buku::where('stok', '>', 0)
            ->orderBy('judul')
            ->get();

        return view('admin.peminjaman.create', compact('siswas', 'bukus'));
    }

    // Menyimpan peminjaman langsung oleh admin
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'buku_id' => 'required|exists:bukus,id',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'required|date|after_or_equal:tanggal_pinjam',
        ]);

        // Pastikan akun yang dipilih benar-benar siswa
        $siswa = User::where('id', $validated['user_id'])
            ->where('role', 'siswa')
            ->first();

        if (!$siswa) {
            return back()
                ->withInput()
                ->withErrors(['user_id' => 'Akun yang dipilih bukan siswa.']);
        }

        return DB::transaction(function () use ($validated) {
            $buku = Buku::where('id', $validated['buku_id'])
                ->lockForUpdate()
                ->firstOrFail();

            if ($buku->stok < 1) {
                return back()
                    ->withInput()
                    ->with('error', 'Stok buku habis. Peminjaman tidak dapat dicatat.');
            }

            Peminjaman::create([
                'user_id' => $validated['user_id'],
                'buku_id' => $validated['buku_id'],
                'tanggal_pinjam' => $validated['tanggal_pinjam'],
                'tanggal_kembali' => $validated['tanggal_kembali'],
                'status' => 'dipinjam',
            ]);

            $buku->decrement('stok');

            return redirect()
                ->route('admin.peminjaman.index')
                ->with('success', 'Peminjaman langsung berhasil dicatat!');
        });
    }

    // Menyetujui pengajuan siswa
    public function approve(string $id)
    {
        return DB::transaction(function () use ($id) {
            $peminjaman = Peminjaman::where('id', $id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($peminjaman->status !== 'pending') {
                return back()->with('error', 'Pengajuan ini sudah diproses.');
            }

            $buku = Buku::where('id', $peminjaman->buku_id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($buku->stok < 1) {
                return back()->with('error', 'Stok buku habis. Pengajuan tidak dapat disetujui.');
            }

            $buku->decrement('stok');

            $peminjaman->update([
                'status' => 'dipinjam',
            ]);

            return back()->with('success', 'Peminjaman berhasil disetujui!');
        });
    }

    // Menolak pengajuan siswa
    public function reject(string $id)
    {
        return DB::transaction(function () use ($id) {
            $peminjaman = Peminjaman::whereKey($id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($peminjaman->status !== 'pending') {
                return back()->with('error', 'Pengajuan ini sudah diproses.');
            }

            $peminjaman->update([
                'status' => 'ditolak',
            ]);

            return back()->with('success', 'Pengajuan berhasil ditolak!');
        });
    }

    // Mencatat pengembalian buku
    public function returnBook(string $id)
    {
        return DB::transaction(function () use ($id) {
            $peminjaman = Peminjaman::where('id', $id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($peminjaman->status !== 'dipinjam') {
                return back()->with('error', 'Buku ini tidak sedang dipinjam.');
            }

            $buku = Buku::where('id', $peminjaman->buku_id)
                ->lockForUpdate()
                ->firstOrFail();

            $buku->increment('stok');

            $peminjaman->update([
                'status' => 'dikembalikan',
                'tanggal_pengembalian_aktual' => now()->toDateString(),
            ]);

            return back()->with(
                'success',
                'Buku berhasil dikembalikan dan stok telah diperbarui!'
            );
        });
    }
}
