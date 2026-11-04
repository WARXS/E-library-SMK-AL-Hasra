<?php

namespace Tests\Feature\Admin;

use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BukuStockTest extends TestCase
{
    use RefreshDatabase;

    public function test_book_creation_rejects_negative_stock(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)
            ->from(route('admin.buku.create'))
            ->post(route('admin.buku.store'), $this->bookData(stok: -1));

        $response->assertRedirect(route('admin.buku.create'));
        $response->assertSessionHasErrors('stok');
        $this->assertDatabaseCount('bukus', 0);
    }

    public function test_book_creation_rejects_non_integer_stock(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)
            ->from(route('admin.buku.create'))
            ->post(route('admin.buku.store'), $this->bookData(stok: '1.5'));

        $response->assertSessionHasErrors('stok');
        $this->assertDatabaseCount('bukus', 0);
    }

    public function test_book_update_rejects_negative_stock(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $buku = $this->createBuku(stok: 4);

        $response = $this->actingAs($admin)
            ->from(route('admin.buku.edit', $buku))
            ->put(route('admin.buku.update', $buku), $this->bookData(stok: -1) + [
                'stok_saat_dimuat' => 4,
            ]);

        $response->assertSessionHasErrors('stok');
        $this->assertSame(4, $buku->fresh()->stok);
    }

    public function test_available_stock_can_be_adjusted_without_changing_active_loan_history(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $siswa = User::factory()->create(['role' => 'siswa']);
        $buku = $this->createBuku(stok: 7);
        $peminjaman = $this->createPeminjaman($siswa, $buku);

        $response = $this->actingAs($admin)->put(
            route('admin.buku.update', $buku),
            $this->bookData(stok: 6) + ['stok_saat_dimuat' => 7]
        );

        $response->assertRedirect(route('admin.buku.index'));
        $this->assertSame(6, $buku->fresh()->stok);
        $this->assertDatabaseHas('peminjamen', [
            'id' => $peminjaman->id,
            'status' => 'dipinjam',
            'tanggal_pinjam' => $peminjaman->tanggal_pinjam,
            'tanggal_kembali' => $peminjaman->tanggal_kembali,
        ]);
    }

    public function test_stale_book_form_cannot_restore_stock_changed_by_a_loan_transaction(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $siswa = User::factory()->create(['role' => 'siswa']);
        $buku = $this->createBuku(stok: 7);
        $peminjaman = $this->createPeminjaman($siswa, $buku);

        // Simulate an approval/offline loan changing available stock after the edit form was opened.
        $buku->update(['stok' => 6]);

        $response = $this->actingAs($admin)
            ->put(route('admin.buku.update', $buku), $this->bookData(stok: 7) + [
                'stok_saat_dimuat' => 7,
            ]);

        $response->assertRedirect(route('admin.buku.edit', $buku));
        $response->assertSessionHas('error');
        $this->assertSame(6, $buku->fresh()->stok);
        $this->assertSame('dipinjam', $peminjaman->fresh()->status);
    }

    private function bookData(int|string $stok): array
    {
        return [
            'judul' => 'Buku Test',
            'penulis' => 'Penulis Test',
            'penerbit' => 'Penerbit Test',
            'tahun_terbit' => 2025,
            'stok' => $stok,
        ];
    }

    private function createBuku(int $stok): Buku
    {
        return Buku::create($this->bookData($stok));
    }

    private function createPeminjaman(User $siswa, Buku $buku): Peminjaman
    {
        return Peminjaman::create([
            'user_id' => $siswa->id,
            'buku_id' => $buku->id,
            'tanggal_pinjam' => now()->toDateString(),
            'tanggal_kembali' => now()->addDays(7)->toDateString(),
            'status' => 'dipinjam',
        ]);
    }
}
