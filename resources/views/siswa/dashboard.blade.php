<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="color-scheme" content="light dark">
    <title>Dashboard Siswa - Perpustakaan Al-Hasra</title>
    @include('components.theme-init')
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/css/design-tokens.css', 'resources/js/theme.js'])
</head>
<body class="bg-[color:var(--color-page)] text-[color:var(--color-text)] min-h-screen antialiased" style="font-family: var(--font-family-sans); transition: var(--transition-colors)">

    <nav class="bg-[color:var(--color-surface)] shadow-[var(--shadow-card)] border-b border-[color:var(--color-border)] text-[color:var(--color-text)] px-8 py-4 flex justify-between items-center transition-colors">
        <h1 class="text-xl font-bold text-[color:var(--color-primary)]">
            Perpustakaan Al-Hasra
        </h1>

        <div class="flex items-center gap-4">
            <span class="text-[color:var(--color-text-muted)]">
                Halo, {{ Auth::user()->name }}
            </span>

            @include('components.theme-toggle')

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="bg-[color:var(--color-danger-surface)] text-[color:var(--color-danger)] px-4 py-2 rounded-[var(--radius-control)] hover:opacity-80 transition-opacity focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[color:var(--color-danger)]">
                    Logout
                </button>
            </form>
        </div>
    </nav>

    <main class="max-w-6xl mx-auto px-6 py-10">

        <h2 class="text-3xl font-bold text-[color:var(--color-text)]">
            Dashboard Siswa
        </h2>

        <p class="text-[color:var(--color-text-muted)] mt-2 mb-8">
            Selamat datang di dashboard Perpustakaan Al-Hasra.
        </p>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            <div class="bg-[color:var(--color-surface)] text-[color:var(--color-text)] border border-[color:var(--color-border)] p-6 rounded-[var(--radius-card)] shadow-[var(--shadow-card)] transition-colors">
                <p class="text-[color:var(--color-text-muted)]">Menunggu Persetujuan</p>
                <h3 class="text-4xl font-bold text-[color:var(--color-warning)] mt-3">
                    {{ $menunggu }}
                </h3>
            </div>

            <div class="bg-[color:var(--color-surface)] text-[color:var(--color-text)] border border-[color:var(--color-border)] p-6 rounded-[var(--radius-card)] shadow-[var(--shadow-card)] transition-colors">
                <p class="text-[color:var(--color-text-muted)]">Sedang Dipinjam</p>
                <h3 class="text-4xl font-bold text-[color:var(--color-info)] mt-3">
                    {{ $sedangDipinjam }}
                </h3>
            </div>

            <div class="bg-[color:var(--color-surface)] text-[color:var(--color-text)] border border-[color:var(--color-border)] p-6 rounded-[var(--radius-card)] shadow-[var(--shadow-card)] transition-colors">
                <p class="text-[color:var(--color-text-muted)]">Sudah Dikembalikan</p>
                <h3 class="text-4xl font-bold text-[color:var(--color-success)] mt-3">
                    {{ $sudahDikembalikan }}
                </h3>
            </div>

        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">

            <a href="{{ route('buku.index') }}"
               class="bg-[color:var(--color-primary)] text-[color:var(--color-primary-contrast)] p-6 rounded-[var(--radius-card)] shadow-[var(--shadow-card)] hover:bg-[color:var(--color-primary-hover)] transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[color:var(--color-primary)] focus-visible:ring-offset-2">
                <h3 class="text-xl font-bold">Lihat Katalog Buku</h3>
                <p class="mt-2 text-indigo-100">
                    Cari dan ajukan peminjaman buku.
                </p>
            </a>

            <a href="{{ route('peminjaman.riwayat') }}"
               class="bg-[color:var(--color-surface)] text-[color:var(--color-text)] border border-[color:var(--color-border)] p-6 rounded-[var(--radius-card)] shadow-[var(--shadow-card)] hover:bg-[color:var(--color-surface-muted)] transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[color:var(--color-primary)] focus-visible:ring-offset-2">
                <h3 class="text-xl font-bold">Riwayat Peminjaman</h3>
                <p class="mt-2 text-[color:var(--color-text-muted)]">
                    Lihat status dan riwayat peminjamanmu.
                </p>
            </a>

        </div>

    </main>

</body>
</html>
