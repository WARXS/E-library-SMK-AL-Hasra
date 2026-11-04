<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="color-scheme" content="light dark">
    <title>Library Al-Hasra — Perpustakaan Digital SMK Al-Hasra</title>

    @include('components.theme-init')

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/css/design-tokens.css', 'resources/js/theme.js'])
</head>
<body class="min-h-screen bg-[color:var(--color-page)] text-[color:var(--color-text)] antialiased" style="font-family: var(--font-family-sans); transition: var(--transition-colors)">
    <header class="border-b border-[color:var(--color-border)] bg-[color:var(--color-surface)]">
        <nav class="mx-auto flex max-w-7xl items-center justify-between gap-2 px-3 py-3 sm:px-6 sm:py-4 lg:px-8" aria-label="Navigasi utama">
            <a href="{{ url('/') }}" class="flex min-w-0 items-center gap-2 text-[color:var(--color-text)]">
                <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-[var(--radius-control)] bg-[color:var(--color-primary)] text-[color:var(--color-primary-contrast)] sm:h-9 sm:w-9" aria-hidden="true">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 7v13m0-13C9.8 5.2 6.5 4.8 3 6v13c3.5-1.2 6.8-.8 9 1m0-13c2.2-1.8 5.5-2.2 9-1v13c-3.5-1.2-6.8-.8-9 1" />
                    </svg>
                </span>
                <span class="truncate text-xs font-bold tracking-tight sm:text-base">Library Al-Hasra</span>
            </a>

            <div class="flex shrink-0 items-center gap-1 sm:gap-2">
                @include('components.theme-toggle')

                @if (Route::has('login'))
                    @auth
                        @if (Auth::user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="rounded-[var(--radius-control)] px-2 py-2 text-xs font-semibold text-[color:var(--color-primary)] transition-colors hover:bg-[color:var(--color-surface-muted)] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[color:var(--color-primary)] sm:px-4 sm:text-sm">Dashboard</a>
                        @elseif (Auth::user()->role === 'siswa')
                            <a href="{{ route('siswa.dashboard') }}" class="rounded-[var(--radius-control)] px-2 py-2 text-xs font-semibold text-[color:var(--color-primary)] transition-colors hover:bg-[color:var(--color-surface-muted)] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[color:var(--color-primary)] sm:px-4 sm:text-sm">Dashboard</a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="rounded-[var(--radius-control)] px-2 py-2 text-xs font-semibold text-[color:var(--color-text)] transition-colors hover:bg-[color:var(--color-surface-muted)] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[color:var(--color-primary)] sm:px-4 sm:text-sm">Masuk</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="rounded-[var(--radius-control)] bg-[color:var(--color-primary)] px-2.5 py-2 text-xs font-semibold text-[color:var(--color-primary-contrast)] transition-colors hover:bg-[color:var(--color-primary-hover)] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[color:var(--color-primary)] focus-visible:ring-offset-2 sm:px-4 sm:text-sm">Daftar<span class="hidden sm:inline"> Siswa</span></a>
                        @endif
                    @endauth
                @endif
            </div>
        </nav>
    </header>

    <main>
        <section class="mx-auto grid min-h-[calc(100svh-4.5rem)] max-w-7xl items-center gap-10 px-5 py-12 sm:px-8 sm:py-16 lg:grid-cols-2 lg:gap-16 lg:px-8 lg:py-20">
            <div class="max-w-xl">
                <p class="mb-5 inline-flex items-center gap-2 rounded-[var(--radius-pill)] border border-[color:var(--color-border)] bg-[color:var(--color-surface)] px-3.5 py-2 text-xs font-semibold tracking-wide text-[color:var(--color-primary)] sm:text-sm">
                    <span class="h-2 w-2 rounded-full bg-[color:var(--color-primary)]" aria-hidden="true"></span>
                    Perpustakaan Digital SMK Al-Hasra
                </p>

                <h1 class="text-4xl font-extrabold leading-tight tracking-tight text-[color:var(--color-text)] sm:text-5xl lg:text-6xl">
                    Temukan bacaan,<br class="hidden sm:block">
                    <span class="text-[color:var(--color-primary)]">buka wawasan.</span>
                </h1>

                <p class="mt-6 max-w-lg text-base leading-7 text-[color:var(--color-text-muted)] sm:text-lg sm:leading-8">
                    Jelajahi buku pelajaran, modul kejuruan, dan referensi untuk mendukung proses belajar siswa SMK Al-Hasra.
                </p>

                <div class="mt-8 flex flex-wrap items-center gap-3">
                    <a href="{{ route('login') }}" class="inline-flex min-h-12 items-center justify-center rounded-[var(--radius-control)] bg-[color:var(--color-primary)] px-5 py-3 text-sm font-semibold text-[color:var(--color-primary-contrast)] shadow-[var(--shadow-card)] transition-colors hover:bg-[color:var(--color-primary-hover)] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[color:var(--color-primary)] focus-visible:ring-offset-2 sm:px-6 sm:text-base">
                        Mulai Membaca Buku
                        <svg class="ms-2 h-4 w-4" viewBox="0 0 20 20" fill="none" aria-hidden="true">
                            <path d="M4 10h12m-5-5 5 5-5 5" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </a>
                    <a href="{{ route('buku.index') }}" class="inline-flex min-h-12 items-center justify-center rounded-[var(--radius-control)] border border-[color:var(--color-border)] bg-[color:var(--color-surface)] px-5 py-3 text-sm font-semibold text-[color:var(--color-text)] transition-colors hover:bg-[color:var(--color-surface-muted)] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[color:var(--color-primary)] sm:px-6 sm:text-base">
                        Jelajahi Katalog
                    </a>
                </div>

                <p class="mt-5 text-sm text-[color:var(--color-text-muted)]">
                    Akses koleksi bacaan sekolah dalam satu tempat.
                </p>
            </div>

            <figure class="mx-auto w-full max-w-xl" aria-labelledby="library-illustration-title">
                <svg class="h-auto w-full" viewBox="0 0 620 480" role="img" aria-labelledby="library-illustration-title library-illustration-description">
                    <title id="library-illustration-title">Ilustrasi perpustakaan digital</title>
                    <desc id="library-illustration-description">Tampilan koleksi buku dan modul belajar pada layar digital.</desc>

                    <rect x="22" y="20" width="576" height="440" rx="30" fill="var(--color-surface-muted)" />
                    <circle cx="530" cy="92" r="34" fill="var(--color-info-surface)" />
                    <circle cx="88" cy="376" r="20" fill="var(--color-info-surface)" />

                    <rect x="92" y="55" width="436" height="304" rx="20" fill="var(--color-surface)" stroke="var(--color-border)" stroke-width="2" />
                    <path d="M92 78a23 23 0 0 1 23-23h390a23 23 0 0 1 23 23v23H92V78Z" fill="var(--color-surface-muted)" />
                    <circle cx="116" cy="79" r="4" fill="var(--color-text-muted)" opacity=".55" />
                    <circle cx="132" cy="79" r="4" fill="var(--color-text-muted)" opacity=".35" />
                    <circle cx="148" cy="79" r="4" fill="var(--color-text-muted)" opacity=".2" />

                    <rect x="121" y="125" width="84" height="103" rx="12" fill="var(--color-primary)" />
                    <path d="M163 148v54m0-54c-11-8-23-8-32-4v49c10-4 22-3 32 5m0-50c11-8 23-8 32-4v49c-10-4-22-3-32 5" fill="none" stroke="var(--color-primary-contrast)" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" />
                    <text x="121" y="250" fill="var(--color-text-muted)" font-size="12" font-weight="600">KOLEKSI BUKU</text>

                    <rect x="230" y="128" width="226" height="12" rx="6" fill="var(--color-text)" opacity=".9" />
                    <rect x="230" y="151" width="176" height="8" rx="4" fill="var(--color-text-muted)" opacity=".55" />
                    <rect x="230" y="167" width="201" height="8" rx="4" fill="var(--color-text-muted)" opacity=".35" />
                    <rect x="230" y="199" width="88" height="34" rx="8" fill="var(--color-info-surface)" />
                    <rect x="328" y="199" width="88" height="34" rx="8" fill="var(--color-surface-muted)" />
                    <rect x="230" y="262" width="276" height="1.5" fill="var(--color-border)" />
                    <rect x="230" y="281" width="120" height="8" rx="4" fill="var(--color-text-muted)" opacity=".5" />
                    <rect x="230" y="298" width="242" height="7" rx="3.5" fill="var(--color-text-muted)" opacity=".25" />
                    <rect x="230" y="315" width="198" height="7" rx="3.5" fill="var(--color-text-muted)" opacity=".2" />

                    <path d="M150 359h320l32 42H118l32-42Z" fill="var(--color-surface)" stroke="var(--color-border)" stroke-width="2" stroke-linejoin="round" />
                    <path d="M278 372h64l10 12h-84l10-12Z" fill="var(--color-surface-muted)" />

                    <rect x="386" y="326" width="136" height="82" rx="14" fill="var(--color-surface)" stroke="var(--color-border)" stroke-width="2" />
                    <path d="M408 351c14-10 28-10 44 0v35c-16-10-30-10-44 0v-35Zm44 0c14-10 28-10 44 0v35c-16-10-30-10-44 0v-35Z" fill="var(--color-info-surface)" stroke="var(--color-primary)" stroke-width="2" stroke-linejoin="round" />
                    <path d="M452 351v35" stroke="var(--color-primary)" stroke-width="2" />

                    <rect x="70" y="284" width="126" height="54" rx="12" fill="var(--color-surface)" stroke="var(--color-border)" stroke-width="2" />
                    <circle cx="94" cy="311" r="8" fill="var(--color-primary)" />
                    <rect x="111" y="306" width="65" height="9" rx="4.5" fill="var(--color-text-muted)" opacity=".65" />
                </svg>
            </figure>
        </section>
    </main>
</body>
</html>
