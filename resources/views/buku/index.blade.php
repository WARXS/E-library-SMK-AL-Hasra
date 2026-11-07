@php
    $publishers = $bukus->pluck('penerbit')
        ->filter(fn ($publisher) => filled($publisher))
        ->unique()
        ->sort()
        ->values();
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="color-scheme" content="light dark">
    <title>Katalog Buku — Library Al-Hasra</title>

    @include('components.theme-init')

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/css/auth-catalog.css', 'resources/js/theme.js', 'resources/js/auth-catalog.js'])
</head>
<body class="site-page catalog-page">
    <header class="catalog-header">
        <nav class="catalog-nav" aria-label="Navigasi utama">
            <div class="flex shrink-0 items-center gap-3">
                <x-back-button />
                <a href="{{ url('/') }}" class="brand-lockup" aria-label="Library Al-Hasra — beranda">
                    <span class="brand-mark" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 7v13m0-13C9.8 5.2 6.5 4.8 3 6v13c3.5-1.2 6.8-.8 9 1m0-13c2.2-1.8 5.5-2.2 9-1v13c-3.5-1.2-6.8-.8-9 1" />
                        </svg>
                    </span>
                    <span class="brand-name">Library <span>Al-Hasra</span></span>
                </a>
            </div>

            <div class="catalog-nav-links">
                <a href="{{ url('/') }}">Beranda</a>
                <a href="{{ route('buku.index') }}" aria-current="page">Katalog Buku</a>
                @auth
                    @if (Auth::user()->role === 'siswa')
                        <a href="{{ route('peminjaman.riwayat') }}">Riwayat</a>
                    @endif
                @endauth
            </div>

            <div class="catalog-actions">
                @include('components.theme-toggle')
                @auth
                    @if (Auth::user()->role === 'admin')
                        <a class="catalog-action-link catalog-action-link--primary" href="{{ route('admin.dashboard') }}">Dashboard</a>
                    @elseif (Auth::user()->role === 'siswa')
                        <a class="catalog-action-link catalog-action-link--primary" href="{{ route('siswa.dashboard') }}">Dashboard</a>
                    @endif
                @else
                    <a class="catalog-action-link" href="{{ route('login') }}">Masuk</a>
                    @if (Route::has('register'))
                        <a class="catalog-action-link catalog-action-link--primary" href="{{ route('register') }}">Daftar</a>
                    @endif
                @endauth
            </div>
        </nav>
    </header>

    <main class="catalog-main" data-catalog>
        <section class="catalog-intro" aria-labelledby="catalog-title">
            <div>
                <p class="eyebrow">Koleksi perpustakaan sekolah</p>
                <h1 id="catalog-title">Katalog Buku</h1>
                <p>Temukan buku pelajaran, modul kejuruan, dan referensi yang tersedia di Perpustakaan SMK Al-Hasra.</p>
            </div>
            <span class="catalog-count">{{ $bukus->count() }} koleksi</span>
        </section>

        @if (session('success'))
            <div class="catalog-notice catalog-notice--success" role="status">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="catalog-notice catalog-notice--error" role="alert">{{ session('error') }}</div>
        @endif
        @if ($errors->any())
            <div class="catalog-notice catalog-notice--error" role="alert">{{ $errors->first() }}</div>
        @endif

        <div class="catalog-layout">
            <button class="filter-toggle" type="button" data-filter-toggle aria-expanded="false" aria-controls="catalog-filters">
                <span>Filter koleksi</span>
                <span aria-hidden="true">＋</span>
            </button>

            <aside class="filter-sidebar" id="catalog-filters" data-filter-sidebar aria-label="Filter koleksi berdasarkan penerbit">
                <h2 class="filter-heading">Penerbit</h2>
                <p class="filter-caption">Filter memakai nama penerbit yang tercatat pada data koleksi.</p>
                <div class="filter-list">
                    <button class="filter-option" type="button" data-publisher-filter="" aria-pressed="true">
                        <span>Semua buku</span>
                        <span class="filter-option-count">{{ $bukus->count() }}</span>
                    </button>
                    @foreach ($publishers as $publisher)
                        <button class="filter-option" type="button" data-publisher-filter="{{ $publisher }}" aria-pressed="false">
                            <span>{{ $publisher }}</span>
                            <span class="filter-option-count">{{ $bukus->where('penerbit', $publisher)->count() }}</span>
                        </button>
                    @endforeach
                </div>
            </aside>

            <section class="catalog-results" aria-label="Hasil katalog buku">
                <div class="catalog-search-row">
                    <label class="search-control">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" aria-hidden="true">
                            <circle cx="10.8" cy="10.8" r="6.8" />
                            <path d="m16 16 4.5 4.5" />
                        </svg>
                        <input class="form-control" type="search" data-catalog-search placeholder="Cari judul, penulis, atau penerbit…" aria-label="Cari buku berdasarkan judul, penulis, atau penerbit">
                    </label>
                    <span class="result-count" data-result-count aria-live="polite">{{ $bukus->count() }} buku ditemukan</span>
                </div>

                <div class="book-grid" data-book-grid>
                    @foreach ($bukus as $buku)
                        <article class="book-card" data-book-card data-publisher="{{ $buku->penerbit ?? '' }}" data-search="{{ implode(' ', array_filter([$buku->judul, $buku->penulis, $buku->penerbit])) }}">
                            <div class="book-cover" aria-label="Sampul buku {{ $buku->judul }}">
                                @if ($buku->cover)
                                    <img src="{{ asset('storage/'.$buku->cover) }}" alt="Sampul {{ $buku->judul }}" loading="lazy">
                                @else
                                    <span class="book-cover-placeholder" aria-hidden="true">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M12 7v13m0-13C9.8 5.2 6.5 4.8 3 6v13c3.5-1.2 6.8-.8 9 1m0-13c2.2-1.8 5.5-2.2 9-1v13c-3.5-1.2-6.8-.8-9 1" />
                                        </svg>
                                    </span>
                                @endif
                            </div>

                            <div class="book-card-body">
                                @if ($buku->penerbit)
                                    <span class="book-publisher">{{ $buku->penerbit }}</span>
                                @else
                                    <span class="book-publisher">Koleksi sekolah</span>
                                @endif
                                <h2 class="book-title">{{ $buku->judul }}</h2>
                                <p class="book-author">{{ $buku->penulis }}</p>
                                @if ($buku->tahun_terbit)
                                    <p class="book-year">Terbit {{ $buku->tahun_terbit }}</p>
                                @endif

                                <div class="book-card-footer">
                                    <span class="book-availability {{ $buku->stok < 1 ? 'book-availability--empty' : '' }}">
                                        {{ $buku->stok < 1 ? 'Tidak tersedia' : 'Tersedia' }}
                                    </span>
                                    <span class="book-stock">Stok {{ $buku->stok }}</span>
                                </div>

                                <form action="{{ route('peminjaman.store') }}" method="POST" class="book-loan-form">
                                    @csrf
                                    <input type="hidden" name="buku_id" value="{{ $buku->id }}">
                                    <button type="submit" class="book-loan-button" {{ $buku->stok < 1 ? 'disabled' : '' }}>
                                        {{ $buku->stok < 1 ? 'Stok Habis' : 'Ajukan Peminjaman' }}
                                    </button>
                                </form>
                            </div>
                        </article>
                    @endforeach
                </div>

                <div class="catalog-empty {{ $bukus->isEmpty() ? 'is-visible' : '' }}" data-catalog-empty role="status">
                    <strong data-empty-title>{{ $bukus->isEmpty() ? 'Belum ada buku di katalog' : 'Buku tidak ditemukan' }}</strong>
                    <span data-empty-description>{{ $bukus->isEmpty() ? 'Koleksi buku akan tampil di sini setelah tersedia.' : 'Coba kata pencarian lain atau pilih semua buku.' }}</span>
                </div>
            </section>
        </div>
    </main>
</body>
</html>
