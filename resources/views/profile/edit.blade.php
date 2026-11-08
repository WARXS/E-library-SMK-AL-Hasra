@php
    $isAdministrator = $user->role === 'admin';
    $dashboardRoute = match ($user->role) {
        'admin' => route('admin.dashboard'),
        'siswa' => route('siswa.dashboard'),
        default => url('/'),
    };
    $roleLabel = $isAdministrator ? 'Administrator' : ($user->role === 'siswa' ? 'Siswa' : ucfirst($user->role ?? 'Pengguna'));
    $profileInitial = mb_strtoupper(mb_substr(trim($user->name), 0, 1));
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="color-scheme" content="light dark">
    <title>{{ $isAdministrator ? 'Profil Administrator' : 'Profil '.$roleLabel }} - Library Al-Hasra</title>
    @include('components.theme-init')
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/css/design-tokens.css', 'resources/js/theme.js'])
    <style>
        body { font-family: var(--font-family-sans); transition: var(--transition-colors); }
        dialog.profile-delete-dialog::backdrop {
            background: rgb(15 23 42 / 0.52);
            backdrop-filter: blur(3px);
        }
        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after { scroll-behavior: auto !important; transition-duration: 0.01ms !important; }
        }
    </style>
</head>
<body class="min-h-screen bg-[color:var(--color-page)] text-[color:var(--color-text)] antialiased">
    <header class="sticky top-0 z-30 border-b border-[color:var(--color-border)] bg-[color:var(--color-surface)]/95 backdrop-blur">
        <div class="mx-auto flex min-h-16 max-w-6xl items-center justify-between gap-3 px-4 sm:px-6 lg:px-8">
            <div class="flex min-w-0 items-center gap-3">
                <x-back-button fallback="{{ $dashboardRoute }}" />
                <div class="min-w-0">
                    <a href="{{ $dashboardRoute }}" class="block truncate text-sm font-bold tracking-tight sm:text-base">Library <span class="text-[color:var(--color-primary)]">Al-Hasra</span></a>
                    <p class="hidden text-xs text-[color:var(--color-text-muted)] sm:block">Pengaturan akun</p>
                </div>
            </div>
            <div class="flex shrink-0 items-center gap-2 sm:gap-3">
                <x-theme-toggle />
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="inline-flex min-h-10 items-center justify-center gap-2 rounded-[var(--radius-control)] border border-[color:var(--color-border)] px-3 text-sm font-semibold text-[color:var(--color-text-muted)] transition-colors hover:bg-[color:var(--color-surface-muted)] hover:text-[color:var(--color-danger)] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[color:var(--color-primary)] sm:px-4">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M10 17l5-5-5-5m5 5H3.5M12 3.5h5a2 2 0 0 1 2 2v13a2 2 0 0 1-2 2h-5"/></svg>
                        <span class="hidden sm:inline">Keluar</span>
                    </button>
                </form>
            </div>
        </div>
    </header>

    <main class="mx-auto w-full max-w-5xl px-4 py-7 sm:px-6 sm:py-10 lg:px-8">
        <nav class="mb-4 flex items-center gap-2 text-xs font-medium text-[color:var(--color-text-muted)]" aria-label="Breadcrumb">
            <a href="{{ $dashboardRoute }}" class="transition-colors hover:text-[color:var(--color-primary)]">Dashboard</a>
            <span aria-hidden="true">/</span>
            <span aria-current="page" class="text-[color:var(--color-text)]">Profil</span>
        </nav>

        <section class="mb-7 flex flex-col gap-5 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="mb-2 text-sm font-semibold text-[color:var(--color-primary)]">Pengaturan akun</p>
                <h1 class="text-2xl font-bold tracking-tight sm:text-3xl">{{ $isAdministrator ? 'Profil Administrator' : 'Profil '.$roleLabel }}</h1>
                <p class="mt-2 max-w-2xl text-sm leading-6 text-[color:var(--color-text-muted)]">Kelola informasi pribadi, keamanan, dan preferensi akses akun Library Al-Hasra.</p>
            </div>
            <a href="{{ $dashboardRoute }}" class="inline-flex min-h-10 items-center justify-center gap-2 self-start rounded-[var(--radius-control)] px-3 text-sm font-semibold text-[color:var(--color-primary)] transition-colors hover:bg-[color:var(--color-info-surface)] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[color:var(--color-primary)] sm:self-auto">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="m14.5 5-7 7 7 7M8 12h12"/></svg>
                Kembali ke Dashboard
            </a>
        </section>

        <section class="mb-7 overflow-hidden rounded-[var(--radius-panel)] border border-[color:var(--color-border)] bg-[color:var(--color-surface)] shadow-[var(--shadow-card)]" aria-label="Ringkasan akun">
            <div class="h-2 bg-[color:var(--color-primary)]" aria-hidden="true"></div>
            <div class="flex flex-col gap-5 p-5 sm:flex-row sm:items-center sm:p-7">
                <div class="flex h-16 w-16 shrink-0 items-center justify-center rounded-full bg-[color:var(--color-info-surface)] text-2xl font-bold text-[color:var(--color-primary)] ring-4 ring-[color:var(--color-surface-muted)] sm:h-20 sm:w-20 sm:text-3xl" aria-hidden="true">{{ $profileInitial }}</div>
                <div class="min-w-0 flex-1">
                    <p class="text-xs font-semibold uppercase tracking-[0.14em] text-[color:var(--color-text-muted)]">Ringkasan akun</p>
                    <h2 class="mt-1 truncate text-xl font-bold tracking-tight sm:text-2xl">{{ $user->name }}</h2>
                    <p class="mt-1 break-all text-sm text-[color:var(--color-text-muted)]">{{ $user->email }}</p>
                </div>
                <span class="inline-flex w-fit items-center gap-2 rounded-full border border-[color:var(--color-primary)]/20 bg-[color:var(--color-info-surface)] px-3.5 py-2 text-xs font-bold text-[color:var(--color-primary)]">
                    <span class="h-1.5 w-1.5 rounded-full bg-[color:var(--color-primary)]" aria-hidden="true"></span>
                    {{ $roleLabel }}
                </span>
            </div>
        </section>

        @if (session('status') === 'profile-updated')
            <div class="mb-5 rounded-[var(--radius-control)] border border-[color:var(--color-success)]/20 bg-[color:var(--color-success-surface)] px-4 py-3 text-sm font-medium text-[color:var(--color-success)]" role="status">Informasi akun berhasil diperbarui.</div>
        @elseif (session('status') === 'password-updated')
            <div class="mb-5 rounded-[var(--radius-control)] border border-[color:var(--color-success)]/20 bg-[color:var(--color-success-surface)] px-4 py-3 text-sm font-medium text-[color:var(--color-success)]" role="status">Password berhasil diperbarui.</div>
        @elseif (session('status') === 'verification-link-sent')
            <div class="mb-5 rounded-[var(--radius-control)] border border-[color:var(--color-info)]/20 bg-[color:var(--color-info-surface)] px-4 py-3 text-sm font-medium text-[color:var(--color-info)]" role="status">Link verifikasi baru telah dikirim ke email Anda.</div>
        @endif

        <div class="space-y-6">
            <section class="rounded-[var(--radius-panel)] border border-[color:var(--color-border)] bg-[color:var(--color-surface)] p-5 shadow-[var(--shadow-card)] sm:p-7" aria-labelledby="account-information-title">
                <div class="mb-6 flex items-start gap-3">
                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-[var(--radius-control)] bg-[color:var(--color-info-surface)] text-[color:var(--color-primary)]" aria-hidden="true"><svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="8" r="3.5"/><path d="M4.5 21a7.5 7.5 0 0 1 15 0"/></svg></span>
                    <div>
                        <h2 id="account-information-title" class="text-lg font-bold">Informasi Akun</h2>
                        <p class="mt-1 text-sm text-[color:var(--color-text-muted)]">Perbarui nama dan alamat email yang terhubung ke akun Anda.</p>
                    </div>
                </div>
                @include('profile.partials.update-profile-information-form', ['user' => $user])
            </section>

            <section class="rounded-[var(--radius-panel)] border border-[color:var(--color-border)] bg-[color:var(--color-surface)] p-5 shadow-[var(--shadow-card)] sm:p-7" aria-labelledby="account-security-title">
                <div class="mb-6 flex items-start gap-3">
                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-[var(--radius-control)] bg-[color:var(--color-surface-muted)] text-[color:var(--color-primary)]" aria-hidden="true"><svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="4" y="10" width="16" height="11" rx="2"/><path d="M8 10V7a4 4 0 0 1 8 0v3m-4 5v2"/></svg></span>
                    <div>
                        <h2 id="account-security-title" class="text-lg font-bold">Keamanan Akun</h2>
                        <p class="mt-1 text-sm text-[color:var(--color-text-muted)]">Gunakan password kuat dan jangan membagikannya kepada orang lain.</p>
                    </div>
                </div>
                @include('profile.partials.update-password-form')
            </section>

            <section class="rounded-[var(--radius-panel)] border border-[color:var(--color-danger)]/30 bg-[color:var(--color-surface)] p-5 shadow-[var(--shadow-card)] sm:p-7" aria-labelledby="danger-zone-title">
                <div class="mb-6 flex items-start gap-3">
                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-[var(--radius-control)] bg-[color:var(--color-danger-surface)] text-[color:var(--color-danger)]" aria-hidden="true"><svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M12 3 2.8 20h18.4L12 3Z"/><path d="M12 9v5m0 3h.01"/></svg></span>
                    <div>
                        <h2 id="danger-zone-title" class="text-lg font-bold">Zona Berbahaya</h2>
                        <p class="mt-1 text-sm leading-6 text-[color:var(--color-text-muted)]">Penghapusan akun bersifat permanen. Akun yang memiliki riwayat peminjaman tidak dapat dihapus agar catatan transaksi perpustakaan tetap terjaga.</p>
                    </div>
                </div>
                @include('profile.partials.delete-user-form')
            </section>
        </div>
    </main>

    <script>
        (() => {
            document.querySelectorAll('[data-profile-password-toggle]').forEach((button) => {
                button.addEventListener('click', () => {
                    const input = document.getElementById(button.dataset.profilePasswordToggle);
                    if (!input) return;

                    const showPassword = input.type === 'password';
                    input.type = showPassword ? 'text' : 'password';
                    button.textContent = showPassword ? 'Sembunyikan' : 'Tampilkan';
                    button.setAttribute('aria-label', showPassword ? 'Sembunyikan password' : 'Tampilkan password');
                    button.setAttribute('aria-pressed', String(showPassword));
                });
            });

            const dialog = document.querySelector('[data-profile-delete-dialog]');
            if (!dialog) return;

            document.querySelector('[data-open-profile-delete]')?.addEventListener('click', () => dialog.showModal());
            dialog.querySelectorAll('[data-close-profile-delete]').forEach((button) => {
                button.addEventListener('click', () => dialog.close());
            });
            dialog.addEventListener('click', (event) => {
                if (event.target === dialog) dialog.close();
            });
            if (dialog.dataset.openOnLoad === 'true') dialog.showModal();
        })();
    </script>
</body>
</html>
