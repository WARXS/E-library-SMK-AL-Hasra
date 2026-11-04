<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    protected $table = 'peminjamen'; // Menyesuaikan nama tabel hasil migrasi

    protected $fillable = [
        'user_id',
        'buku_id',
        'tanggal_pinjam',
        'tanggal_kembali',
        'tanggal_pengembalian_aktual',
        'status',
    ];

    // Relasi ke User (Siswa yang meminjam)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Buku (Buku yang dipinjam)
    public function buku()
    {
        return $this->belongsTo(Buku::class);
    }
}