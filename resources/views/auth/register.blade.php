@extends('layouts.guest')

@section('title', 'Daftar')
@section('brand-title', 'Mulai kelola toko dengan lebih mudah.')
@section('brand-description', 'Buat akun kasir untuk masuk ke ruang kerja penjualan dan membantu operasional minimarket.')

@section('content')
    <p class="form-kicker">Mulai bergabung</p>
    <h2 id="auth-title">Buat akun kasir</h2>
    <p class="intro">Lengkapi informasi berikut untuk membuat akun baru.</p>

    @if ($errors->any())
        <div class="feedback" role="alert">
            @foreach ($errors->all() as $error)<div>{{ $error }}</div>@endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('register.store') }}">
        @csrf
        <div class="field">
            <label class="field-label" for="name">Nama lengkap</label>
            <div class="input-wrap">
                <input
                    id="name"
                    name="name"
                    type="text"
                    value="{{ old('name') }}"
                    autocomplete="name"
                    maxlength="255"
                    placeholder="Nama Anda"
                    class="{{ $errors->has('name') ? 'is-invalid' : '' }}"
                    aria-invalid="{{ $errors->has('name') ? 'true' : 'false' }}"
                    required
                    autofocus
                >
            </div>
            @error('name')<span class="input-error">{{ $message }}</span>@enderror
        </div>

        <div class="field">
            <label class="field-label" for="email">Email</label>
            <div class="input-wrap">
                <input
                    id="email"
                    name="email"
                    type="email"
                    value="{{ old('email') }}"
                    autocomplete="email"
                    maxlength="255"
                    placeholder="nama@contoh.com"
                    class="{{ $errors->has('email') ? 'is-invalid' : '' }}"
                    aria-invalid="{{ $errors->has('email') ? 'true' : 'false' }}"
                    required
                >
            </div>
            @error('email')<span class="input-error">{{ $message }}</span>@enderror
        </div>

        <div class="field">
            <label class="field-label" for="password">Sandi</label>
            <div class="input-wrap">
                <input
                    id="password"
                    name="password"
                    type="password"
                    autocomplete="new-password"
                    minlength="8"
                    placeholder="Minimal 8 karakter"
                    class="has-toggle {{ $errors->has('password') ? 'is-invalid' : '' }}"
                    aria-invalid="{{ $errors->has('password') ? 'true' : 'false' }}"
                    required
                >
                <button class="toggle-password" type="button" data-password-toggle="password" aria-controls="password" aria-pressed="false">Lihat</button>
            </div>
            @error('password')<span class="input-error">{{ $message }}</span>@enderror
        </div>

        <div class="field">
            <label class="field-label" for="password_confirmation">Ulangi sandi</label>
            <div class="input-wrap">
                <input
                    id="password_confirmation"
                    name="password_confirmation"
                    type="password"
                    autocomplete="new-password"
                    minlength="8"
                    placeholder="Masukkan sandi yang sama"
                    class="has-toggle {{ $errors->has('password') ? 'is-invalid' : '' }}"
                    aria-invalid="{{ $errors->has('password') ? 'true' : 'false' }}"
                    required
                >
                <button class="toggle-password" type="button" data-password-toggle="password_confirmation" aria-controls="password_confirmation" aria-pressed="false">Lihat</button>
            </div>
        </div>

        <button class="submit" type="submit" style="margin-top:24px">Buat akun kasir</button>
    </form>

    <p class="auth-switch">Sudah memiliki akun? <a href="{{ route('login') }}">Masuk di sini</a></p>
    <p class="secure-note">Registrasi publik hanya memberikan akses kasir.</p>
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
