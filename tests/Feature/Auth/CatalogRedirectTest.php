<?php

namespace Tests\Feature\Auth;

use App\Models\Buku;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CatalogRedirectTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_view_the_book_catalog(): void
    {
        Buku::create([
            'judul' => 'Buku Katalog',
            'penulis' => 'Penulis Test',
            'penerbit' => 'Penerbit Test',
            'tahun_terbit' => 2025,
            'stok' => 2,
        ]);

        $response = $this->get(route('buku.index'));

        $response->assertOk();
        $response->assertSee('Buku Katalog');
        $response->assertSee(route('peminjaman.store'));
    }

    public function test_guest_is_sent_to_login_when_submitting_a_loan_request(): void
    {
        $buku = Buku::create([
            'judul' => 'Buku Katalog',
            'penulis' => 'Penulis Test',
            'penerbit' => 'Penerbit Test',
            'tahun_terbit' => 2025,
            'stok' => 2,
        ]);

        $response = $this->from(route('buku.index'))
            ->post(route('peminjaman.store'), ['buku_id' => $buku->id]);

        $response->assertRedirect(route('login'));
        $this->assertDatabaseCount('peminjamen', 0);
    }

    public function test_student_returns_to_catalog_after_login_from_loan_submission(): void
    {
        $siswa = User::factory()->create([
            'role' => 'siswa',
            'email' => 'siswa-katalog@example.test',
            'password' => 'password',
        ]);
        $buku = Buku::create([
            'judul' => 'Buku Katalog',
            'penulis' => 'Penulis Test',
            'penerbit' => 'Penerbit Test',
            'tahun_terbit' => 2025,
            'stok' => 2,
        ]);

        $this->from(route('buku.index'))
            ->post(route('peminjaman.store'), ['buku_id' => $buku->id])
            ->assertRedirect(route('login'));

        $response = $this->post(route('login'), [
            'email' => $siswa->email,
            'password' => 'password',
        ]);

        $response->assertRedirect(route('buku.index'));
        $this->assertDatabaseCount('peminjamen', 0);
    }

    public function test_student_without_catalog_intended_url_is_sent_to_student_dashboard(): void
    {
        $siswa = User::factory()->create([
            'role' => 'siswa',
            'email' => 'siswa-dashboard@example.test',
            'password' => 'password',
        ]);

        $response = $this->post(route('login'), [
            'email' => $siswa->email,
            'password' => 'password',
        ]);

        $response->assertRedirect(route('siswa.dashboard'));
    }

    public function test_admin_is_sent_to_admin_dashboard_even_with_catalog_intended_url(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'email' => 'admin-katalog@example.test',
            'password' => 'password',
        ]);

        $response = $this->withSession([
            'url.intended' => route('peminjaman.store'),
        ])->post(route('login'), [
            'email' => $admin->email,
            'password' => 'password',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
    }

    public function test_external_intended_url_never_redirects_student_off_site(): void
    {
        $siswa = User::factory()->create([
            'role' => 'siswa',
            'email' => 'siswa-external@example.test',
            'password' => 'password',
        ]);

        $response = $this->withSession([
            'url.intended' => 'https://attacker.example/steal-session',
        ])->post(route('login'), [
            'email' => $siswa->email,
            'password' => 'password',
        ]);

        $response->assertRedirect(route('siswa.dashboard'));
        $this->assertStringStartsWith(config('app.url'), $response->headers->get('Location'));
    }
}
