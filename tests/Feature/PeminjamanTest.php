<?php

namespace Tests\Feature;

use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PeminjamanTest extends TestCase
{
    use RefreshDatabase;

    public function test_siswa_cannot_access_admin_pages(): void
    {
        $siswa = User::factory()->create(['role' => 'siswa']);

        $response = $this->actingAs($siswa)->get(route('admin.dashboard'));

        $response->assertForbidden();
    }

    public function test_online_application_is_pending_and_does_not_reduce_stock(): void
    {
        $siswa = User::factory()->create(['role' => 'siswa']);
        $buku = $this->createBuku(stok: 3);

        $response = $this->actingAs($siswa)->post(route('peminjaman.store'), [
            'buku_id' => $buku->id,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('peminjamen', [
            'user_id' => $siswa->id,
            'buku_id' => $buku->id,
            'status' => 'pending',
        ]);
        $this->assertSame(3, $buku->fresh()->stok);
    }

    public function test_approval_marks_loan_as_borrowed_and_reduces_stock(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $siswa = User::factory()->create(['role' => 'siswa']);
        $buku = $this->createBuku(stok: 3);
        $peminjaman = $this->createPeminjaman($siswa, $buku, 'pending');

        $response = $this->actingAs($admin)
            ->from(route('admin.peminjaman.index'))
            ->patch(route('admin.peminjaman.approve', $peminjaman));

        $response->assertRedirect(route('admin.peminjaman.index'));
        $response->assertSessionHas('success');
        $this->assertSame('dipinjam', $peminjaman->fresh()->status);
        $this->assertSame(2, $buku->fresh()->stok);
    }

    public function test_rejection_marks_loan_rejected_without_reducing_stock(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $siswa = User::factory()->create(['role' => 'siswa']);
        $buku = $this->createBuku(stok: 3);
        $peminjaman = $this->createPeminjaman($siswa, $buku, 'pending');

        $response = $this->actingAs($admin)
            ->from(route('admin.peminjaman.index'))
            ->patch(route('admin.peminjaman.reject', $peminjaman));

        $response->assertRedirect(route('admin.peminjaman.index'));
        $response->assertSessionHas('success');
        $this->assertSame('ditolak', $peminjaman->fresh()->status);
        $this->assertSame(3, $buku->fresh()->stok);
    }

    public function test_rejection_cannot_change_a_loan_that_is_not_pending(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $siswa = User::factory()->create(['role' => 'siswa']);
        $buku = $this->createBuku(stok: 3);

        foreach (['dipinjam', 'dikembalikan', 'ditolak'] as $status) {
            $peminjaman = $this->createPeminjaman($siswa, $buku, $status);

            $response = $this->actingAs($admin)
                ->from(route('admin.peminjaman.index'))
                ->patch(route('admin.peminjaman.reject', $peminjaman));

            $response->assertRedirect(route('admin.peminjaman.index'));
            $response->assertSessionHas('error', 'Pengajuan ini sudah diproses.');
            $this->assertSame($status, $peminjaman->fresh()->status);
            $this->assertSame(3, $buku->fresh()->stok);
        }
    }

    public function test_repeated_rejection_does_not_report_success_or_change_stock_twice(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $siswa = User::factory()->create(['role' => 'siswa']);
        $buku = $this->createBuku(stok: 3);
        $peminjaman = $this->createPeminjaman($siswa, $buku, 'pending');

        $firstResponse = $this->actingAs($admin)
            ->from(route('admin.peminjaman.index'))
            ->patch(route('admin.peminjaman.reject', $peminjaman));

        $firstResponse->assertSessionHas('success', 'Pengajuan berhasil ditolak!');

        $secondResponse = $this->actingAs($admin)
            ->from(route('admin.peminjaman.index'))
            ->patch(route('admin.peminjaman.reject', $peminjaman));

        $secondResponse->assertSessionHas('error', 'Pengajuan ini sudah diproses.');
        $secondResponse->assertSessionMissing('success');
        $this->assertSame('ditolak', $peminjaman->fresh()->status);
        $this->assertSame(3, $buku->fresh()->stok);
    }

    public function test_offline_loan_is_immediately_borrowed_and_reduces_stock(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $siswa = User::factory()->create(['role' => 'siswa']);
        $buku = $this->createBuku(stok: 3);

        $response = $this->actingAs($admin)->post(route('admin.peminjaman.store'), [
            'user_id' => $siswa->id,
            'buku_id' => $buku->id,
            'tanggal_pinjam' => now()->toDateString(),
            'tanggal_kembali' => now()->addDays(7)->toDateString(),
        ]);

        $response->assertRedirect(route('admin.peminjaman.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('peminjamen', [
            'user_id' => $siswa->id,
            'buku_id' => $buku->id,
            'status' => 'dipinjam',
        ]);
        $this->assertSame(2, $buku->fresh()->stok);
    }

    public function test_return_increases_stock_and_cannot_be_recorded_twice(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $siswa = User::factory()->create(['role' => 'siswa']);
        $buku = $this->createBuku(stok: 2);
        $peminjaman = $this->createPeminjaman($siswa, $buku, 'dipinjam');

        $firstResponse = $this->actingAs($admin)
            ->from(route('admin.peminjaman.index'))
            ->patch(route('admin.peminjaman.return', $peminjaman));

        $firstResponse->assertRedirect(route('admin.peminjaman.index'));
        $firstResponse->assertSessionHas('success');
        $this->assertSame('dikembalikan', $peminjaman->fresh()->status);
        $this->assertNotNull($peminjaman->fresh()->tanggal_pengembalian_aktual);
        $this->assertSame(3, $buku->fresh()->stok);

        $secondResponse = $this->actingAs($admin)
            ->from(route('admin.peminjaman.index'))
            ->patch(route('admin.peminjaman.return', $peminjaman));

        $secondResponse->assertRedirect(route('admin.peminjaman.index'));
        $secondResponse->assertSessionHas('error', 'Buku ini tidak sedang dipinjam.');
        $this->assertSame('dikembalikan', $peminjaman->fresh()->status);
        $this->assertSame(3, $buku->fresh()->stok);
    }

    public function test_approval_is_rejected_when_stock_is_empty(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $siswa = User::factory()->create(['role' => 'siswa']);
        $buku = $this->createBuku(stok: 0);
        $peminjaman = $this->createPeminjaman($siswa, $buku, 'pending');

        $response = $this->actingAs($admin)
            ->from(route('admin.peminjaman.index'))
            ->patch(route('admin.peminjaman.approve', $peminjaman));

        $response->assertRedirect(route('admin.peminjaman.index'));
        $response->assertSessionHas('error', 'Stok buku habis. Pengajuan tidak dapat disetujui.');
        $this->assertSame('pending', $peminjaman->fresh()->status);
        $this->assertSame(0, $buku->fresh()->stok);
    }

    private function createBuku(int $stok): Buku
    {
        return Buku::create([
            'judul' => 'Buku Test',
            'penulis' => 'Penulis Test',
            'penerbit' => 'Penerbit Test',
            'tahun_terbit' => 2025,
            'stok' => $stok,
        ]);
    }

    private function createPeminjaman(User $siswa, Buku $buku, string $status): Peminjaman
    {
        return Peminjaman::create([
            'user_id' => $siswa->id,
            'buku_id' => $buku->id,
            'tanggal_pinjam' => now()->toDateString(),
            'tanggal_kembali' => now()->addDays(7)->toDateString(),
            'status' => $status,
        ]);
    }
}
