<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Siswa\DashboardController as SiswaDashboardController;
use App\Http\Controllers\Admin\PeminjamanController as AdminPeminjamanController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\Admin\BukuController as AdminBukuController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BukuController;
use Illuminate\Support\Facades\Route;

// Halaman utama
Route::get('/', function () {
    return view('welcome');
});

// Dashboard admin
Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])
    ->middleware(['auth', 'admin'])
    ->name('admin.dashboard');

// Dashboard siswa
Route::get('/siswa/dashboard', [SiswaDashboardController::class, 'index'])
    ->middleware(['auth', 'siswa'])
    ->name('siswa.dashboard');

// Dashboard umum
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Profile
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

// Katalog buku
Route::get('/katalog', [BukuController::class, 'index'])
    ->name('buku.index');

// Pengajuan peminjaman online oleh siswa
Route::post('/peminjaman', [PeminjamanController::class, 'store'])
    ->middleware(['auth', 'siswa'])
    ->name('peminjaman.store');

// Riwayat peminjaman siswa
Route::get('/riwayat-peminjaman', [PeminjamanController::class, 'riwayat'])
    ->middleware(['auth', 'siswa'])
    ->name('peminjaman.riwayat');

// Manajemen buku dan peminjaman khusus admin
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // CRUD buku
        Route::get('/buku', [AdminBukuController::class, 'index'])
            ->name('buku.index');

        Route::get('/buku/create', [AdminBukuController::class, 'create'])
            ->name('buku.create');

        Route::post('/buku', [AdminBukuController::class, 'store'])
            ->name('buku.store');

        Route::get('/buku/{id}/edit', [AdminBukuController::class, 'edit'])
            ->name('buku.edit');

        Route::put('/buku/{id}', [AdminBukuController::class, 'update'])
            ->name('buku.update');

        Route::delete('/buku/{id}', [AdminBukuController::class, 'destroy'])
            ->name('buku.destroy');

        // Form peminjaman langsung oleh admin
        Route::get('/peminjaman/create', [AdminPeminjamanController::class, 'create'])
            ->name('peminjaman.create');

        // Simpan peminjaman langsung oleh admin
        Route::post('/peminjaman', [AdminPeminjamanController::class, 'store'])
            ->name('peminjaman.store');

        // Daftar seluruh peminjaman
        Route::get('/peminjaman', [AdminPeminjamanController::class, 'index'])
            ->name('peminjaman.index');

        // Setujui pengajuan siswa
        Route::patch('/peminjaman/{id}/approve', [AdminPeminjamanController::class, 'approve'])
            ->name('peminjaman.approve');

        // Tolak pengajuan siswa
        Route::patch('/peminjaman/{id}/reject', [AdminPeminjamanController::class, 'reject'])
            ->name('peminjaman.reject');

        // Catat pengembalian buku
        Route::patch('/peminjaman/{id}/return', [AdminPeminjamanController::class, 'returnBook'])
            ->name('peminjaman.return');
    });

require __DIR__.'/auth.php';
