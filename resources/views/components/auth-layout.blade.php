@props([
    'title',
    'description',
    'variant' => 'login',
])

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="color-scheme" content="light dark">
    <title>{{ $title }} — Library Al-Hasra</title>

    @include('components.theme-init')

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/css/auth-catalog.css', 'resources/js/theme.js', 'resources/js/auth-catalog.js'])
</head>
<body class="site-page auth-page auth-page--{{ $variant }}">
    <main class="auth-frame">
        <div class="auth-topbar">
            <a href="{{ url('/') }}" class="brand-lockup" aria-label="Library Al-Hasra — beranda">
                <span class="brand-mark" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 7v13m0-13C9.8 5.2 6.5 4.8 3 6v13c3.5-1.2 6.8-.8 9 1m0-13c2.2-1.8 5.5-2.2 9-1v13c-3.5-1.2-6.8-.8-9 1" />
                    </svg>
                </span>
                <span class="brand-name">Library <span>Al-Hasra</span></span>
            </a>
            @include('components.theme-toggle')
        </div>

        <div class="auth-content auth-content--{{ $variant }}">
            <section class="auth-form-panel" aria-labelledby="auth-title">
                <div class="auth-form-inner" data-animate-in>
                    <p class="eyebrow">Perpustakaan Digital SMK Al-Hasra</p>
                    <h1 id="auth-title">{{ $title }}</h1>
                    <p class="auth-description">{{ $description }}</p>
                    {{ $slot }}
                </div>
            </section>

            <aside class="auth-art-panel" aria-label="Ilustrasi koleksi buku perpustakaan">
                <div class="auth-art-copy" data-animate-in>
                    <span class="art-kicker">Ruang untuk terus bertumbuh</span>
                    <h2>Temukan pengetahuan, satu halaman setiap hari.</h2>
                    <p>Jelajahi koleksi belajar dan referensi untuk mendukung perjalanan literasi siswa.</p>
                </div>
                <svg class="library-illustration" viewBox="0 0 560 420" fill="none" role="img" aria-label="Ilustrasi buku dan rak perpustakaan">
                    <ellipse cx="283" cy="369" rx="206" ry="21" fill="var(--color-art-shadow)" />
                    <path d="M104 329h358v20H104z" fill="var(--color-art-shelf)" />
                    <path d="M125 319V192h74v127m17 0V152h72v167m19 0V207h68v112m18 0V174h72v145" stroke="var(--color-art-shelf)" stroke-width="12" stroke-linejoin="round" />
                    <path d="M136 300V214h18v86m19 0V205h17v95m35 0V173h17v127m19 0V166h17v134m32 0v-78h17v78m18 0v-78h17v78m36 0v-99h17v99m19 0v-99h17v99" fill="var(--color-art-book)" />
                    <path d="M136 300V214h18v86m19 0V205h17v95m35 0V173h17v127m19 0V166h17v134m32 0v-78h17v78m18 0v-78h17v78m36 0v-99h17v99m19 0v-99h17v99" stroke="var(--color-art-book-line)" stroke-width="2" />
                    <path d="M181 347h164l-16 15H197z" fill="var(--color-art-page)" />
                    <path d="M181 347c23-17 52-17 82 0v48c-29-17-58-17-82 0v-48Z" fill="var(--color-primary)" />
                    <path d="M345 347c-23-17-52-17-82 0v48c29-17 58-17 82 0v-48Z" fill="var(--color-art-book)" />
                    <path d="M263 347v47m-64-35c19-7 37-6 54 3m38-3c19-7 37-6 54 3" stroke="var(--color-art-page)" stroke-width="3" stroke-linecap="round" />
                    <circle cx="422" cy="106" r="33" fill="var(--color-art-accent)" />
                    <path d="M422 87v38m-19-19h38" stroke="var(--color-art-accent-line)" stroke-width="4" stroke-linecap="round" />
                    <path d="m104 124 12-24 12 24-12 24-12-24Z" fill="var(--color-primary)" opacity=".72" />
                </svg>
                <span class="art-caption">Baca · Belajar · Berkembang</span>
            </aside>
        </div>
    </main>
</body>
</html>
