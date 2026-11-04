<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="color-scheme" content="light dark">

        <title>{{ config('app.name', 'Library Al-Hasra') }}</title>

        @include('components.theme-init')

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet">
        @vite(['resources/css/app.css', 'resources/css/auth-catalog.css', 'resources/js/theme.js'])
    </head>
    <body class="site-page forgot-page font-sans text-[color:var(--color-text)] antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 forgot-page-shell">
            <div>
                <a href="/" aria-label="Kembali ke beranda">
                    <x-application-logo class="w-20 h-20 fill-current text-[color:var(--color-text-muted)]" />
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-6 py-4 overflow-hidden forgot-card">
                {{ $slot }}
            </div>
        </div>

        <div class="forgot-theme-toggle">
            @include('components.theme-toggle')
        </div>
    </body>
</html>
