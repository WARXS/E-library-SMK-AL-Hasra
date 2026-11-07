@php
    $totalJudul = $bukus->count();
    $totalStok = $bukus->sum('stok');
    $bukuTersedia = $bukus->filter(fn ($buku) => $buku->stok > 0)->count();
    $bukuHabis = $bukus->filter(fn ($buku) => $buku->stok < 1)->count();
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="color-scheme" content="light dark">
    <title>Manajemen Buku - Library Al-Hasra</title>
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
                    <span aria-current="page" class="text-[color:var(--color-text)]">Manajemen Buku</span>
                </nav>
                <h1 class="text-2xl font-bold tracking-tight sm:text-3xl">Manajemen Buku</h1>
                <p class="mt-2 text-sm leading-6 text-[color:var(--color-text-muted)]">Kelola koleksi buku dan pantau ketersediaan untuk dipinjam.</p>
            </div>
            <a href="{{ route('admin.buku.create') }}" class="inline-flex min-h-11 items-center justify-center gap-2 rounded-[var(--radius-control)] bg-[color:var(--color-primary)] px-4 py-2.5 text-sm font-semibold text-[color:var(--color-primary-contrast)] shadow-sm transition-colors hover:bg-[color:var(--color-primary-hover)] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[color:var(--color-primary)] focus-visible:ring-offset-2">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M12 5v14M5 12h14"/></svg>
                Tambah Buku
            </a>
        </div>

        @if (session('success'))
            <div class="mb-6 flex items-start gap-3 rounded-[var(--radius-control)] border border-[color:var(--color-success)]/20 bg-[color:var(--color-success-surface)] px-4 py-3 text-sm text-[color:var(--color-success)]" role="status">
                <svg class="mt-0.5 h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="m5 12 4 4L19 6"/></svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif
        @if (session('error'))
            <div class="mb-6 flex items-start gap-3 rounded-[var(--radius-control)] border border-[color:var(--color-danger)]/20 bg-[color:var(--color-danger-surface)] px-4 py-3 text-sm text-[color:var(--color-danger)]" role="alert">
                <svg class="mt-0.5 h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="M12 8v5m0 3h.01"/></svg>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <section class="mb-7 grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4" aria-label="Ringkasan koleksi buku">
            <article class="rounded-[var(--radius-card)] border border-[color:var(--color-border)] bg-[color:var(--color-surface)] p-5 shadow-[var(--shadow-card)]">
                <p class="text-sm font-medium text-[color:var(--color-text-muted)]">Total Judul</p>
                <p class="mt-3 text-3xl font-bold tracking-tight">{{ $totalJudul }}</p>
                <p class="mt-1 text-xs text-[color:var(--color-text-muted)]">Judul buku dalam koleksi</p>
            </article>
            <article class="rounded-[var(--radius-card)] border border-[color:var(--color-border)] bg-[color:var(--color-surface)] p-5 shadow-[var(--shadow-card)]">
                <p class="text-sm font-medium text-[color:var(--color-text-muted)]">Stok Tersedia</p>
                <p class="mt-3 text-3xl font-bold tracking-tight text-[color:var(--color-primary)]">{{ $totalStok }}</p>
                <p class="mt-1 text-xs text-[color:var(--color-text-muted)]">Buku siap dipinjam</p>
            </article>
            <article class="rounded-[var(--radius-card)] border border-[color:var(--color-border)] bg-[color:var(--color-surface)] p-5 shadow-[var(--shadow-card)]">
                <p class="text-sm font-medium text-[color:var(--color-text-muted)]">Judul Tersedia</p>
                <p class="mt-3 text-3xl font-bold tracking-tight text-[color:var(--color-success)]">{{ $bukuTersedia }}</p>
                <p class="mt-1 text-xs text-[color:var(--color-text-muted)]">Memiliki stok lebih dari nol</p>
            </article>
            <article class="rounded-[var(--radius-card)] border border-[color:var(--color-border)] bg-[color:var(--color-surface)] p-5 shadow-[var(--shadow-card)]">
                <p class="text-sm font-medium text-[color:var(--color-text-muted)]">Stok Habis</p>
                <p class="mt-3 text-3xl font-bold tracking-tight {{ $bukuHabis > 0 ? 'text-[color:var(--color-warning)]' : '' }}">{{ $bukuHabis }}</p>
                <p class="mt-1 text-xs text-[color:var(--color-text-muted)]">Judul belum tersedia untuk dipinjam</p>
            </article>
        </section>

        <section class="overflow-hidden rounded-[var(--radius-panel)] border border-[color:var(--color-border)] bg-[color:var(--color-surface)] shadow-[var(--shadow-card)]" aria-labelledby="books-table-title">
            <div class="flex flex-col gap-4 border-b border-[color:var(--color-border)] p-4 sm:flex-row sm:items-center sm:justify-between sm:p-5">
                <div>
                    <h2 id="books-table-title" class="text-base font-semibold">Daftar koleksi</h2>
                    <p class="mt-1 text-sm text-[color:var(--color-text-muted)]" data-results-summary aria-live="polite">{{ $totalJudul }} buku</p>
                </div>
                <label class="relative block w-full sm:max-w-sm">
                    <span class="sr-only">Cari judul, penulis, penerbit, atau tahun</span>
                    <svg class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-[color:var(--color-text-muted)]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><circle cx="10.8" cy="10.8" r="6.8"/><path d="m16 16 5 5"/></svg>
                    <input type="search" data-book-search placeholder="Cari judul atau penulis..." class="min-h-11 w-full rounded-[var(--radius-control)] border border-[color:var(--color-border)] bg-[color:var(--color-page)] py-2 pl-10 pr-3 text-sm text-[color:var(--color-text)] placeholder:text-[color:var(--color-text-muted)] focus:border-[color:var(--color-primary)] focus:outline-none focus:ring-2 focus:ring-[color:var(--color-primary)]/20" autocomplete="off">
                </label>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full min-w-[850px] border-collapse text-left text-sm" data-book-table>
                    <thead class="bg-[color:var(--color-surface-muted)] text-xs font-semibold uppercase tracking-wide text-[color:var(--color-text-muted)]">
                        <tr>
                            <th scope="col" class="px-5 py-3.5">No.</th>
                            <th scope="col" class="px-5 py-3.5">Judul Buku</th>
                            <th scope="col" class="px-5 py-3.5">Penulis</th>
                            <th scope="col" class="px-5 py-3.5">Penerbit</th>
                            <th scope="col" class="px-5 py-3.5">Tahun</th>
                            <th scope="col" class="px-5 py-3.5">Stok</th>
                            <th scope="col" class="px-5 py-3.5 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[color:var(--color-border)]">
                        @foreach ($bukus as $buku)
                            <tr class="transition-colors hover:bg-[color:var(--color-surface-muted)]" data-book-row>
                                <td class="px-5 py-4 text-[color:var(--color-text-muted)]">{{ $loop->iteration }}</td>
                                <td class="max-w-sm px-5 py-4 font-semibold">{{ $buku->judul }}</td>
                                <td class="px-5 py-4 text-[color:var(--color-text-muted)]">{{ $buku->penulis }}</td>
                                <td class="px-5 py-4 text-[color:var(--color-text-muted)]">{{ $buku->penerbit ?: '—' }}</td>
                                <td class="px-5 py-4 text-[color:var(--color-text-muted)]">{{ $buku->tahun_terbit ?: '—' }}</td>
                                <td class="px-5 py-4">
                                    <span class="inline-flex min-w-10 items-center justify-center rounded-full px-2.5 py-1 text-xs font-semibold {{ $buku->stok > 0 ? 'bg-[color:var(--color-success-surface)] text-[color:var(--color-success)]' : 'bg-[color:var(--color-warning-surface)] text-[color:var(--color-warning)]' }}">{{ $buku->stok }}</span>
                                </td>
                                <td class="px-5 py-4 text-right">
                                    <div class="inline-flex items-center gap-2">
                                        <a href="{{ route('admin.buku.edit', $buku->id) }}" class="inline-flex min-h-9 items-center rounded-[var(--radius-control)] border border-[color:var(--color-border)] px-3 text-xs font-semibold text-[color:var(--color-primary)] transition-colors hover:bg-[color:var(--color-info-surface)] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[color:var(--color-primary)]">Edit<span class="sr-only"> {{ $buku->judul }}</span></a>
                                        <form action="{{ route('admin.buku.destroy', $buku->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex min-h-9 items-center rounded-[var(--radius-control)] border border-[color:var(--color-border)] px-3 text-xs font-semibold text-[color:var(--color-danger)] transition-colors hover:bg-[color:var(--color-danger-surface)] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[color:var(--color-danger)]" onclick="return confirm('Apakah Anda yakin ingin menghapus buku ini?')">Hapus<span class="sr-only"> {{ $buku->judul }}</span></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        <tr data-empty-state @if ($totalJudul > 0) hidden @endif>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <span class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-[color:var(--color-surface-muted)] text-[color:var(--color-text-muted)]" aria-hidden="true"><svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M5 4.5A2.5 2.5 0 0 1 7.5 2H20v18H7.5A2.5 2.5 0 0 0 5 22.5z"/><path d="M5 4.5v18"/></svg></span>
                                <p class="mt-3 font-semibold" data-empty-title>{{ $totalJudul > 0 ? 'Buku tidak ditemukan' : 'Belum ada koleksi buku' }}</p>
                                <p class="mt-1 text-sm text-[color:var(--color-text-muted)]" data-empty-description>{{ $totalJudul > 0 ? 'Coba gunakan kata kunci pencarian yang berbeda.' : 'Tambahkan buku pertama untuk mulai mengelola koleksi perpustakaan.' }}</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="flex flex-col gap-3 border-t border-[color:var(--color-border)] px-4 py-3 sm:flex-row sm:items-center sm:justify-between sm:px-5" data-pagination hidden>
                <span class="text-xs text-[color:var(--color-text-muted)]" data-page-status></span>
                <div class="flex items-center gap-2">
                    <button type="button" data-page-prev class="min-h-9 rounded-[var(--radius-control)] border border-[color:var(--color-border)] px-3 text-xs font-semibold text-[color:var(--color-text)] transition-colors hover:bg-[color:var(--color-surface-muted)] disabled:cursor-not-allowed disabled:opacity-50">Sebelumnya</button>
                    <button type="button" data-page-next class="min-h-9 rounded-[var(--radius-control)] border border-[color:var(--color-border)] px-3 text-xs font-semibold text-[color:var(--color-text)] transition-colors hover:bg-[color:var(--color-surface-muted)] disabled:cursor-not-allowed disabled:opacity-50">Berikutnya</button>
                </div>
            </div>
        </section>
    </main>

    <script>
        (() => {
            const table = document.querySelector('[data-book-table]');
            if (!table) return;

            const search = document.querySelector('[data-book-search]');
            const rows = Array.from(table.querySelectorAll('[data-book-row]'));
            const emptyState = table.querySelector('[data-empty-state]');
            const emptyTitle = table.querySelector('[data-empty-title]');
            const emptyDescription = table.querySelector('[data-empty-description]');
            const summary = document.querySelector('[data-results-summary]');
            const pagination = document.querySelector('[data-pagination]');
            const pageStatus = document.querySelector('[data-page-status]');
            const previousButton = document.querySelector('[data-page-prev]');
            const nextButton = document.querySelector('[data-page-next]');
            const pageSize = 8;
            let currentPage = 1;

            function renderRows() {
                const query = (search?.value || '').trim().toLocaleLowerCase('id');
                const matches = rows.filter((row) => row.textContent.toLocaleLowerCase('id').includes(query));
                const pageCount = Math.max(1, Math.ceil(matches.length / pageSize));
                currentPage = Math.min(currentPage, pageCount);
                const start = (currentPage - 1) * pageSize;

                rows.forEach((row) => { row.hidden = true; });
                matches.slice(start, start + pageSize).forEach((row) => { row.hidden = false; });
                emptyState.hidden = matches.length > 0;
                emptyTitle.textContent = rows.length === 0 ? 'Belum ada koleksi buku' : 'Buku tidak ditemukan';
                emptyDescription.textContent = rows.length === 0
                    ? 'Tambahkan buku pertama untuk mulai mengelola koleksi perpustakaan.'
                    : 'Coba gunakan kata kunci pencarian yang berbeda.';
                summary.textContent = query ? `${matches.length} dari ${rows.length} buku ditemukan` : `${rows.length} buku`;
                pagination.hidden = matches.length <= pageSize;
                pageStatus.textContent = `Halaman ${currentPage} dari ${pageCount}`;
                previousButton.disabled = currentPage <= 1;
                nextButton.disabled = currentPage >= pageCount;
            }

            search?.addEventListener('input', () => {
                currentPage = 1;
                renderRows();
            });
            previousButton?.addEventListener('click', () => {
                currentPage -= 1;
                renderRows();
            });
            nextButton?.addEventListener('click', () => {
                currentPage += 1;
                renderRows();
            });
            renderRows();
        })();
    </script>
</body>
</html>
