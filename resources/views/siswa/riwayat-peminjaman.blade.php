<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="color-scheme" content="light dark">
    <title>Riwayat Peminjaman - Perpustakaan Al-Hasra</title>
    @include('components.theme-init')
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/css/design-tokens.css', 'resources/js/theme.js'])
</head>
<body class="min-h-screen bg-[color:var(--color-page)] text-[color:var(--color-text)] antialiased" style="font-family:var(--font-family-sans); transition:var(--transition-colors)">
    <nav class="border-b border-[color:var(--color-border)] bg-[color:var(--color-surface)] px-4 py-4 shadow-[var(--shadow-card)] transition-colors sm:px-8">
        <div class="mx-auto flex max-w-6xl items-center justify-between gap-3">
            <div class="flex min-w-0 items-center gap-3">
                <x-back-button fallback="{{ route('siswa.dashboard') }}" />
                <a href="{{ route('siswa.dashboard') }}" class="truncate text-base font-bold text-[color:var(--color-primary)] sm:text-xl">Perpustakaan Al-Hasra</a>
            </div>
            <div class="flex shrink-0 items-center gap-2 sm:gap-4">
                @include('components.theme-toggle')
                <a href="{{ route('buku.index') }}" class="inline-flex min-h-10 items-center rounded-[var(--radius-control)] border border-[color:var(--color-border)] px-3 text-sm font-semibold text-[color:var(--color-text)] transition-colors hover:bg-[color:var(--color-surface-muted)] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[color:var(--color-primary)] sm:px-4">Katalog Buku</a>
            </div>
        </div>
    </nav>

    <main class="mx-auto max-w-6xl px-4 py-8 sm:px-6 sm:py-10">
        <header class="mb-7 flex flex-col gap-4 sm:mb-8 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="mb-2 text-sm font-semibold text-[color:var(--color-primary)]">AREA SISWA</p>
                <h1 class="text-2xl font-bold tracking-tight sm:text-3xl">Riwayat Peminjaman</h1>
                <p class="mt-2 max-w-2xl text-sm leading-6 text-[color:var(--color-text-muted)] sm:text-base">Pantau status pengajuan, buku yang sedang kamu pinjam, dan pengembalianmu.</p>
            </div>
            <a href="{{ route('buku.index') }}" class="inline-flex min-h-11 items-center justify-center gap-2 rounded-[var(--radius-control)] bg-[color:var(--color-primary)] px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition-colors hover:bg-[color:var(--color-primary-hover)] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[color:var(--color-primary)] focus-visible:ring-offset-2">Cari buku <span aria-hidden="true">→</span></a>
        </header>

        <section class="overflow-hidden rounded-[var(--radius-panel)] border border-[color:var(--color-border)] bg-[color:var(--color-surface)] shadow-[var(--shadow-card)] transition-colors" aria-labelledby="history-heading">
            <div class="flex items-center justify-between gap-3 border-b border-[color:var(--color-border)] px-4 py-4 sm:px-6">
                <div><h2 id="history-heading" class="font-semibold">Semua transaksi</h2><p class="mt-1 text-sm text-[color:var(--color-text-muted)]">{{ $peminjamans->count() }} peminjaman tercatat</p></div>
            </div>

            @if ($peminjamans->isEmpty())
                <div class="px-5 py-14 text-center sm:py-16">
                    <span aria-hidden="true" class="mx-auto grid h-14 w-14 place-items-center rounded-full bg-[color:var(--color-surface-muted)] text-2xl text-[color:var(--color-text-muted)]">▤</span>
                    <h3 class="mt-4 text-lg font-semibold">Belum ada riwayat peminjaman</h3>
                    <p class="mx-auto mt-2 max-w-sm text-sm leading-6 text-[color:var(--color-text-muted)]">Buku yang kamu ajukan akan muncul di sini beserta status dan tanggal pengembaliannya.</p>
                    <a href="{{ route('buku.index') }}" class="mt-5 inline-flex min-h-10 items-center rounded-[var(--radius-control)] bg-[color:var(--color-primary)] px-4 text-sm font-semibold text-white hover:bg-[color:var(--color-primary-hover)]">Jelajahi katalog</a>
                </div>
            @else
                <div class="hidden overflow-x-auto md:block">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-[color:var(--color-surface-muted)] text-xs uppercase tracking-wide text-[color:var(--color-text-muted)]"><tr><th scope="col" class="px-6 py-3">Buku</th><th scope="col" class="px-4 py-3">Tanggal pinjam</th><th scope="col" class="px-4 py-3">Jatuh tempo</th><th scope="col" class="px-4 py-3">Dikembalikan</th><th scope="col" class="px-6 py-3">Status</th></tr></thead>
                        <tbody class="divide-y divide-[color:var(--color-border)]">
                            @foreach ($peminjamans as $peminjaman)
                                <tr class="transition-colors hover:bg-[color:var(--color-surface-muted)]">
                                    <td class="max-w-xs px-6 py-4 font-semibold">{{ $peminjaman->buku->judul ?? 'Buku tidak ditemukan' }}</td>
                                    <td class="whitespace-nowrap px-4 py-4 text-[color:var(--color-text-muted)]">{{ $peminjaman->tanggal_pinjam ? \Illuminate\Support\Carbon::parse($peminjaman->tanggal_pinjam)->translatedFormat('d M Y') : '—' }}</td>
                                    <td class="whitespace-nowrap px-4 py-4 text-[color:var(--color-text-muted)]">{{ $peminjaman->tanggal_kembali ? \Illuminate\Support\Carbon::parse($peminjaman->tanggal_kembali)->translatedFormat('d M Y') : '—' }}</td>
                                    <td class="whitespace-nowrap px-4 py-4 text-[color:var(--color-text-muted)]">{{ $peminjaman->tanggal_pengembalian_aktual ? \Illuminate\Support\Carbon::parse($peminjaman->tanggal_pengembalian_aktual)->translatedFormat('d M Y') : '—' }}</td>
                                    <td class="whitespace-nowrap px-6 py-4">@include('siswa.partials.status-peminjaman', ['status' => $peminjaman->status])</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <ul class="divide-y divide-[color:var(--color-border)] md:hidden">
                    @foreach ($peminjamans as $peminjaman)
                        <li class="p-4 sm:p-5">
                            <div class="flex items-start justify-between gap-3">
                                <h3 class="min-w-0 font-semibold leading-6">{{ $peminjaman->buku->judul ?? 'Buku tidak ditemukan' }}</h3>
                                @include('siswa.partials.status-peminjaman', ['status' => $peminjaman->status])
                            </div>
                            <dl class="mt-4 grid grid-cols-2 gap-x-4 gap-y-3 text-sm">
                                <div><dt class="text-xs text-[color:var(--color-text-muted)]">Tanggal pinjam</dt><dd class="mt-1 font-medium">{{ $peminjaman->tanggal_pinjam ? \Illuminate\Support\Carbon::parse($peminjaman->tanggal_pinjam)->translatedFormat('d M Y') : '—' }}</dd></div>
                                <div><dt class="text-xs text-[color:var(--color-text-muted)]">Jatuh tempo</dt><dd class="mt-1 font-medium">{{ $peminjaman->tanggal_kembali ? \Illuminate\Support\Carbon::parse($peminjaman->tanggal_kembali)->translatedFormat('d M Y') : '—' }}</dd></div>
                                <div class="col-span-2"><dt class="text-xs text-[color:var(--color-text-muted)]">Tanggal dikembalikan</dt><dd class="mt-1 font-medium">{{ $peminjaman->tanggal_pengembalian_aktual ? \Illuminate\Support\Carbon::parse($peminjaman->tanggal_pengembalian_aktual)->translatedFormat('d M Y') : 'Belum dikembalikan' }}</dd></div>
                            </dl>
                        </li>
                    @endforeach
                </ul>
            @endif
        </section>
    </main>
</body>
</html>
