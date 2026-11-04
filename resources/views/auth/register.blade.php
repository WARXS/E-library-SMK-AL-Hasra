<x-auth-layout
    title="Buat Akun Siswa"
    description="Daftarkan akun untuk mengakses layanan perpustakaan digital SMK Al-Hasra."
    variant="register"
>
    @if ($errors->any())
        <div class="form-alert" role="alert">Mohon periksa kembali data yang ditandai di bawah.</div>
    @endif

    <form method="POST" action="{{ route('register') }}" class="auth-form auth-form--register" data-loading-form>
        @csrf

        <div class="form-field">
            <label for="name">Nama lengkap</label>
            <input id="name" class="form-control" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="Nama sesuai identitas sekolah" aria-describedby="name-error">
            <x-input-error :messages="$errors->get('name')" id="name-error" class="field-error" />
        </div>

        <div class="form-field">
            <label for="email">Email</label>
            <input id="email" class="form-control" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" placeholder="nama@email.com" aria-describedby="email-error">
            <x-input-error :messages="$errors->get('email')" id="email-error" class="field-error" />
        </div>

        <div class="form-field">
            <label for="password">Password</label>
            <div class="password-control">
                <input id="password" class="form-control" type="password" name="password" required autocomplete="new-password" aria-describedby="password-error">
                <button class="password-toggle" type="button" data-password-toggle="password" aria-label="Tampilkan password" aria-pressed="false">Tampilkan</button>
            </div>
            <x-input-error :messages="$errors->get('password')" id="password-error" class="field-error" />
        </div>

        <div class="form-field">
            <label for="password_confirmation">Konfirmasi password</label>
            <div class="password-control">
                <input id="password_confirmation" class="form-control" type="password" name="password_confirmation" required autocomplete="new-password" aria-describedby="password-confirmation-error">
                <button class="password-toggle" type="button" data-password-toggle="password_confirmation" aria-label="Tampilkan konfirmasi password" aria-pressed="false">Tampilkan</button>
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" id="password-confirmation-error" class="field-error" />
        </div>

        <button class="button-primary button-full" type="submit" data-submit-label data-default-label="Daftar" data-loading-label="Memproses…">Daftar</button>
        <p class="form-footnote">Sudah memiliki akun? <a class="text-link" href="{{ route('login') }}">Masuk</a></p>
    </form>
</x-auth-layout>
