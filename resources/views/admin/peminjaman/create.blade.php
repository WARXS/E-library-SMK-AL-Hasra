<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="color-scheme" content="light dark">
    <title>Tambah Peminjaman Offline - Library Al-Hasra</title>
    @include('components.theme-init')
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/css/design-tokens.css', 'resources/js/theme.js'])
    <style>
        body { font-family: var(--font-family-sans); transition: var(--transition-colors); }
        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after { scroll-behavior: auto !important; transition-duration: 0.01ms !important; animation-duration: 0.01ms !important; }
        }
    </style>
</head>
<body class="min-h-screen bg-[color:var(--color-page)] text-[color:var(--color-text)] antialiased">
    <header class="sticky top-0 z-20 border-b border-[color:var(--color-border)] bg-[color:var(--color-surface)]/95 backdrop-blur">
        <nav class="mx-auto flex min-h-16 max-w-7xl items-center justify-between gap-3 px-4 sm:px-6 lg:px-8" aria-label="Navigasi halaman">
            <div class="flex min-w-0 items-center gap-3">
                <x-back-button fallback="{{ route('admin.peminjaman.index') }}" />
                <a href="{{ route('admin.dashboard') }}" class="min-w-0 truncate text-sm font-bold tracking-tight sm:text-base">Library <span class="text-[color:var(--color-primary)]">Al-Hasra</span></a>
            </div>
            <div class="flex shrink-0 items-center gap-2 sm:gap-3">
                <span class="hidden max-w-40 truncate text-sm text-[color:var(--color-text-muted)] sm:block">{{ Auth::user()->name }}</span>
                <x-theme-toggle />
            </div>
        </nav>
    </header>

    <main class="mx-auto w-full max-w-7xl px-4 py-7 sm:px-6 sm:py-9 lg:px-8">
        <nav class="mb-4 flex flex-wrap items-center gap-2 text-xs font-medium text-[color:var(--color-text-muted)]" aria-label="Breadcrumb">
            <a href="{{ route('admin.dashboard') }}" class="transition-colors hover:text-[color:var(--color-primary)]">Dashboard</a>
            <span aria-hidden="true">/</span>
            <a href="{{ route('admin.peminjaman.index') }}" class="transition-colors hover:text-[color:var(--color-primary)]">Peminjaman</a>
            <span aria-hidden="true">/</span>
            <span aria-current="page" class="text-[color:var(--color-text)]">Tambah Peminjaman</span>
        </nav>

        <section class="mb-7 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="mb-2 text-sm font-semibold text-[color:var(--color-primary)]">Pencatatan langsung di perpustakaan</p>
                <h1 class="text-2xl font-bold tracking-tight sm:text-3xl">Tambah Peminjaman Offline</h1>
                <p class="mt-2 max-w-2xl text-sm leading-6 text-[color:var(--color-text-muted)]">Catat transaksi peminjaman buku yang dilakukan langsung di perpustakaan.</p>
            </div>
            <a href="{{ route('admin.peminjaman.index') }}" class="inline-flex min-h-10 items-center gap-2 self-start rounded-[var(--radius-control)] px-3 text-sm font-semibold text-[color:var(--color-primary)] transition-colors hover:bg-[color:var(--color-info-surface)] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[color:var(--color-primary)] sm:self-auto">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="m14.5 5-7 7 7 7M8 12h12"/></svg>
                Daftar Peminjaman
            </a>
        </section>

        @if (session('error'))
            <div class="mb-5 flex items-start gap-3 rounded-[var(--radius-control)] border border-[color:var(--color-danger)]/20 bg-[color:var(--color-danger-surface)] px-4 py-3 text-sm text-[color:var(--color-danger)]" role="alert">
                <svg class="mt-0.5 h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="M12 8v5m0 3h.01"/></svg>
                <span>{{ session('error') }}</span>
            </div>
        @endif
        @if ($errors->any())
            <div class="mb-5 rounded-[var(--radius-control)] border border-[color:var(--color-danger)]/20 bg-[color:var(--color-danger-surface)] px-4 py-3 text-sm text-[color:var(--color-danger)]" role="alert">
                <p class="font-semibold">Periksa kembali data peminjaman:</p>
                <ul class="mt-1 list-inside list-disc space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid items-start gap-6 lg:grid-cols-3">
            <form action="{{ route('admin.peminjaman.store') }}" method="POST" class="space-y-6 lg:col-span-2">
                @csrf

                <section class="rounded-[var(--radius-panel)] border border-[color:var(--color-border)] bg-[color:var(--color-surface)] p-5 shadow-[var(--shadow-card)] sm:p-7" aria-labelledby="loan-information-heading">
                    <div class="mb-6 flex items-start gap-3">
                        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-[var(--radius-control)] bg-[color:var(--color-info-surface)] text-[color:var(--color-primary)]" aria-hidden="true">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M7 3.5h10a2 2 0 0 1 2 2v15l-7-3-7 3v-15a2 2 0 0 1 2-2Z"/><path d="M9 8h6m-6 4h6"/></svg>
                        </span>
                        <div>
                            <h2 id="loan-information-heading" class="text-lg font-bold">Informasi Peminjaman</h2>
                            <p class="mt-1 text-sm text-[color:var(--color-text-muted)]">Pilih siswa dan koleksi yang akan dipinjam.</p>
                        </div>
                    </div>

                    <div class="grid gap-5 sm:grid-cols-2">
                        <div>
                            <label for="user_id" class="mb-2 block text-sm font-semibold">Nama Siswa</label>
                            <div class="relative">
                                <select id="user_id" name="user_id" required data-loan-student aria-describedby="student-help student-error" class="min-h-12 w-full appearance-none rounded-[var(--radius-control)] border border-[color:var(--color-border)] bg-[color:var(--color-page)] px-4 py-3 pr-10 text-sm text-[color:var(--color-text)] transition-colors focus:border-[color:var(--color-primary)] focus:outline-none focus:ring-2 focus:ring-[color:var(--color-primary)]/20">
                                    <option value="">Pilih siswa</option>
                                    @forelse ($siswas as $siswa)
                                        <option value="{{ $siswa->id }}" data-name="{{ $siswa->name }}" data-email="{{ $siswa->email }}" data-nis="{{ $siswa->nis ?? '' }}" @selected(old('user_id') == $siswa->id)>
                                            {{ $siswa->name }}@if ($siswa->nis) · NIS {{ $siswa->nis }}@else · {{ $siswa->email }}@endif
                                        </option>
                                    @empty
                                        <option value="" disabled>Belum ada data siswa</option>
                                    @endforelse
                                </select>
                                <svg class="pointer-events-none absolute right-3 top-1/2 h-4 w-4 -translate-y-1/2 text-[color:var(--color-text-muted)]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="m6 9 6 6 6-6"/></svg>
                            </div>
                            <p id="student-help" class="mt-2 text-xs leading-5 text-[color:var(--color-text-muted)]">Pilih akun siswa yang menerima buku.</p>
                            <x-input-error id="student-error" :messages="$errors->get('user_id')" class="mt-2 text-sm text-[color:var(--color-danger)]" />
                        </div>

                        <div>
                            <label for="buku_id" class="mb-2 block text-sm font-semibold">Judul Buku</label>
                            <div class="relative">
                                <select id="buku_id" name="buku_id" required data-loan-book aria-describedby="book-help book-error" class="min-h-12 w-full appearance-none rounded-[var(--radius-control)] border border-[color:var(--color-border)] bg-[color:var(--color-page)] px-4 py-3 pr-10 text-sm text-[color:var(--color-text)] transition-colors focus:border-[color:var(--color-primary)] focus:outline-none focus:ring-2 focus:ring-[color:var(--color-primary)]/20">
                                    <option value="">Pilih buku</option>
                                    @forelse ($bukus as $buku)
                                        <option value="{{ $buku->id }}" data-title="{{ $buku->judul }}" data-stock="{{ $buku->stok }}" @selected(old('buku_id') == $buku->id)>
                                            {{ $buku->judul }} · Stok tersedia: {{ $buku->stok }}
                                        </option>
                                    @empty
                                        <option value="" disabled>Belum ada buku tersedia</option>
                                    @endforelse
                                </select>
                                <svg class="pointer-events-none absolute right-3 top-1/2 h-4 w-4 -translate-y-1/2 text-[color:var(--color-text-muted)]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="m6 9 6 6 6-6"/></svg>
                            </div>
                            <p id="book-help" class="mt-2 text-xs leading-5 text-[color:var(--color-text-muted)]">Daftar hanya menampilkan buku yang memiliki stok tersedia.</p>
                            <x-input-error id="book-error" :messages="$errors->get('buku_id')" class="mt-2 text-sm text-[color:var(--color-danger)]" />
                            @if ($bukus->isEmpty())
                                <p class="mt-2 rounded-[var(--radius-control)] bg-[color:var(--color-warning-surface)] px-3 py-2 text-xs text-[color:var(--color-warning)]" role="status">Belum ada buku dengan stok yang dapat dipinjam.</p>
                            @endif
                        </div>
                    </div>
                </section>

                <section class="rounded-[var(--radius-panel)] border border-[color:var(--color-border)] bg-[color:var(--color-surface)] p-5 shadow-[var(--shadow-card)] sm:p-7" aria-labelledby="loan-schedule-heading">
                    <div class="mb-6 flex items-start gap-3">
                        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-[var(--radius-control)] bg-[color:var(--color-surface-muted)] text-[color:var(--color-primary)]" aria-hidden="true">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3.5" y="5" width="17" height="16" rx="2"/><path d="M7.5 3v4m9-4v4M3.5 10h17m-12 4h3"/></svg>
                        </span>
                        <div>
                            <h2 id="loan-schedule-heading" class="text-lg font-bold">Jadwal Peminjaman</h2>
                            <p class="mt-1 text-sm text-[color:var(--color-text-muted)]">Tentukan tanggal mulai dan batas pengembalian.</p>
                        </div>
                    </div>

                    <div class="grid gap-5 sm:grid-cols-2">
                        <div>
                            <label for="tanggal_pinjam" class="mb-2 block text-sm font-semibold">Tanggal Peminjaman</label>
                            <input id="tanggal_pinjam" type="date" name="tanggal_pinjam" value="{{ old('tanggal_pinjam', date('Y-m-d')) }}" required data-loan-date-start aria-describedby="loan-date-error" class="min-h-12 w-full rounded-[var(--radius-control)] border border-[color:var(--color-border)] bg-[color:var(--color-page)] px-4 py-3 text-sm text-[color:var(--color-text)] transition-colors focus:border-[color:var(--color-primary)] focus:outline-none focus:ring-2 focus:ring-[color:var(--color-primary)]/20">
                            <x-input-error id="loan-date-error" :messages="$errors->get('tanggal_pinjam')" class="mt-2 text-sm text-[color:var(--color-danger)]" />
                        </div>
                        <div>
                            <label for="tanggal_kembali" class="mb-2 block text-sm font-semibold">Tanggal Jatuh Tempo</label>
                            <input id="tanggal_kembali" type="date" name="tanggal_kembali" value="{{ old('tanggal_kembali', date('Y-m-d', strtotime('+7 days'))) }}" required data-loan-date-due aria-describedby="due-date-help due-date-error" class="min-h-12 w-full rounded-[var(--radius-control)] border border-[color:var(--color-border)] bg-[color:var(--color-page)] px-4 py-3 text-sm text-[color:var(--color-text)] transition-colors focus:border-[color:var(--color-primary)] focus:outline-none focus:ring-2 focus:ring-[color:var(--color-primary)]/20">
                            <p id="due-date-help" class="mt-2 text-xs leading-5 text-[color:var(--color-text-muted)]">Tanggal batas buku harus dikembalikan ke perpustakaan.</p>
                            <x-input-error id="due-date-error" :messages="$errors->get('tanggal_kembali')" class="mt-2 text-sm text-[color:var(--color-danger)]" />
                        </div>
                    </div>
                </section>

                <div class="flex flex-col-reverse gap-3 border-t border-[color:var(--color-border)] pt-5 sm:flex-row sm:justify-end">
                    <a href="{{ route('admin.peminjaman.index') }}" class="inline-flex min-h-11 items-center justify-center gap-2 rounded-[var(--radius-control)] border border-[color:var(--color-border)] bg-[color:var(--color-surface)] px-5 py-2.5 text-sm font-semibold text-[color:var(--color-text)] transition-colors hover:bg-[color:var(--color-surface-muted)] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[color:var(--color-primary)]">
                        Batal
                    </a>
                    <button type="submit" class="inline-flex min-h-11 items-center justify-center gap-2 rounded-[var(--radius-control)] bg-[color:var(--color-primary)] px-5 py-2.5 text-sm font-semibold text-[color:var(--color-primary-contrast)] shadow-sm transition-colors hover:bg-[color:var(--color-primary-hover)] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[color:var(--color-primary)] focus-visible:ring-offset-2">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M7 3.5h10a2 2 0 0 1 2 2v15l-7-3-7 3v-15a2 2 0 0 1 2-2Z"/><path d="M9 8h6"/></svg>
                        Simpan Peminjaman
                    </button>
                </div>
            </form>

            <aside class="rounded-[var(--radius-panel)] border border-[color:var(--color-border)] bg-[color:var(--color-surface)] p-5 shadow-[var(--shadow-card)] lg:sticky lg:top-24" aria-labelledby="loan-summary-heading" aria-live="polite">
                <div class="flex items-start gap-3">
                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-[var(--radius-control)] bg-[color:var(--color-info-surface)] text-[color:var(--color-primary)]" aria-hidden="true"><svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M5 4.5A2.5 2.5 0 0 1 7.5 2H20v18H7.5A2.5 2.5 0 0 0 5 22.5z"/><path d="M5 4.5v18m7-16v12"/></svg></span>
                    <div>
                        <h2 id="loan-summary-heading" class="text-base font-bold">Ringkasan Transaksi</h2>
                        <p class="mt-1 text-xs leading-5 text-[color:var(--color-text-muted)]">Periksa kembali detail sebelum menyimpan.</p>
                    </div>
                </div>
                <dl class="mt-5 space-y-4">
                    <div class="border-b border-[color:var(--color-border)] pb-3">
                        <dt class="text-xs font-medium text-[color:var(--color-text-muted)]">Siswa</dt>
                        <dd class="mt-1 break-words text-sm font-semibold" data-preview-student>Belum dipilih</dd>
                    </div>
                    <div class="border-b border-[color:var(--color-border)] pb-3">
                        <dt class="text-xs font-medium text-[color:var(--color-text-muted)]">Buku</dt>
                        <dd class="mt-1 break-words text-sm font-semibold" data-preview-book>Belum dipilih</dd>
                    </div>
                    <div class="border-b border-[color:var(--color-border)] pb-3">
                        <dt class="text-xs font-medium text-[color:var(--color-text-muted)]">Stok tersedia</dt>
                        <dd class="mt-1 text-sm font-semibold text-[color:var(--color-success)]" data-preview-stock>—</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-medium text-[color:var(--color-text-muted)]">Periode peminjaman</dt>
                        <dd class="mt-1 text-sm font-semibold" data-preview-dates>Belum ditentukan</dd>
                    </div>
                </dl>
                <p class="mt-5 rounded-[var(--radius-control)] bg-[color:var(--color-surface-muted)] px-3 py-3 text-xs leading-5 text-[color:var(--color-text-muted)]">Peminjaman offline akan langsung tercatat sebagai buku yang sedang dipinjam dan mengurangi stok tersedia.</p>
            </aside>
        </div>
    </main>

    <script>
        (() => {
            const studentSelect = document.querySelector('[data-loan-student]');
            const bookSelect = document.querySelector('[data-loan-book]');
            const startDate = document.querySelector('[data-loan-date-start]');
            const dueDate = document.querySelector('[data-loan-date-due]');
            const studentOutput = document.querySelector('[data-preview-student]');
            const bookOutput = document.querySelector('[data-preview-book]');
            const stockOutput = document.querySelector('[data-preview-stock]');
            const datesOutput = document.querySelector('[data-preview-dates]');
            const formatDate = (value) => {
                if (!value) return null;
                const date = new Date(`${value}T00:00:00`);
                return Number.isNaN(date.getTime()) ? null : new Intl.DateTimeFormat('id-ID', { dateStyle: 'medium' }).format(date);
            };

            function updateSummary() {
                const student = studentSelect?.selectedOptions[0];
                const book = bookSelect?.selectedOptions[0];
                const studentName = student?.dataset.name;
                const studentNis = student?.dataset.nis;
                const studentEmail = student?.dataset.email;
                studentOutput.textContent = studentName
                    ? `${studentName}${studentNis ? ` · NIS ${studentNis}` : (studentEmail ? ` · ${studentEmail}` : '')}`
                    : 'Belum dipilih';

                bookOutput.textContent = book?.dataset.title || 'Belum dipilih';
                const stock = book?.dataset.stock;
                stockOutput.textContent = stock !== undefined ? `${stock} buku` : '—';

                const start = formatDate(startDate?.value);
                const due = formatDate(dueDate?.value);
                datesOutput.textContent = start && due ? `${start} – ${due}` : (start || due || 'Belum ditentukan');
            }

            [studentSelect, bookSelect, startDate, dueDate].forEach((input) => input?.addEventListener('change', updateSummary));
            updateSummary();
        })();
    </script>
</body>
</html>
