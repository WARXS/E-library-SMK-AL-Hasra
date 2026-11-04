<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BukuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bukus = buku::latest()->get();
        return view('admin.buku.index', compact('bukus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.buku.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'penulis' => 'required|string|max:255',
            'penerbit' => 'nullable|string|max:255',
            'tahun_terbit' => 'nullable|integer|min:1000|max:9999',
            'stok' => 'required|integer|min:0',
        ]);

        Buku::create($validated);
        return redirect()->route('admin.buku.index')->with('success', 'Buku berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $buku = Buku::findOrFail($id);
        return view('admin.buku.edit', compact('buku'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'penulis' => 'required|string|max:255',
            'penerbit' => 'nullable|string|max:255',
            'tahun_terbit' => 'nullable|integer|min:1000|max:9999',
            'stok' => 'required|integer|min:0',
            'stok_saat_dimuat' => 'required|integer|min:0',
        ]);

        $stokSaatDimuat = (int) $validated['stok_saat_dimuat'];
        unset($validated['stok_saat_dimuat']);

        return DB::transaction(function () use ($validated, $id, $stokSaatDimuat) {
            $buku = Buku::whereKey($id)
                ->lockForUpdate()
                ->firstOrFail();

            if ((int) $buku->stok !== $stokSaatDimuat) {
                return redirect()
                    ->route('admin.buku.edit', $buku->id)
                    ->with('error', 'Stok tersedia berubah sejak form dibuka. Periksa stok terbaru sebelum menyimpan kembali.');
            }

            $buku->update($validated);

            return redirect()->route('admin.buku.index')->with('success', 'Buku berhasil diperbarui.');
        });
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $buku = Buku::findOrFail($id);

        if ($buku->peminjamans()->exists()) {
            return back()->with('error', 'Buku tidak dapat dihapus karena memiliki riwayat peminjaman.');
        }

        $buku->delete();

        return redirect()->route('admin.buku.index')->with('success', 'Buku berhasil dihapus.');
    }
}
