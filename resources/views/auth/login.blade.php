<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#173b32">
    <title>Masuk | Minimarket</title>
    <style>
        :root {
            color-scheme: light;
            --ink: #202a25;
            --muted: #68736d;
            --line: #dce3dd;
            --paper: #f4f6f1;
            --green: #1d5948;
            --green-dark: #173b32;
            --lime: #d5e77d;
            --error: #a3382c;
        }

        * { box-sizing: border-box; }

        body {
            min-height: 100vh;
            margin: 0;
            display: grid;
            place-items: center;
            padding: 28px;
            background: var(--paper);
            color: var(--ink);
            font-family: "Trebuchet MS", "Segoe UI", sans-serif;
        }

        .login-shell {
            width: min(100%, 960px);
            min-height: 570px;
            display: grid;
            grid-template-columns: 0.95fr 1.05fr;
            overflow: hidden;
            background: #fff;
            border: 1px solid var(--line);
            border-radius: 8px;
            box-shadow: 0 24px 70px rgb(32 42 37 / 10%);
            animation: arrive 420ms ease-out both;
        }

        .brand-panel {
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            overflow: hidden;
            padding: 42px;
            background-color: var(--green-dark);
            color: #f6f7ef;
        }

        .brand-panel::after {
            position: absolute;
            right: -100px;
            bottom: 72px;
            width: 390px;
            height: 250px;
            border: 1px solid rgb(213 231 125 / 25%);
            border-radius: 50%;
            box-shadow: 0 0 0 28px rgb(213 231 125 / 5%), 0 0 0 58px rgb(213 231 125 / 4%);
            content: "";
            transform: rotate(-24deg);
        }

        .brand-mark {
            position: relative;
            z-index: 1;
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 14px;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        .brand-icon {
            display: grid;
            width: 36px;
            height: 36px;
            place-items: center;
            border: 1px solid rgb(213 231 125 / 65%);
            border-radius: 6px;
            color: var(--lime);
            font-size: 18px;
        }

        .brand-copy {
            position: relative;
            z-index: 1;
            max-width: 330px;
            padding-bottom: 38px;
        }

        .eyebrow {
            margin: 0 0 14px;
            color: var(--lime);
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.14em;
            text-transform: uppercase;
        }

        .brand-copy h1 {
            max-width: 300px;
            margin: 0;
            font-family: Georgia, "Times New Roman", serif;
            font-size: 42px;
            font-weight: 400;
            line-height: 1.1;
        }

        .brand-copy p:last-child {
            max-width: 285px;
            margin: 18px 0 0;
            color: #c3d0c7;
            font-size: 14px;
            line-height: 1.7;
        }

        .form-panel {
            display: flex;
            align-items: center;
            padding: 64px clamp(32px, 7vw, 76px);
        }

        .form-content { width: 100%; max-width: 360px; margin: 0 auto; }

        .form-content h2 {
            margin: 0;
            font-family: Georgia, "Times New Roman", serif;
            font-size: 34px;
            font-weight: 400;
            line-height: 1.15;
        }

        .intro {
            margin: 10px 0 32px;
            color: var(--muted);
            font-size: 14px;
            line-height: 1.6;
        }

        .field { margin-top: 20px; }

        label {
            display: block;
            margin-bottom: 8px;
            font-size: 13px;
            font-weight: 700;
        }

        input[type="email"], input[type="password"] {
            width: 100%;
            height: 48px;
            padding: 0 14px;
            border: 1px solid #cbd5ce;
            border-radius: 5px;
            background: #fff;
            color: var(--ink);
            font: inherit;
            font-size: 14px;
            transition: border-color 140ms ease, box-shadow 140ms ease;
        }

        input:focus-visible {
            border-color: var(--green);
            outline: 3px solid rgb(29 89 72 / 15%);
            outline-offset: 1px;
        }

        .remember {
            display: flex;
            align-items: center;
            gap: 9px;
            margin: 20px 0 26px;
            color: var(--muted);
            font-size: 13px;
        }

        .remember input { width: 16px; height: 16px; accent-color: var(--green); }
        .remember label { margin: 0; font-weight: 400; cursor: pointer; }

        .submit {
            width: 100%;
            min-height: 49px;
            border: 0;
            border-radius: 5px;
            background: var(--green);
            color: #fff;
            cursor: pointer;
            font: inherit;
            font-size: 14px;
            font-weight: 700;
            transition: background 140ms ease, transform 140ms ease;
        }

        .submit:hover { background: #174a3b; }
        .submit:active { transform: translateY(1px); }
        .submit:focus-visible { outline: 3px solid rgb(29 89 72 / 28%); outline-offset: 3px; }

        .feedback {
            margin: 18px 0 0;
            padding: 11px 12px;
            border: 1px solid #e7b8b1;
            border-radius: 5px;
            background: #fff7f5;
            color: var(--error);
            font-size: 13px;
            line-height: 1.5;
        }

        .feedback.success {
            border-color: #b8d5c3;
            background: #f3faf5;
            color: #285d3a;
        }

        .footer-note {
            margin: 28px 0 0;
            color: #87918b;
            font-size: 11px;
            text-align: center;
        }

        @keyframes arrive {
            from { opacity: 0; transform: translateY(8px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @media (max-width: 680px) {
            body { padding: 14px; }
            .login-shell { min-height: 0; grid-template-columns: 1fr; }
            .brand-panel { min-height: 190px; padding: 24px; }
            .brand-copy { padding: 36px 0 0; }
            .brand-copy h1 { max-width: 250px; font-size: 32px; }
            .brand-copy p:last-child { display: none; }
            .brand-panel::after { right: -190px; bottom: -110px; }
            .form-panel { padding: 38px 24px 32px; }
            .form-content h2 { font-size: 30px; }
        }

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after { animation-duration: 0.01ms !important; transition-duration: 0.01ms !important; }
        }
    </style>
</head>
<body>
    <main class="login-shell">
        <section class="brand-panel" aria-label="Minimarket">
            <div class="brand-mark">
                <span class="brand-icon" aria-hidden="true">M</span>
                <span>Minimarket</span>
            </div>
            <div class="brand-copy">
                <p class="eyebrow">Sistem pengelolaan toko</p>
                <h1>Semua kebutuhan toko, dalam kendali.</h1>
                <p>Masuk untuk melanjutkan ke ruang kerja minimarket Anda.</p>
            </div>
        </section>

        <section class="form-panel" aria-labelledby="login-title">
            <div class="form-content">
                <h2 id="login-title">Selamat datang</h2>
                <p class="intro">Masukkan akun Anda untuk melanjutkan.</p>

                @if (session('status'))
                    <p class="feedback success" role="status">{{ session('status') }}</p>
                @endif

                @if ($errors->any())
                    <p class="feedback" role="alert">{{ $errors->first() }}</p>
                @endif

                <form method="POST" action="{{ route('login.store') }}">
                    @csrf
                    <div class="field">
                        <label for="email">Email</label>
                        <input
                            id="email"
                            name="email"
                            type="email"
                            value="{{ old('email') }}"
                            autocomplete="username"
                            placeholder="nama@contoh.com"
                            required
                            autofocus
                        >
                    </div>

                    <div class="field">
                        <label for="password">Sandi</label>
                        <input
                            id="password"
                            name="password"
                            type="password"
                            autocomplete="current-password"
                            placeholder="Masukkan sandi"
                            required
                        >
                    </div>

                    <div class="remember">
                        <input id="remember" name="remember" type="checkbox" value="1">
                        <label for="remember">Ingat saya</label>
                    </div>

                    <button class="submit" type="submit">Masuk</button>
                </form>

                <p class="footer-note">Akses hanya untuk akun yang terdaftar.</p>
            </div>
        </section>
    </main>
</body>
</html>