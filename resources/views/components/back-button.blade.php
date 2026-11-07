@props([
    'fallback' => null,
    'class' => '',
])

@php
    $backUser = auth()->user();
    $backRole = $backUser?->role;
    $backFallback = $fallback ?? match ($backRole) {
        'admin' => route('admin.dashboard'),
        'siswa' => route('siswa.dashboard'),
        default => url('/'),
    };
    $safeBackPrefixes = match ($backRole) {
        'admin' => ['/', '/admin/', '/profile', '/katalog'],
        'siswa' => ['/', '/siswa/', '/profile', '/katalog', '/riwayat-peminjaman'],
        default => ['/', '/katalog', '/login', '/register', '/forgot-password', '/reset-password/'],
    };
@endphp

<a
    href="{{ $backFallback }}"
    data-global-back
    data-back-role="{{ $backRole ?? 'guest' }}"
    data-back-prefixes="{{ json_encode($safeBackPrefixes) }}"
    title="Kembali"
    aria-label="Kembali"
    {{ $attributes->class([
        'group inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-[var(--radius-control)] border border-[color:var(--color-border)] bg-[color:var(--color-surface)] text-[color:var(--color-text-muted)] transition-colors hover:bg-[color:var(--color-surface-muted)] hover:text-[color:var(--color-text)] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[color:var(--color-primary)]',
        $class,
    ]) }}
>
    <svg class="h-5 w-5 transition-transform group-hover:-translate-x-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
        <path d="m14.5 5-7 7 7 7M8 12h12" />
    </svg>
</a>

@once
    <script>
        document.addEventListener('click', (event) => {
            const button = event.target.closest('[data-global-back]');
            if (!button) return;

            try {
                const previousPage = new URL(document.referrer);
                const allowedPrefixes = JSON.parse(button.dataset.backPrefixes || '[]');
                const pathIsAllowed = allowedPrefixes.some((prefix) => {
                    if (prefix === '/') return previousPage.pathname === '/';
                    if (prefix.endsWith('/')) return previousPage.pathname.startsWith(prefix);
                    return previousPage.pathname === prefix || previousPage.pathname.startsWith(`${prefix}/`);
                });
                const internalAndRoleSafe = previousPage.origin === window.location.origin && pathIsAllowed;

                if (internalAndRoleSafe && window.history.length > 1) {
                    event.preventDefault();
                    window.history.back();
                }
            } catch (error) {
                // The link's role-aware href remains the fallback destination.
            }
        });
    </script>
@endonce
