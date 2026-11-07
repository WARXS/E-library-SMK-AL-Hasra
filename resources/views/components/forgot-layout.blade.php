<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="color-scheme" content="light dark">
    <title>Lupa Password — Library Al-Hasra</title>

    @include('components.theme-init')

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/css/auth-catalog.css', 'resources/js/theme.js'])
</head>
<body class="site-page forgot-page font-sans antialiased">
    <div class="forgot-background-shape forgot-background-shape--left" aria-hidden="true"></div>
    <div class="forgot-background-shape forgot-background-shape--right" aria-hidden="true"></div>

    <header class="forgot-header">
        <a class="forgot-brand" href="{{ url('/') }}" aria-label="Library Al-Hasra, beranda">
            <svg class="forgot-brand__icon" width="72" height="72" viewBox="0 0 72 72" fill="none" aria-hidden="true">
                <path d="M36 17v43m0-43C27 10 16 10 7 14v42c10-4 20-3 29 4m0-43c9-7 20-7 29-3v42c-10-4-20-3-29 4" stroke="currentColor" stroke-width="4" stroke-linecap="round" stroke-linejoin="round" />
                <path d="m36 3 2.2 5.2 5.6.4-4.3 3.6 1.4 5.4-4.9-3-4.9 3 1.4-5.4-4.3-3.6 5.6-.4L36 3Z" fill="#fbbf24" />
            </svg>
            <span>Library<br>Al-Hasra</span>
        </a>
        <a class="forgot-header__login" href="{{ route('login') }}">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M19 12H5m0 0 7-7m-7 7 7 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" /></svg>
            Kembali ke Login
        </a>
    </header>

    <main class="forgot-main">
        <section class="forgot-card" aria-labelledby="forgot-heading">
            {{ $slot }}
        </section>
    </main>

    <footer class="forgot-footer">Library Al-Hasra <span aria-hidden="true">|</span> Membaca Hari Ini, Untuk Masa Depan Nanti <span aria-hidden="true">✨</span></footer>
</body>
</html>
