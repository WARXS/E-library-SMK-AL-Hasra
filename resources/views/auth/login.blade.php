<x-auth-layout
    title="Selamat Datang Kembali"
    description="Masuk untuk menjelajahi koleksi dan mengelola peminjaman buku sekolah."
>
    <x-auth-session-status class="auth-status" :status="session('status')" />

    @if ($errors->any())
        <div class="form-alert" role="alert">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="auth-form" data-loading-form>
        @csrf

        <div class="form-field">
            <label for="email">Email</label>
            <input id="email" class="form-control" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="nama@email.com" aria-describedby="email-error">
            <x-input-error :messages="$errors->get('email')" id="email-error" class="field-error" />
        </div>

        <div class="form-field">
            <div class="field-label-row">
                <label for="password">Password</label>
                @if (Route::has('password.request'))
                    <a class="text-link" href="{{ route('password.request') }}">Lupa password?</a>
                @endif
            </div>
            <div class="password-control">
                <input id="password" class="form-control" type="password" name="password" required autocomplete="current-password" aria-describedby="password-error">
                <button class="password-toggle" type="button" data-password-toggle="password" aria-label="Tampilkan password" aria-pressed="false">Tampilkan</button>
            </div>
            <x-input-error :messages="$errors->get('password')" id="password-error" class="field-error" />
        </div>

        <div class="form-options">
            <label class="checkbox-label" for="remember_me">
                <input id="remember_me" type="checkbox" name="remember" value="1" @checked(old('remember'))>
                <span>Ingat saya</span>
            </label>
        </div>

        <button class="button-primary button-full" type="submit" data-submit-label data-default-label="Masuk" data-loading-label="Memproses…">Masuk</button>
        <p class="form-footnote">Belum memiliki akun siswa? <a class="text-link" href="{{ route('register') }}">Daftar sekarang</a></p>
    </form>
</x-auth-layout>
