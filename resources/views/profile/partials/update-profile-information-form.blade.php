<form id="send-verification" method="post" action="{{ route('verification.send') }}">
    @csrf
</form>

<form method="post" action="{{ route('profile.update') }}" class="space-y-5">
    @csrf
    @method('patch')

    <div class="grid gap-5 sm:grid-cols-2">
        <div>
            <label for="name" class="mb-2 block text-sm font-semibold">Nama lengkap</label>
            <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" aria-describedby="name-error" class="min-h-11 w-full rounded-[var(--radius-control)] border border-[color:var(--color-border)] bg-[color:var(--color-page)] px-4 py-2.5 text-sm text-[color:var(--color-text)] placeholder:text-[color:var(--color-text-muted)] transition-colors focus:border-[color:var(--color-primary)] focus:outline-none focus:ring-2 focus:ring-[color:var(--color-primary)]/20">
            <x-input-error id="name-error" class="mt-2 text-sm text-[color:var(--color-danger)]" :messages="$errors->get('name')" />
        </div>

        <div>
            <label for="email" class="mb-2 block text-sm font-semibold">Alamat email</label>
            <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required autocomplete="username" aria-describedby="email-error" class="min-h-11 w-full rounded-[var(--radius-control)] border border-[color:var(--color-border)] bg-[color:var(--color-page)] px-4 py-2.5 text-sm text-[color:var(--color-text)] placeholder:text-[color:var(--color-text-muted)] transition-colors focus:border-[color:var(--color-primary)] focus:outline-none focus:ring-2 focus:ring-[color:var(--color-primary)]/20">
            <x-input-error id="email-error" class="mt-2 text-sm text-[color:var(--color-danger)]" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-3 rounded-[var(--radius-control)] bg-[color:var(--color-warning-surface)] p-3 text-sm text-[color:var(--color-warning)]">
                    <p>Email Anda belum diverifikasi.</p>
                    <button form="send-verification" type="submit" class="mt-2 font-semibold underline decoration-current underline-offset-2 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[color:var(--color-warning)]">Kirim ulang email verifikasi</button>
                </div>
            @endif
        </div>
    </div>

    <div class="flex flex-col gap-3 border-t border-[color:var(--color-border)] pt-5 sm:flex-row sm:items-center">
        <button type="submit" class="inline-flex min-h-11 items-center justify-center rounded-[var(--radius-control)] bg-[color:var(--color-primary)] px-5 py-2.5 text-sm font-semibold text-[color:var(--color-primary-contrast)] shadow-sm transition-colors hover:bg-[color:var(--color-primary-hover)] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[color:var(--color-primary)] focus-visible:ring-offset-2">Simpan Perubahan</button>
    </div>
</form>
