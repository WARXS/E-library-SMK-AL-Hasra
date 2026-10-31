<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Buku; // Tambahkan ini agar Model Buku dikenali

class BukuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Buku::create([
            'judul' => 'Pemrograman Web & Perangkat Bergerak',
            'penulis' => 'Tim IT SMK Al-Hasra',
            'penerbit' => 'Media Edukasi',
            'tahun_terbit' => 2025,
            'stok' => 10,
        ]);

        Buku::create([
            'judul' => 'Algoritma dan Pemrograman Dasar',
            'penulis' => 'Budi Raharjo',
            'penerbit' => 'Informatika',
            'tahun_terbit' => 2023,
            'stok' => 5,
        ]);

        Buku::create([
            'judul' => 'Desain UI/UX Menggunakan Figma',
            'penulis' => 'Siti Aminah',
            'penerbit' => 'Digital Kreatif',
            'tahun_terbit' => 2024,
            'stok' => 8,
        ]);
    }
}