<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#f8fafc">
    <title>Dashboard Admin - Library Al-Hasra</title>
    <x-theme-init />
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/css/design-tokens.css', 'resources/js/theme.js'])
</head>
<body class="min-h-screen bg-[color:var(--color-page)] font-sans text-[color:var(--color-text)] antialiased" style="font-family: var(--font-family-sans)">
    <div class="min-h-screen lg:flex">
        <aside class="hidden w-64 shrink-0 border-r border-[color:var(--color-border)] bg-[color:var(--color-surface)] lg:fixed lg:inset-y-0 lg:flex lg:flex-col">
            <a href="{{ route('admin.dashboard') }}" class="flex h-20 items-center gap-3 border-b border-[color:var(--color-border)] px-6" aria-label="Library Al-Hasra, Dashboard Admin">
                <span class="flex h-10 w-10 items-center justify-center rounded-[var(--radius-card)] bg-[color:var(--color-primary)] text-sm font-bold text-white shadow-sm" aria-hidden="true">LH</span>
                <span class="min-w-0">
                    <span class="block truncate text-sm font-bold tracking-tight">Library Al-Hasra</span>
                    <span class="mt-0.5 block text-xs text-[color:var(--color-text-muted)]">Panel Perpustakaan</span>
                </span>
            </a>

            <nav class="flex-1 space-y-1 px-4 py-6" aria-label="Navigasi utama">
                <p class="mb-3 px-3 text-[11px] font-semibold uppercase tracking-[0.14em] text-[color:var(--color-text-muted)]">Menu utama</p>
                <a href="{{ route('admin.dashboard') }}" aria-current="page" class="flex items-center gap-3 rounded-[var(--radius-control)] bg-[color:var(--color-info-surface)] px-3 py-2.5 text-sm font-semibold text-[color:var(--color-primary)] transition-colors hover:bg-[color:var(--color-surface-muted)] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[color:var(--color-primary)]">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><rect x="3.5" y="3.5" width="7" height="7" rx="1.5"/><rect x="13.5" y="3.5" width="7" height="7" rx="1.5"/><rect x="3.5" y="13.5" width="7" height="7" rx="1.5"/><rect x="13.5" y="13.5" width="7" height="7" rx="1.5"/></svg>
                    Dashboard
                </a>
                <a href="{{ route('admin.buku.index') }}" class="flex items-center gap-3 rounded-[var(--radius-control)] px-3 py-2.5 text-sm font-medium text-[color:var(--color-text-muted)] transition-colors hover:bg-[color:var(--color-surface-muted)] hover:text-[color:var(--color-text)] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[color:var(--color-primary)]">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M5 4.5A2.5 2.5 0 0 1 7.5 2H20v18H7.5A2.5 2.5 0 0 0 5 22.5z"/><path d="M5 4.5v18M8.5 6H16m-7.5 4H16"/></svg>
                    Manajemen Buku
                </a>
                <a href="{{ route('admin.peminjaman.index') }}" class="flex items-center gap-3 rounded-[var(--radius-control)] px-3 py-2.5 text-sm font-medium text-[color:var(--color-text-muted)] transition-colors hover:bg-[color:var(--color-surface-muted)] hover:text-[color:var(--color-text)] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[color:var(--color-primary)]">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M7 3.5h10a2 2 0 0 1 2 2v15l-7-3-7 3v-15a2 2 0 0 1 2-2Z"/><path d="M9 8h6m-6 4h6"/></svg>
                    Peminjaman
                </a>

                <p class="mb-3 mt-8 px-3 text-[11px] font-semibold uppercase tracking-[0.14em] text-[color:var(--color-text-muted)]">Akun</p>
                <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 rounded-[var(--radius-control)] px-3 py-2.5 text-sm font-medium text-[color:var(--color-text-muted)] transition-colors hover:bg-[color:var(--color-surface-muted)] hover:text-[color:var(--color-text)] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[color:var(--color-primary)]">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><circle cx="12" cy="8" r="3.5"/><path d="M4.5 21a7.5 7.5 0 0 1 15 0"/></svg>
                    Profil
                </a>
            </nav>

            <div class="border-t border-[color:var(--color-border)] p-4">
                <div class="mb-3 flex items-center gap-3 rounded-[var(--radius-card)] bg-[color:var(--color-surface-muted)] p-3">
                    <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-[color:var(--color-primary)] text-xs font-bold text-white" aria-hidden="true">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                    <span class="min-w-0 flex-1">
                        <span class="block truncate text-sm font-semibold">{{ Auth::user()->name }}</span>
                        <span class="block text-xs text-[color:var(--color-text-muted)]">Administrator</span>
                    </span>
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="flex w-full items-center gap-3 rounded-[var(--radius-control)] px-3 py-2.5 text-sm font-medium text-[color:var(--color-danger)] transition-colors hover:bg-[color:var(--color-danger-surface)] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[color:var(--color-danger)]">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M10 17l5-5-5-5m5 5H3.5M12 3.5h5a2 2 0 0 1 2 2v13a2 2 0 0 1-2 2h-5"/></svg>
                        Keluar
                    </button>
                </form>
            </div>
        </aside>

        <div class="min-w-0 flex-1 lg:ml-64">
            <header class="sticky top-0 z-20 border-b border-[color:var(--color-border)] bg-[color:var(--color-surface)]/95 backdrop-blur">
                <div class="flex min-h-16 items-center justify-between gap-3 px-4 sm:px-6 lg:px-8">
                    <div class="flex min-w-0 items-center gap-3">
                        <x-back-button fallback="{{ route('admin.dashboard') }}" />
                        <div class="min-w-0">
                            <p class="truncate text-sm font-semibold sm:text-base">Dashboard Admin</p>
                            <p class="hidden text-xs text-[color:var(--color-text-muted)] sm:block">Ringkasan aktivitas perpustakaan</p>
                        </div>
                    </div>

                    <div class="flex shrink-0 items-center gap-2 sm:gap-3">
                        <x-theme-toggle />
                        <div class="hidden h-8 w-px bg-[color:var(--color-border)] sm:block" aria-hidden="true"></div>
                        <span class="hidden text-right sm:block">
                            <span class="block max-w-40 truncate text-sm font-semibold">{{ Auth::user()->name }}</span>
                            <span class="block text-xs text-[color:var(--color-text-muted)]">Administrator</span>
                        </span>
                        <span class="flex h-9 w-9 items-center justify-center rounded-full bg-[color:var(--color-info-surface)] text-sm font-bold text-[color:var(--color-primary)] sm:hidden" aria-label="{{ Auth::user()->name }}">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                    </div>
                </div>

                <details class="border-t border-[color:var(--color-border)] px-4 py-2 lg:hidden">
                    <summary class="cursor-pointer list-none text-sm font-medium text-[color:var(--color-primary)] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[color:var(--color-primary)]">Buka navigasi</summary>
                    <nav class="grid gap-1 pb-2 pt-3 sm:grid-cols-2" aria-label="Navigasi mobile">
                        <a href="{{ route('admin.dashboard') }}" aria-current="page" class="rounded-[var(--radius-control)] bg-[color:var(--color-info-surface)] px-3 py-2.5 text-sm font-semibold text-[color:var(--color-primary)]">Dashboard</a>
                        <a href="{{ route('admin.buku.index') }}" class="rounded-[var(--radius-control)] px-3 py-2.5 text-sm font-medium text-[color:var(--color-text-muted)] hover:bg-[color:var(--color-surface-muted)]">Manajemen Buku</a>
                        <a href="{{ route('admin.peminjaman.index') }}" class="rounded-[var(--radius-control)] px-3 py-2.5 text-sm font-medium text-[color:var(--color-text-muted)] hover:bg-[color:var(--color-surface-muted)]">Peminjaman</a>
                        <a href="{{ route('profile.edit') }}" class="rounded-[var(--radius-control)] px-3 py-2.5 text-sm font-medium text-[color:var(--color-text-muted)] hover:bg-[color:var(--color-surface-muted)]">Profil</a>
                        <form action="{{ route('logout') }}" method="POST" class="sm:col-span-2">
                            @csrf
                            <button type="submit" class="w-full rounded-[var(--radius-control)] px-3 py-2.5 text-left text-sm font-medium text-[color:var(--color-danger)] hover:bg-[color:var(--color-danger-surface)]">Keluar</button>
                        </form>
                    </nav>
                </details>
            </header>

            <main class="mx-auto w-full max-w-7xl px-4 py-7 sm:px-6 sm:py-9 lg:px-8 lg:py-10">
                <section class="mb-8 flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
                    <div>
                        <p class="mb-2 text-sm font-semibold text-[color:var(--color-primary)]">Perpustakaan SMK Al-Hasra</p>
                        <h1 class="text-2xl font-bold tracking-tight sm:text-3xl">Selamat datang, {{ Auth::user()->name }}</h1>
                        <p class="mt-2 max-w-2xl text-sm leading-6 text-[color:var(--color-text-muted)]">Pantau koleksi dan kelola layanan peminjaman dari satu tempat.</p>
                    </div>
                    <a href="{{ route('admin.peminjaman.index') }}" class="inline-flex min-h-11 items-center justify-center gap-2 rounded-[var(--radius-control)] bg-[color:var(--color-primary)] px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition-colors hover:bg-[color:var(--color-primary-hover)] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[color:var(--color-primary)] focus-visible:ring-offset-2">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M12 5v14M5 12h14"/></svg>
                        Lihat peminjaman
                    </a>
                </section>

                <section aria-labelledby="stats-heading">
                    <div class="mb-4 flex items-center justify-between gap-3">
                        <h2 id="stats-heading" class="text-base font-semibold">Ringkasan perpustakaan</h2>
                        <span class="text-xs text-[color:var(--color-text-muted)]">Data saat ini</span>
                    </div>
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
                        <article class="rounded-[var(--radius-card)] border border-[color:var(--color-border)] bg-[color:var(--color-surface)] p-5 shadow-[var(--shadow-card)] transition-colors">
                            <div class="flex items-start justify-between gap-3">
                                <div><p class="text-sm font-medium text-[color:var(--color-text-muted)]">Total Buku</p><p class="mt-3 text-3xl font-bold tracking-tight">{{ $totalBuku }}</p><p class="mt-1 text-xs text-[color:var(--color-text-muted)]">Judul dalam koleksi</p></div>
                                <span class="flex h-10 w-10 items-center justify-center rounded-[var(--radius-control)] bg-[color:var(--color-info-surface)] text-[color:var(--color-info)]"><svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M5 4.5A2.5 2.5 0 0 1 7.5 2H20v18H7.5A2.5 2.5 0 0 0 5 22.5z"/><path d="M5 4.5v18M9 7h7"/></svg></span>
                            </div>
                        </article>
                        <article class="rounded-[var(--radius-card)] border border-[color:var(--color-border)] bg-[color:var(--color-surface)] p-5 shadow-[var(--shadow-card)] transition-colors">
                            <div class="flex items-start justify-between gap-3">
                                <div><p class="text-sm font-medium text-[color:var(--color-text-muted)]">Total Siswa</p><p class="mt-3 text-3xl font-bold tracking-tight">{{ $totalSiswa }}</p><p class="mt-1 text-xs text-[color:var(--color-text-muted)]">Akun siswa terdaftar</p></div>
                                <span class="flex h-10 w-10 items-center justify-center rounded-[var(--radius-control)] bg-[color:var(--color-surface-muted)] text-[color:var(--color-primary)]"><svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><circle cx="9" cy="8" r="3.5"/><path d="M2.5 21a6.5 6.5 0 0 1 13 0m2-9a3 3 0 1 0 0-6m1 9a5.5 5.5 0 0 1 3 5"/></svg></span>
                            </div>
                        </article>
                        <article class="rounded-[var(--radius-card)] border border-[color:var(--color-border)] bg-[color:var(--color-surface)] p-5 shadow-[var(--shadow-card)] transition-colors">
                            <div class="flex items-start justify-between gap-3">
                                <div><p class="text-sm font-medium text-[color:var(--color-text-muted)]">Peminjaman Aktif</p><p class="mt-3 text-3xl font-bold tracking-tight">{{ $peminjamanAktif }}</p><p class="mt-1 text-xs text-[color:var(--color-text-muted)]">Buku sedang dipinjam</p></div>
                                <span class="flex h-10 w-10 items-center justify-center rounded-[var(--radius-control)] bg-[color:var(--color-success-surface)] text-[color:var(--color-success)]"><svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M6 3.5h12a2 2 0 0 1 2 2v15l-8-3.5-8 3.5v-15a2 2 0 0 1 2-2Z"/><path d="m9 10 2 2 4-4"/></svg></span>
                            </div>
                        </article>
                        <article class="rounded-[var(--radius-card)] border border-[color:var(--color-border)] bg-[color:var(--color-surface)] p-5 shadow-[var(--shadow-card)] transition-colors">
                            <div class="flex items-start justify-between gap-3">
                                <div><p class="text-sm font-medium text-[color:var(--color-text-muted)]">Menunggu Persetujuan</p><p class="mt-3 text-3xl font-bold tracking-tight">{{ $menunggu }}</p><p class="mt-1 text-xs text-[color:var(--color-text-muted)]">Pengajuan perlu ditinjau</p></div>
                                <span class="flex h-10 w-10 items-center justify-center rounded-[var(--radius-control)] bg-[color:var(--color-warning-surface)] text-[color:var(--color-warning)]"><svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/></svg></span>
                            </div>
                            @if ($menunggu > 0)
                                <a href="{{ route('admin.peminjaman.index') }}" class="mt-4 inline-flex text-xs font-semibold text-[color:var(--color-primary)] hover:underline focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[color:var(--color-primary)]">Tinjau pengajuan <span class="sr-only">yang menunggu persetujuan</span> <span aria-hidden="true">→</span></a>
                            @endif
                        </article>
                    </div>
                </section>

                <section class="mt-9" aria-labelledby="management-heading">
                    <div class="mb-4">
                        <h2 id="management-heading" class="text-base font-semibold">Akses cepat</h2>
                        <p class="mt-1 text-sm text-[color:var(--color-text-muted)]">Pilih area pengelolaan yang ingin dibuka.</p>
                    </div>
                    <div class="grid gap-4 lg:grid-cols-2">
                        <a href="{{ route('admin.buku.index') }}" class="group flex min-h-36 items-start gap-4 rounded-[var(--radius-card)] border border-[color:var(--color-border)] bg-[color:var(--color-surface)] p-5 shadow-[var(--shadow-card)] transition duration-200 hover:-translate-y-0.5 hover:border-[color:var(--color-primary)] hover:shadow-[var(--shadow-panel)] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[color:var(--color-primary)] sm:p-6">
                            <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-[var(--radius-card)] bg-[color:var(--color-info-surface)] text-[color:var(--color-primary)]"><svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M5 4.5A2.5 2.5 0 0 1 7.5 2H20v18H7.5A2.5 2.5 0 0 0 5 22.5z"/><path d="M5 4.5v18M9 7h7m-7 4h7"/></svg></span>
                            <span class="min-w-0 flex-1"><span class="flex items-center justify-between gap-2"><span class="text-base font-semibold">Manajemen Buku</span><span class="text-[color:var(--color-text-muted)] transition-transform group-hover:translate-x-1" aria-hidden="true">→</span></span><span class="mt-2 block text-sm leading-6 text-[color:var(--color-text-muted)]">Kelola koleksi, perbarui informasi buku, dan pantau stok tersedia.</span><span class="mt-4 inline-flex text-sm font-semibold text-[color:var(--color-primary)]">Buka koleksi</span></span>
                        </a>
                        <a href="{{ route('admin.peminjaman.index') }}" class="group flex min-h-36 items-start gap-4 rounded-[var(--radius-card)] border border-[color:var(--color-border)] bg-[color:var(--color-surface)] p-5 shadow-[var(--shadow-card)] transition duration-200 hover:-translate-y-0.5 hover:border-[color:var(--color-primary)] hover:shadow-[var(--shadow-panel)] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[color:var(--color-primary)] sm:p-6">
                            <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-[var(--radius-card)] bg-[color:var(--color-warning-surface)] text-[color:var(--color-warning)]"><svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M7 3.5h10a2 2 0 0 1 2 2v15l-7-3-7 3v-15a2 2 0 0 1 2-2Z"/><path d="M9 8h6m-6 4h6"/></svg></span>
                            <span class="min-w-0 flex-1"><span class="flex items-center justify-between gap-2"><span class="text-base font-semibold">Manajemen Peminjaman</span><span class="text-[color:var(--color-text-muted)] transition-transform group-hover:translate-x-1" aria-hidden="true">→</span></span><span class="mt-2 block text-sm leading-6 text-[color:var(--color-text-muted)]">Tinjau pengajuan, catat peminjaman langsung, dan proses pengembalian.</span><span class="mt-4 inline-flex text-sm font-semibold text-[color:var(--color-primary)]">Buka transaksi</span></span>
                        </a>
                    </div>
                </section>

                <section class="mt-8 rounded-[var(--radius-card)] border border-[color:var(--color-border)] bg-[color:var(--color-surface)] p-5 shadow-[var(--shadow-card)] sm:p-6" aria-labelledby="activity-heading">
                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <h2 id="activity-heading" class="text-base font-semibold">Aktivitas peminjaman</h2>
                            <p class="mt-1 text-sm text-[color:var(--color-text-muted)]">Lima transaksi terakhir yang diperbarui.</p>
                        </div>
                        <a href="{{ route('admin.peminjaman.index') }}" class="inline-flex min-h-10 items-center justify-center rounded-[var(--radius-control)] border border-[color:var(--color-border)] px-4 py-2 text-sm font-semibold text-[color:var(--color-text)] transition-colors hover:bg-[color:var(--color-surface-muted)] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[color:var(--color-primary)]">Buka daftar peminjaman</a>
                    </div>
                    <div class="mt-5 divide-y divide-[color:var(--color-border)]">
                        @forelse ($aktivitasTerbaru as $aktivitas)
                            @php
                                $statusLabel = [
                                    'pending' => 'Menunggu',
                                    'dipinjam' => 'Dipinjam',
                                    'dikembalikan' => 'Dikembalikan',
                                    'ditolak' => 'Ditolak',
                                ][$aktivitas->status] ?? ucfirst($aktivitas->status);
                                $statusColor = [
                                    'pending' => 'bg-[color:var(--color-warning-surface)] text-[color:var(--color-warning)]',
                                    'dipinjam' => 'bg-[color:var(--color-info-surface)] text-[color:var(--color-info)]',
                                    'dikembalikan' => 'bg-[color:var(--color-success-surface)] text-[color:var(--color-success)]',
                                    'ditolak' => 'bg-[color:var(--color-danger-surface)] text-[color:var(--color-danger)]',
                                ][$aktivitas->status] ?? 'bg-[color:var(--color-surface-muted)] text-[color:var(--color-text-muted)]';
                            @endphp
                            <div class="flex flex-col gap-3 py-4 first:pt-0 last:pb-0 sm:flex-row sm:items-center sm:justify-between">
                                <div class="flex min-w-0 items-center gap-3">
                                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-[color:var(--color-surface-muted)] text-[color:var(--color-primary)]" aria-hidden="true">
                                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M7 3.5h10a2 2 0 0 1 2 2v15l-7-3-7 3v-15a2 2 0 0 1 2-2Z"/><path d="M9 8h6m-6 4h6"/></svg>
                                    </span>
                                    <span class="min-w-0">
                                        <span class="block truncate text-sm font-semibold">{{ $aktivitas->buku->judul ?? 'Buku tidak tersedia' }}</span>
                                        <span class="mt-1 block truncate text-xs text-[color:var(--color-text-muted)]">{{ $aktivitas->user->name ?? 'Siswa tidak tersedia' }} · diperbarui {{ $aktivitas->updated_at?->format('d/m/Y') ?? '—' }}</span>
                                    </span>
                                </div>
                                <span class="inline-flex w-fit shrink-0 items-center rounded-full px-3 py-1 text-xs font-semibold {{ $statusColor }}">{{ $statusLabel }}</span>
                            </div>
                        @empty
                            <div class="mt-5 rounded-[var(--radius-control)] bg-[color:var(--color-surface-muted)] px-4 py-6 text-center text-sm text-[color:var(--color-text-muted)]">
                                Belum ada aktivitas peminjaman.
                            </div>
                        @endforelse
                    </div>
                </section>
            </main>
        </div>
    </div>

</body>
</html>
