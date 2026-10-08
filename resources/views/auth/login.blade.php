@extends('layouts.guest')

@section('title', 'Masuk')
@section('brand-title', 'Semua kebutuhan toko, dalam kendali.')
@section('brand-description', 'Masuk untuk melanjutkan ke ruang kerja minimarket Anda dan menjaga operasional tetap teratur.')

@section('content')
    <p class="form-kicker">Selamat datang kembali</p>
    <h2 id="auth-title">Masuk ke akun</h2>
    <p class="intro">Gunakan akun terdaftar untuk melanjutkan ke ruang kerja Anda.</p>

    @if (session('status'))
        <p class="feedback success" role="status">{{ session('status') }}</p>
    @endif
    @if ($errors->any())
        <div class="feedback" role="alert">
            @foreach ($errors->all() as $error)<div>{{ $error }}</div>@endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('login.store') }}">
        @csrf
        <div class="field">
            <label class="field-label" for="email">Email</label>
            <div class="input-wrap">
                <input
                    id="email"
                    name="email"
                    type="email"
                    value="{{ old('email') }}"
                    autocomplete="username"
                    placeholder="nama@contoh.com"
                    class="{{ $errors->has('email') ? 'is-invalid' : '' }}"
                    aria-invalid="{{ $errors->has('email') ? 'true' : 'false' }}"
                    required
                    autofocus
                >
            </div>
        </div>

        <div class="field">
            <label class="field-label" for="password">Sandi</label>
            <div class="input-wrap">
                <input
                    id="password"
                    name="password"
                    type="password"
                    autocomplete="current-password"
                    placeholder="Masukkan sandi"
                    class="has-toggle {{ $errors->has('password') ? 'is-invalid' : '' }}"
                    aria-invalid="{{ $errors->has('password') ? 'true' : 'false' }}"
                    required
                >
                <button class="toggle-password" type="button" data-password-toggle="password" aria-controls="password" aria-pressed="false">Lihat</button>
            </div>
        </div>

        <div class="remember">
            <input id="remember" name="remember" type="checkbox" value="1" @checked(old('remember'))>
            <label for="remember">Ingat saya di perangkat ini</label>
        </div>

        <button class="submit" type="submit">Masuk ke ruang kerja</button>
    </form>

    <p class="auth-switch">Belum punya akun? <a href="{{ route('register') }}">Buat akun kasir</a></p>
    <p class="secure-note">
        <svg viewBox="0 0 16 16" fill="none" aria-hidden="true"><path d="M4 7V5a4 4 0 1 1 8 0v2m-8 0h8a1 1 0 0 1 1 1v5a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V8a1 1 0 0 1 1-1Z" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/></svg>
        Sesi Anda dilindungi dengan koneksi aman
    </p>
@endsection

@push('scripts')
<script>
    document.querySelectorAll('[data-password-toggle]').forEach((button) => {
        button.addEventListener('click', () => {
            const input = document.getElementById(button.dataset.passwordToggle);
            const showing = input.type === 'password';
            input.type = showing ? 'text' : 'password';
            button.textContent = showing ? 'Tutup' : 'Lihat';
            button.setAttribute('aria-pressed', String(showing));
            button.setAttribute('aria-label', showing ? 'Sembunyikan sandi' : 'Tampilkan sandi');
        });
    });
</script>
@endpush
