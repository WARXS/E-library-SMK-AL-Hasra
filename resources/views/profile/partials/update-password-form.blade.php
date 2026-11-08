<form method="post" action="{{ route('password.update') }}" class="space-y-5">
    @csrf
    @method('put')

    <div class="grid gap-5 lg:grid-cols-3">
        <div>
            <label for="update_password_current_password" class="mb-2 block text-sm font-semibold">Password saat ini</label>
            <div class="relative">
                <input id="update_password_current_password" name="current_password" type="password" autocomplete="current-password" aria-describedby="current-password-error" class="min-h-11 w-full rounded-[var(--radius-control)] border border-[color:var(--color-border)] bg-[color:var(--color-page)] py-2.5 pl-4 pr-24 text-sm text-[color:var(--color-text)] transition-colors focus:border-[color:var(--color-primary)] focus:outline-none focus:ring-2 focus:ring-[color:var(--color-primary)]/20">
                <button type="button" data-profile-password-toggle="update_password_current_password" aria-label="Tampilkan password" aria-pressed="false" class="absolute inset-y-1 right-1 rounded-md px-2.5 text-xs font-semibold text-[color:var(--color-primary)] transition-colors hover:bg-[color:var(--color-info-surface)] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[color:var(--color-primary)]">Tampilkan</button>
            </div>
            <x-input-error id="current-password-error" :messages="$errors->updatePassword->get('current_password')" class="mt-2 text-sm text-[color:var(--color-danger)]" />
        </div>

        <div>
            <label for="update_password_password" class="mb-2 block text-sm font-semibold">Password baru</label>
            <div class="relative">
                <input id="update_password_password" name="password" type="password" autocomplete="new-password" aria-describedby="new-password-error" class="min-h-11 w-full rounded-[var(--radius-control)] border border-[color:var(--color-border)] bg-[color:var(--color-page)] py-2.5 pl-4 pr-24 text-sm text-[color:var(--color-text)] transition-colors focus:border-[color:var(--color-primary)] focus:outline-none focus:ring-2 focus:ring-[color:var(--color-primary)]/20">
                <button type="button" data-profile-password-toggle="update_password_password" aria-label="Tampilkan password" aria-pressed="false" class="absolute inset-y-1 right-1 rounded-md px-2.5 text-xs font-semibold text-[color:var(--color-primary)] transition-colors hover:bg-[color:var(--color-info-surface)] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[color:var(--color-primary)]">Tampilkan</button>
            </div>
            <x-input-error id="new-password-error" :messages="$errors->updatePassword->get('password')" class="mt-2 text-sm text-[color:var(--color-danger)]" />
        </div>

        <div>
            <label for="update_password_password_confirmation" class="mb-2 block text-sm font-semibold">Konfirmasi password baru</label>
            <div class="relative">
                <input id="update_password_password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" aria-describedby="password-confirmation-error" class="min-h-11 w-full rounded-[var(--radius-control)] border border-[color:var(--color-border)] bg-[color:var(--color-page)] py-2.5 pl-4 pr-24 text-sm text-[color:var(--color-text)] transition-colors focus:border-[color:var(--color-primary)] focus:outline-none focus:ring-2 focus:ring-[color:var(--color-primary)]/20">
                <button type="button" data-profile-password-toggle="update_password_password_confirmation" aria-label="Tampilkan password" aria-pressed="false" class="absolute inset-y-1 right-1 rounded-md px-2.5 text-xs font-semibold text-[color:var(--color-primary)] transition-colors hover:bg-[color:var(--color-info-surface)] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[color:var(--color-primary)]">Tampilkan</button>
            </div>
            <x-input-error id="password-confirmation-error" :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2 text-sm text-[color:var(--color-danger)]" />
        </div>
    </div>

    <div class="flex flex-col gap-3 border-t border-[color:var(--color-border)] pt-5 sm:flex-row sm:items-center">
        <button type="submit" class="inline-flex min-h-11 items-center justify-center rounded-[var(--radius-control)] bg-[color:var(--color-primary)] px-5 py-2.5 text-sm font-semibold text-[color:var(--color-primary-contrast)] shadow-sm transition-colors hover:bg-[color:var(--color-primary-hover)] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[color:var(--color-primary)] focus-visible:ring-offset-2">Simpan Password</button>
    </div>
</form>
