<x-forgot-layout>
<div class="forgot-lock" aria-hidden="true">
    <span class="forgot-lock__circle">
        <svg width="64" height="64" viewBox="0 0 64 64" fill="none">
            <path d="M20 27v-8a12 12 0 0 1 23.3-4" stroke="currentColor" stroke-width="7" stroke-linecap="round" />
            <rect x="13" y="25" width="38" height="31" rx="6" fill="currentColor" />
            <circle cx="32" cy="39" r="4.5" fill="var(--color-primary-contrast)" />
            <path d="M32 43v5" stroke="var(--color-primary-contrast)" stroke-width="3" stroke-linecap="round" />
        </svg>
    </span>
    <span class="forgot-lock__rays"></span>
</div>

<h1 id="forgot-heading" class="forgot-title">Lupa Password?</h1>
<p class="forgot-description">Masukkan alamat email Anda yang terdaftar, kami akan mengirimkan link untuk mereset password Anda.</p>

<x-auth-session-status class="forgot-status" :status="session('status')" />

@if ($errors->any())
    <div class="forgot-error" role="alert">{{ $errors->first() }}</div>
@endif

<form method="POST" action="{{ route('password.email') }}" class="forgot-form">
    @csrf
    <label class="forgot-email-field" for="email">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" aria-hidden="true"><rect x="3" y="5" width="18" height="14" rx="2" stroke="currentColor" stroke-width="1.8" /><path d="m4 7 8 6 8-6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" /></svg>
        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="email" placeholder="Alamat Email" aria-label="Alamat Email">
    </label>
    <x-input-error :messages="$errors->get('email')" class="forgot-error" />

    <button type="submit" class="forgot-submit">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="m21 3-7.1 18-3.7-7.2L3 10.1 21 3Z" fill="currentColor" /><path d="m10.2 13.8 4.5-4.5" stroke="var(--color-primary)" stroke-width="1.5" stroke-linecap="round" /></svg>
        Kirim Link Reset
    </button>
</form>

<div class="forgot-divider"><span></span><span>atau</span><span></span></div>

<a class="forgot-card__login" href="{{ route('login') }}">
    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M19 12H5m0 0 7-7m-7 7 7 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" /></svg>
    Kembali ke Login
</a>
</x-forgot-layout>
