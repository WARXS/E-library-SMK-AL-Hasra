<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    // Kalau nama tabel di database kamu 'bukus', Laravel otomatis mengenalinya.
    protected $fillable = [
        'judul',
        'penulis',
        'penerbit',
        'tahun_terbit',
        'stok',
        'cover',
    ];

    // Relasi ke tabel Peminjaman (satu buku bisa dipinjam dalam banyak riwayat peminjaman)
    public function peminjamans()
    {
        return $this->hasMany(Peminjaman::class);
    }
}