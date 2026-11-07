<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="color-scheme" content="light dark">
    <title>Manajemen Peminjaman - Library Al-Hasra</title>
    @include('components.theme-init')
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/css/design-tokens.css', 'resources/js/theme.js'])
</head>
<body class="min-h-screen bg-[color:var(--color-page)] text-[color:var(--color-text)] antialiased" style="font-family: var(--font-family-sans); transition: var(--transition-colors)">
    <header class="sticky top-0 z-20 border-b border-[color:var(--color-border)] bg-[color:var(--color-surface)]/95 backdrop-blur">
        <nav class="mx-auto flex min-h-16 max-w-7xl items-center justify-between gap-3 px-4 sm:px-6 lg:px-8" aria-label="Navigasi halaman">
            <div class="flex min-w-0 items-center gap-3">
                <x-back-button fallback="{{ route('admin.dashboard') }}" />
                <a href="{{ route('admin.dashboard') }}" class="min-w-0 text-sm font-bold tracking-tight sm:text-base" aria-label="Dashboard Library Al-Hasra">Library <span class="text-[color:var(--color-primary)]">Al-Hasra</span></a>
                <span class="hidden h-6 w-px bg-[color:var(--color-border)] sm:block" aria-hidden="true"></span>
                <a href="{{ route('admin.dashboard') }}" class="hidden text-sm text-[color:var(--color-text-muted)] hover:text-[color:var(--color-primary)] sm:block">Dashboard</a>
            </div>
            <div class="flex shrink-0 items-center gap-2 sm:gap-3">
                <span class="hidden text-sm text-[color:var(--color-text-muted)] md:block">{{ Auth::user()->name }}</span>
                <x-theme-toggle />
            </div>
        </nav>
    </header>

    <main class="mx-auto w-full max-w-7xl px-4 py-7 sm:px-6 sm:py-9 lg:px-8">
        <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <nav class="mb-3 flex items-center gap-2 text-xs font-medium text-[color:var(--color-text-muted)]" aria-label="Breadcrumb">
                    <a href="{{ route('admin.dashboard') }}" class="hover:text-[color:var(--color-primary)]">Dashboard</a>
                    <span aria-hidden="true">/</span>
                    <span aria-current="page" class="text-[color:var(--color-text)]">Manajemen Peminjaman</span>
                </nav>
                <h1 class="text-2xl font-bold tracking-tight sm:text-3xl">Manajemen Peminjaman</h1>
                <p class="mt-2 text-sm leading-6 text-[color:var(--color-text-muted)]">Kelola permintaan peminjaman dan pengembalian buku dari siswa.</p>
            </div>
            <a href="{{ route('admin.peminjaman.create') }}" class="inline-flex min-h-11 items-center justify-center gap-2 rounded-[var(--radius-control)] bg-[color:var(--color-primary)] px-4 py-2.5 text-sm font-semibold text-[color:var(--color-primary-contrast)] shadow-sm transition-colors hover:bg-[color:var(--color-primary-hover)] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[color:var(--color-primary)] focus-visible:ring-offset-2">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M12 5v14M5 12h14" /></svg>
                Tambah Peminjaman Offline
            </a>
        </div>

        @if (session('success'))
            <div class="mb-6 flex items-start gap-3 rounded-[var(--radius-control)] border border-[color:var(--color-success)]/20 bg-[color:var(--color-success-surface)] px-4 py-3 text-sm text-[color:var(--color-success)]" role="status">
                <svg class="mt-0.5 h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="m5 12 4 4L19 6" /></svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif
        @if (session('error'))
            <div class="mb-6 flex items-start gap-3 rounded-[var(--radius-control)] border border-[color:var(--color-danger)]/20 bg-[color:var(--color-danger-surface)] px-4 py-3 text-sm text-[color:var(--color-danger)]" role="alert">
                <svg class="mt-0.5 h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="12" cy="12" r="9" /><path d="M12 8v5m0 3h.01" /></svg>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <section class="overflow-hidden rounded-[var(--radius-panel)] border border-[color:var(--color-border)] bg-[color:var(--color-surface)] shadow-[var(--shadow-card)]" aria-labelledby="loans-table-title">
            <div class="flex flex-col gap-4 border-b border-[color:var(--color-border)] p-4 sm:flex-row sm:items-center sm:justify-between sm:p-5">
                <div>
                    <h2 id="loans-table-title" class="text-base font-semibold">Daftar peminjaman</h2>
                    <p class="mt-1 text-sm text-[color:var(--color-text-muted)]" data-loan-results-count aria-live="polite">{{ $peminjamans->count() }} transaksi</p>
                </div>
                <label class="relative block w-full sm:max-w-sm">
                    <span class="sr-only">Cari nama siswa atau judul buku</span>
                    <svg class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-[color:var(--color-text-muted)]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><circle cx="10.8" cy="10.8" r="6.8" /><path d="m16 16 5 5" /></svg>
                    <input type="search" data-loan-search placeholder="Cari nama siswa atau judul buku..." aria-label="Cari nama siswa atau judul buku" class="min-h-11 w-full rounded-[var(--radius-control)] border border-[color:var(--color-border)] bg-[color:var(--color-page)] py-2 pl-10 pr-3 text-sm text-[color:var(--color-text)] placeholder:text-[color:var(--color-text-muted)] focus:border-[color:var(--color-primary)] focus:outline-none focus:ring-2 focus:ring-[color:var(--color-primary)]/20" autocomplete="off">
                </label>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full min-w-[1000px] border-collapse text-left text-sm" data-loans-table>
                    <thead class="bg-[color:var(--color-surface-muted)] text-xs font-semibold uppercase tracking-wide text-[color:var(--color-text-muted)]">
                        <tr>
                            <th scope="col" class="px-5 py-3.5">No.</th>
                            <th scope="col" class="px-5 py-3.5">Nama Siswa</th>
                            <th scope="col" class="px-5 py-3.5">Judul Buku</th>
                            <th scope="col" class="px-5 py-3.5">Tanggal Pinjam</th>
                            <th scope="col" class="px-5 py-3.5">Jatuh Tempo</th>
                            <th scope="col" class="px-5 py-3.5">Status</th>
                            <th scope="col" class="px-5 py-3.5 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[color:var(--color-border)]">
                        @forelse ($peminjamans as $peminjaman)
                            <tr class="transition-colors hover:bg-[color:var(--color-surface-muted)]" data-loan-row data-search="{{ ($peminjaman->user->name ?? '') . ' ' . ($peminjaman->buku->judul ?? '') }}">
                                <td class="px-5 py-4 text-[color:var(--color-text-muted)]">{{ $loop->iteration }}</td>
                                <td class="px-5 py-4 font-semibold">{{ $peminjaman->user->name ?? 'User tidak ditemukan' }}</td>
                                <td class="max-w-sm px-5 py-4">{{ $peminjaman->buku->judul ?? 'Buku tidak ditemukan' }}</td>
                                <td class="whitespace-nowrap px-5 py-4 text-[color:var(--color-text-muted)]">{{ $peminjaman->tanggal_pinjam }}</td>
                                <td class="whitespace-nowrap px-5 py-4 text-[color:var(--color-text-muted)]">{{ $peminjaman->tanggal_kembali }}</td>
                                <td class="px-5 py-4">
                                    @if ($peminjaman->status === 'pending')
                                        <span class="inline-flex rounded-full bg-[color:var(--color-warning-surface)] px-2.5 py-1 text-xs font-semibold text-[color:var(--color-warning)]">Menunggu</span>
                                    @elseif ($peminjaman->status === 'dipinjam')
                                        <span class="inline-flex rounded-full bg-[color:var(--color-info-surface)] px-2.5 py-1 text-xs font-semibold text-[color:var(--color-info)]">Dipinjam</span>
                                    @elseif ($peminjaman->status === 'dikembalikan')
                                        <span class="inline-flex rounded-full bg-[color:var(--color-success-surface)] px-2.5 py-1 text-xs font-semibold text-[color:var(--color-success)]">Dikembalikan</span>
                                    @elseif ($peminjaman->status === 'ditolak')
                                        <span class="inline-flex rounded-full bg-[color:var(--color-danger-surface)] px-2.5 py-1 text-xs font-semibold text-[color:var(--color-danger)]">Ditolak</span>
                                    @else
                                        <span class="inline-flex rounded-full bg-[color:var(--color-surface-muted)] px-2.5 py-1 text-xs font-semibold text-[color:var(--color-text-muted)]">{{ ucfirst($peminjaman->status) }}</span>
                                    @endif
                                </td>
                                <td class="px-5 py-4 text-right">
                                    @if ($peminjaman->status === 'pending')
                                        <div class="inline-flex items-center gap-2">
                                            <form action="{{ route('admin.peminjaman.approve', $peminjaman->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menyetujui peminjaman ini?')">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="inline-flex min-h-9 items-center rounded-[var(--radius-control)] border border-[color:var(--color-success)]/30 px-3 text-xs font-semibold text-[color:var(--color-success)] transition-colors hover:bg-[color:var(--color-success-surface)] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[color:var(--color-success)]">Setujui</button>
                                            </form>
                                            <form action="{{ route('admin.peminjaman.reject', $peminjaman->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menolak pengajuan ini?')">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="inline-flex min-h-9 items-center rounded-[var(--radius-control)] border border-[color:var(--color-danger)]/30 px-3 text-xs font-semibold text-[color:var(--color-danger)] transition-colors hover:bg-[color:var(--color-danger-surface)] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[color:var(--color-danger)]">Tolak</button>
                                            </form>
                                        </div>
                                    @elseif ($peminjaman->status === 'dipinjam')
                                        <form action="{{ route('admin.peminjaman.return', $peminjaman->id) }}" method="POST" onsubmit="return confirm('Yakin ingin mencatat buku ini sudah dikembalikan?')">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="inline-flex min-h-9 items-center rounded-[var(--radius-control)] border border-[color:var(--color-info)]/30 px-3 text-xs font-semibold text-[color:var(--color-info)] transition-colors hover:bg-[color:var(--color-info-surface)] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[color:var(--color-info)]">Kembalikan Buku</button>
                                        </form>
                                    @else
                                        <span class="text-xs text-[color:var(--color-text-muted)]">Sudah diproses</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr data-no-loans>
                                <td colspan="7" class="px-6 py-12 text-center">
                                    <span class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-[color:var(--color-surface-muted)] text-[color:var(--color-text-muted)]" aria-hidden="true"><svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M5 4.5A2.5 2.5 0 0 1 7.5 2H20v18H7.5A2.5 2.5 0 0 0 5 22.5z" /><path d="M5 4.5v18" /></svg></span>
                                    <p class="mt-3 font-semibold">Belum ada pengajuan peminjaman</p>
                                    <p class="mt-1 text-sm text-[color:var(--color-text-muted)]">Pengajuan dari siswa akan tampil di sini.</p>
                                </td>
                            </tr>
                        @endforelse
                        <tr data-no-loan-results hidden>
                            <td colspan="7" class="px-6 py-10 text-center">
                                <p class="font-semibold">Peminjaman tidak ditemukan</p>
                                <p class="mt-1 text-sm text-[color:var(--color-text-muted)]">Coba nama siswa atau judul buku yang berbeda.</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
    </main>
    <script>
        (() => {
            const table = document.querySelector('[data-loans-table]');
            const search = document.querySelector('[data-loan-search]');
            if (!table || !search) return;

            const rows = Array.from(table.querySelectorAll('[data-loan-row]'));
            const noLoans = table.querySelector('[data-no-loans]');
            const noResults = table.querySelector('[data-no-loan-results]');
            const summary = document.querySelector('[data-loan-results-count]');
            const normalize = (value) => value
                .normalize('NFD')
                .replace(/[\u0300-\u036f]/g, '')
                .toLocaleLowerCase('id');

            const updateRows = () => {
                const query = normalize(search.value.trim());
                let visibleCount = 0;

                rows.forEach((row) => {
                    const matches = normalize(row.dataset.search || '').includes(query);
                    row.hidden = !matches;
                    if (matches) visibleCount += 1;
                });

                if (noLoans) noLoans.hidden = rows.length > 0 || query.length > 0;
                if (noResults) noResults.hidden = query.length === 0 || visibleCount > 0;
                if (summary) {
                    summary.textContent = query
                        ? `${visibleCount} dari ${rows.length} transaksi ditemukan`
                        : `${rows.length} transaksi`;
                }
            };

            search.addEventListener('input', updateRows);
        })();
    </script>
</body>
</html>
