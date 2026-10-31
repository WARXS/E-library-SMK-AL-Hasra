<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;

class BukuController extends Controller
{
    // Menampilkan daftar buku ke halaman web
    public function index()
    {
        $bukus = Buku::all(); // Mengambil semua data buku
        return view('buku.index', compact('bukus'));
    }
}