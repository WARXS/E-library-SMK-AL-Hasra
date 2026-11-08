@if ($errors->userDeletion->isNotEmpty())
    <div class="mb-4 rounded-[var(--radius-control)] border border-[color:var(--color-danger)]/20 bg-[color:var(--color-danger-surface)] px-4 py-3 text-sm text-[color:var(--color-danger)]" role="alert">
        {{ $errors->userDeletion->first('password') }}
    </div>
@endif

<div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
    <p class="max-w-2xl text-sm leading-6 text-[color:var(--color-text-muted)]">Untuk melindungi akun, Anda perlu memasukkan password sebelum melanjutkan. Riwayat peminjaman tetap harus dipertahankan.</p>
    <button type="button" data-open-profile-delete class="inline-flex min-h-11 shrink-0 items-center justify-center rounded-[var(--radius-control)] border border-[color:var(--color-danger)]/30 bg-[color:var(--color-danger-surface)] px-5 py-2.5 text-sm font-semibold text-[color:var(--color-danger)] transition-colors hover:border-[color:var(--color-danger)] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[color:var(--color-danger)]">
        Hapus Akun
    </button>
</div>

<dialog data-profile-delete-dialog data-open-on-load="{{ $errors->userDeletion->isNotEmpty() ? 'true' : 'false' }}" aria-labelledby="delete-account-title" aria-describedby="delete-account-description" class="profile-delete-dialog w-[calc(100%-2rem)] max-w-lg rounded-[var(--radius-panel)] border border-[color:var(--color-border)] bg-[color:var(--color-surface)] p-0 text-[color:var(--color-text)] shadow-[var(--shadow-panel)]">
    <form method="post" action="{{ route('profile.destroy') }}" class="p-5 sm:p-7">
        @csrf
        @method('delete')

        <div class="flex items-start gap-3">
            <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-[var(--radius-control)] bg-[color:var(--color-danger-surface)] text-[color:var(--color-danger)]" aria-hidden="true"><svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M12 3 2.8 20h18.4L12 3Z"/><path d="M12 9v5m0 3h.01"/></svg></span>
            <div>
                <h2 id="delete-account-title" class="text-lg font-bold">Konfirmasi penghapusan akun</h2>
                <p id="delete-account-description" class="mt-2 text-sm leading-6 text-[color:var(--color-text-muted)]">Tindakan ini akan menghapus akses akun secara permanen. Masukkan password Anda untuk mengonfirmasi. Akun dengan riwayat peminjaman tidak dapat dihapus.</p>
            </div>
        </div>

        <div class="mt-6">
            <label for="delete_account_password" class="mb-2 block text-sm font-semibold">Password saat ini</label>
            <div class="relative">
                <input id="delete_account_password" name="password" type="password" autocomplete="current-password" aria-describedby="delete-password-error" class="min-h-11 w-full rounded-[var(--radius-control)] border border-[color:var(--color-border)] bg-[color:var(--color-page)] py-2.5 pl-4 pr-24 text-sm text-[color:var(--color-text)] focus:border-[color:var(--color-primary)] focus:outline-none focus:ring-2 focus:ring-[color:var(--color-primary)]/20">
                <button type="button" data-profile-password-toggle="delete_account_password" aria-label="Tampilkan password" aria-pressed="false" class="absolute inset-y-1 right-1 rounded-md px-2.5 text-xs font-semibold text-[color:var(--color-primary)] hover:bg-[color:var(--color-info-surface)] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[color:var(--color-primary)]">Tampilkan</button>
            </div>
            <x-input-error id="delete-password-error" :messages="$errors->userDeletion->get('password')" class="mt-2 text-sm text-[color:var(--color-danger)]" />
        </div>

        <div class="mt-7 flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
            <button type="button" data-close-profile-delete class="inline-flex min-h-11 items-center justify-center rounded-[var(--radius-control)] border border-[color:var(--color-border)] px-5 py-2.5 text-sm font-semibold text-[color:var(--color-text)] transition-colors hover:bg-[color:var(--color-surface-muted)] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[color:var(--color-primary)]">Batal</button>
            <button type="submit" class="inline-flex min-h-11 items-center justify-center rounded-[var(--radius-control)] bg-[color:var(--color-danger)] px-5 py-2.5 text-sm font-semibold text-white transition-colors hover:opacity-90 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[color:var(--color-danger)] focus-visible:ring-offset-2">Ya, Hapus Akun</button>
        </div>
    </form>
</dialog>
