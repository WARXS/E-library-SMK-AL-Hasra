<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="color-scheme" content="light dark">
    <title>Tambah Buku - Library Al-Hasra</title>
    @include('components.theme-init')
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/css/design-tokens.css', 'resources/js/theme.js'])
</head>
<body class="min-h-screen bg-[color:var(--color-page)] text-[color:var(--color-text)] antialiased" style="font-family: var(--font-family-sans); transition: var(--transition-colors)">
    <header class="border-b border-[color:var(--color-border)] bg-[color:var(--color-surface)]">
        <div class="mx-auto flex min-h-16 max-w-5xl items-center justify-between gap-3 px-4 sm:px-6">
            <div class="flex min-w-0 items-center gap-3">
                <x-back-button fallback="{{ route('admin.buku.index') }}" />
                <a href="{{ route('admin.dashboard') }}" class="truncate text-sm font-bold sm:text-base">Library <span class="text-[color:var(--color-primary)]">Al-Hasra</span></a>
            </div>
            <x-theme-toggle />
        </div>
    </header>

    <main class="mx-auto w-full max-w-3xl px-4 py-7 sm:px-6 sm:py-10">
        <nav class="mb-3 flex items-center gap-2 text-xs font-medium text-[color:var(--color-text-muted)]" aria-label="Breadcrumb">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-[color:var(--color-primary)]">Dashboard</a><span aria-hidden="true">/</span>
            <a href="{{ route('admin.buku.index') }}" class="hover:text-[color:var(--color-primary)]">Manajemen Buku</a><span aria-hidden="true">/</span>
            <span aria-current="page" class="text-[color:var(--color-text)]">Tambah Buku</span>
        </nav>
        <div class="mb-6">
            <h1 class="text-2xl font-bold tracking-tight sm:text-3xl">Tambah Buku</h1>
            <p class="mt-2 text-sm leading-6 text-[color:var(--color-text-muted)]">Lengkapi informasi koleksi yang akan ditambahkan ke perpustakaan.</p>
        </div>

        @if (session('error'))
            <div class="mb-5 rounded-[var(--radius-control)] border border-[color:var(--color-danger)]/20 bg-[color:var(--color-danger-surface)] px-4 py-3 text-sm text-[color:var(--color-danger)]" role="alert">{{ session('error') }}</div>
        @endif

        <section class="rounded-[var(--radius-panel)] border border-[color:var(--color-border)] bg-[color:var(--color-surface)] p-5 shadow-[var(--shadow-card)] sm:p-8">
            <form action="{{ route('admin.buku.store') }}" method="POST" class="space-y-5">
                @csrf

                <div>
                    <label for="judul" class="mb-2 block text-sm font-semibold">Judul Buku</label>
                    <input id="judul" type="text" name="judul" value="{{ old('judul') }}" class="min-h-11 w-full rounded-[var(--radius-control)] border border-[color:var(--color-border)] bg-[color:var(--color-page)] px-4 py-2.5 text-sm text-[color:var(--color-text)] placeholder:text-[color:var(--color-text-muted)] focus:border-[color:var(--color-primary)] focus:outline-none focus:ring-2 focus:ring-[color:var(--color-primary)]/20" placeholder="Masukkan judul buku" aria-describedby="judul-error">
                    <x-input-error :messages="$errors->get('judul')" id="judul-error" class="mt-2 text-sm text-[color:var(--color-danger)]" />
                </div>

                <div>
                    <label for="penulis" class="mb-2 block text-sm font-semibold">Penulis</label>
                    <input id="penulis" type="text" name="penulis" value="{{ old('penulis') }}" class="min-h-11 w-full rounded-[var(--radius-control)] border border-[color:var(--color-border)] bg-[color:var(--color-page)] px-4 py-2.5 text-sm text-[color:var(--color-text)] placeholder:text-[color:var(--color-text-muted)] focus:border-[color:var(--color-primary)] focus:outline-none focus:ring-2 focus:ring-[color:var(--color-primary)]/20" placeholder="Masukkan nama penulis" aria-describedby="penulis-error">
                    <x-input-error :messages="$errors->get('penulis')" id="penulis-error" class="mt-2 text-sm text-[color:var(--color-danger)]" />
                </div>

                <div>
                    <label for="penerbit" class="mb-2 block text-sm font-semibold">Penerbit <span class="font-normal text-[color:var(--color-text-muted)]">(opsional)</span></label>
                    <input id="penerbit" type="text" name="penerbit" value="{{ old('penerbit') }}" class="min-h-11 w-full rounded-[var(--radius-control)] border border-[color:var(--color-border)] bg-[color:var(--color-page)] px-4 py-2.5 text-sm text-[color:var(--color-text)] placeholder:text-[color:var(--color-text-muted)] focus:border-[color:var(--color-primary)] focus:outline-none focus:ring-2 focus:ring-[color:var(--color-primary)]/20" placeholder="Masukkan nama penerbit" aria-describedby="penerbit-error">
                    <x-input-error :messages="$errors->get('penerbit')" id="penerbit-error" class="mt-2 text-sm text-[color:var(--color-danger)]" />
                </div>

                <div>
                    <label for="tahun_terbit" class="mb-2 block text-sm font-semibold">Tahun Terbit <span class="font-normal text-[color:var(--color-text-muted)]">(opsional)</span></label>
                    <input id="tahun_terbit" type="number" name="tahun_terbit" value="{{ old('tahun_terbit') }}" class="min-h-11 w-full rounded-[var(--radius-control)] border border-[color:var(--color-border)] bg-[color:var(--color-page)] px-4 py-2.5 text-sm text-[color:var(--color-text)] placeholder:text-[color:var(--color-text-muted)] focus:border-[color:var(--color-primary)] focus:outline-none focus:ring-2 focus:ring-[color:var(--color-primary)]/20" placeholder="Contoh: 2024" aria-describedby="tahun-error">
                    <x-input-error :messages="$errors->get('tahun_terbit')" id="tahun-error" class="mt-2 text-sm text-[color:var(--color-danger)]" />
                </div>

                <div>
                    <label for="stok" class="mb-2 block text-sm font-semibold">Stok Tersedia</label>
                    <p id="stok-help" class="mb-2 text-xs leading-5 text-[color:var(--color-text-muted)]">Jumlah buku yang tersedia secara fisik dan siap dipinjam. Buku yang sedang dipinjam tidak termasuk.</p>
                    <input id="stok" type="number" name="stok" min="0" step="1" required value="{{ old('stok') }}" class="min-h-11 w-full rounded-[var(--radius-control)] border border-[color:var(--color-border)] bg-[color:var(--color-page)] px-4 py-2.5 text-sm text-[color:var(--color-text)] placeholder:text-[color:var(--color-text-muted)] focus:border-[color:var(--color-primary)] focus:outline-none focus:ring-2 focus:ring-[color:var(--color-primary)]/20" placeholder="Jumlah buku siap dipinjam" aria-describedby="stok-help stok-error">
                    <x-input-error :messages="$errors->get('stok')" id="stok-error" class="mt-2 text-sm text-[color:var(--color-danger)]" />
                </div>

                <div class="flex flex-col-reverse gap-3 border-t border-[color:var(--color-border)] pt-5 sm:flex-row sm:justify-end">
                    <a href="{{ route('admin.buku.index') }}" class="inline-flex min-h-11 items-center justify-center rounded-[var(--radius-control)] border border-[color:var(--color-border)] px-5 py-2.5 text-sm font-semibold text-[color:var(--color-text)] transition-colors hover:bg-[color:var(--color-surface-muted)] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[color:var(--color-primary)]">Batal</a>
                    <button type="submit" class="inline-flex min-h-11 items-center justify-center rounded-[var(--radius-control)] bg-[color:var(--color-primary)] px-5 py-2.5 text-sm font-semibold text-[color:var(--color-primary-contrast)] transition-colors hover:bg-[color:var(--color-primary-hover)] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[color:var(--color-primary)] focus-visible:ring-offset-2">Simpan Buku</button>
                </div>
            </form>
        </section>
    </main>
</body>
</html>
