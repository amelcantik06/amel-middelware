<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#123d32">
    <title>@yield('title', 'Akun') · Minimarket</title>
    <style>
        :root {
            color-scheme: light;
            --ink: #1d2d27;
            --muted: #75817a;
            --line: #e3e9e3;
            --paper: #f1f4ef;
            --green: #195b48;
            --green-dark: #123d32;
            --lime: #d5e77d;
            --error: #a3382c;
        }
        * { box-sizing: border-box; }
        body {
            min-height: 100vh;
            margin: 0;
            display: grid;
            place-items: center;
            padding: 36px 24px;
            background:
                radial-gradient(ellipse at 12% 12%, rgb(220 232 215 / 58%), transparent 32%),
                radial-gradient(ellipse at 88% 92%, rgb(224 233 221 / 56%), transparent 34%),
                var(--paper);
            color: var(--ink);
            font-family: "Segoe UI", Arial, sans-serif;
        }
        button, input { font: inherit; }
        .auth-shell {
            width: min(100%, 1080px);
            min-height: 650px;
            display: grid;
            grid-template-columns: .92fr 1.08fr;
            overflow: hidden;
            border: 1px solid rgb(222 230 222 / 90%);
            border-radius: 20px;
            background: #fff;
            box-shadow: 0 30px 90px rgb(27 53 41 / 13%), 0 5px 20px rgb(27 53 41 / 4%);
            animation: arrive 420ms ease-out both;
        }
        .brand-panel {
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            overflow: hidden;
            min-height: 650px;
            padding: 42px;
            isolation: isolate;
            background:
                radial-gradient(ellipse at 98% 79%, rgb(43 103 76 / 42%), transparent 45%),
                linear-gradient(145deg, #153e33, #10372e 78%);
            color: #f7f8f3;
        }
        .brand-panel::before, .brand-panel::after {
            position: absolute;
            z-index: -1;
            width: 400px;
            height: 260px;
            border: 1px solid rgb(213 231 125 / 20%);
            border-radius: 50%;
            content: "";
            transform: rotate(-28deg);
        }
        .brand-panel::before { right: -178px; bottom: 91px; box-shadow: 0 0 0 25px rgb(213 231 125 / 3%), 0 0 0 50px rgb(213 231 125 / 3%); }
        .brand-panel::after { right: -230px; bottom: -40px; opacity: .5; }
        .brand-mark { display: flex; align-items: center; gap: 12px; font-size: 12px; font-weight: 800; letter-spacing: .13em; text-transform: uppercase; }
        .brand-icon { width: 38px; height: 38px; display: grid; place-items: center; border: 1px solid rgb(213 231 125 / 65%); border-radius: 10px; color: var(--lime); font-family: Georgia, serif; font-size: 19px; }
        .brand-copy { position: relative; max-width: 370px; padding: 20px 0; }
        .brand-eyebrow { margin: 0 0 17px; color: var(--lime); font-size: 10px; font-weight: 800; letter-spacing: .17em; text-transform: uppercase; }
        .brand-copy h1 { max-width: 365px; margin: 0; font-family: Georgia, "Times New Roman", serif; font-size: clamp(42px, 5vw, 58px); font-weight: 400; letter-spacing: -.04em; line-height: 1.02; }
        .brand-description { max-width: 310px; margin: 22px 0 0; color: #c3d2c9; font-size: 14px; line-height: 1.8; }
        .brand-footer { display: flex; align-items: center; gap: 9px; color: #a9c1b4; font-size: 11px; }
        .status-dot { width: 7px; height: 7px; border-radius: 50%; background: var(--lime); box-shadow: 0 0 0 4px rgb(213 231 125 / 12%); }
        .form-panel { display: flex; align-items: center; justify-content: center; padding: 62px clamp(32px, 7vw, 82px); }
        .form-content { width: 100%; max-width: 390px; }
        .form-kicker { margin: 0 0 11px; color: var(--green); font-size: 10px; font-weight: 800; letter-spacing: .14em; text-transform: uppercase; }
        .form-content h2 { margin: 0; font-family: Georgia, "Times New Roman", serif; font-size: 38px; font-weight: 400; letter-spacing: -.035em; line-height: 1.12; }
        .intro { margin: 11px 0 27px; color: var(--muted); font-size: 13px; line-height: 1.65; }
        .feedback { margin: 0 0 17px; padding: 12px 14px; border: 1px solid #e7b8b1; border-radius: 9px; background: #fff7f5; color: var(--error); font-size: 12px; line-height: 1.55; }
        .feedback.success { border-color: #b8d5c3; background: #f3faf5; color: #285d3a; }
        .feedback ul { margin: 0; padding-left: 18px; }
        .field { margin-top: 17px; }
        .field-label { display: flex; justify-content: space-between; align-items: baseline; gap: 10px; margin-bottom: 7px; color: #34443c; font-size: 12px; font-weight: 700; }
        .field-label a { color: var(--green); font-size: 11px; font-weight: 700; text-decoration: none; }
        .field-label a:hover, .auth-switch a:hover { text-decoration: underline; }
        .input-wrap { position: relative; }
        .input-wrap input {
            width: 100%;
            height: 48px;
            padding: 0 14px;
            border: 1px solid #d6dfd8;
            border-radius: 9px;
            outline: 0;
            background: #fff;
            color: var(--ink);
            font-size: 13px;
            transition: border-color 150ms ease, box-shadow 150ms ease, background 150ms ease;
        }
        .input-wrap input.has-toggle { padding-right: 76px; }
        .input-wrap input::placeholder { color: #a0aaa3; }
        .input-wrap input:focus { border-color: #67917c; box-shadow: 0 0 0 4px rgb(25 91 72 / 9%); }
        .input-wrap input.is-invalid { border-color: #d9897e; background: #fffafa; }
        .input-wrap input.is-invalid:focus { box-shadow: 0 0 0 4px rgb(163 56 44 / 9%); }
        .input-error { display: block; margin-top: 6px; color: var(--error); font-size: 11px; }
        .toggle-password {
            position: absolute;
            top: 50%;
            right: 8px;
            min-width: 54px;
            padding: 7px 8px;
            transform: translateY(-50%);
            border: 0;
            border-radius: 6px;
            background: transparent;
            color: #64756b;
            cursor: pointer;
            font-size: 11px;
            font-weight: 700;
        }
        .toggle-password:hover { background: #f1f5f1; color: var(--green); }
        .remember { display: flex; align-items: center; gap: 9px; margin: 17px 0 23px; color: var(--muted); font-size: 12px; }
        .remember input { width: 15px; height: 15px; margin: 0; accent-color: var(--green); }
        .remember label { cursor: pointer; }
        .submit {
            width: 100%;
            min-height: 49px;
            border: 0;
            border-radius: 9px;
            background: linear-gradient(135deg, #20644f, #164a3b);
            box-shadow: 0 7px 16px rgb(25 91 72 / 16%);
            color: #fff;
            cursor: pointer;
            font-size: 13px;
            font-weight: 750;
            transition: box-shadow 150ms ease, transform 150ms ease, filter 150ms ease;
        }
        .submit:hover { transform: translateY(-1px); box-shadow: 0 10px 20px rgb(25 91 72 / 22%); filter: brightness(1.04); }
        .submit:active { transform: translateY(0); }
        .submit:focus-visible, .toggle-password:focus-visible { outline: 3px solid rgb(29 89 72 / 24%); outline-offset: 3px; }
        .auth-switch { margin: 21px 0 0; color: var(--muted); font-size: 12px; text-align: center; }
        .auth-switch a { color: var(--green); font-weight: 750; text-decoration: none; }
        .secure-note { display: flex; align-items: center; justify-content: center; gap: 7px; margin: 24px 0 0; color: #929d96; font-size: 10px; }
        .secure-note svg { width: 13px; height: 13px; color: #6f8979; }
        @keyframes arrive { from { opacity: 0; transform: translateY(9px); } to { opacity: 1; transform: translateY(0); } }
        @media (max-width: 760px) {
            body { padding: 18px 13px; }
            .auth-shell { width: min(100%, 520px); min-height: 0; grid-template-columns: 1fr; border-radius: 16px; }
            .brand-panel { min-height: 230px; padding: 24px; }
            .brand-copy { padding: 30px 0 4px; }
            .brand-copy h1 { max-width: 360px; font-size: 34px; }
            .brand-eyebrow { margin-bottom: 9px; }
            .brand-description, .brand-footer { display: none; }
            .brand-panel::before { right: -210px; bottom: -70px; }
            .brand-panel::after { display: none; }
            .form-panel { padding: 34px 24px 30px; }
            .form-content h2 { font-size: 32px; }
        }
        @media (prefers-reduced-motion: reduce) { *, *::before, *::after { animation-duration: .01ms !important; transition-duration: .01ms !important; } }
    </style>
    @stack('styles')
</head>
<body>
    <main class="auth-shell">
        <section class="brand-panel" aria-label="Minimarket">
            <div class="brand-mark">
                <span class="brand-icon" aria-hidden="true">M</span>
                <span>Minimarket</span>
            </div>
            <div class="brand-copy">
                <p class="brand-eyebrow">Sistem pengelolaan toko</p>
                <h1>@yield('brand-title', 'Semua kebutuhan toko, dalam kendali.')</h1>
                <p class="brand-description">@yield('brand-description', 'Ruang kerja yang rapi untuk membantu operasional minimarket Anda berjalan lebih mudah setiap hari.')</p>
            </div>
            <div class="brand-footer"><span class="status-dot" aria-hidden="true"></span> Satu ruang kerja untuk operasional toko Anda</div>
        </section>
        <section class="form-panel" aria-labelledby="auth-title">
            <div class="form-content">
                @yield('content')
            </div>
        </section>
    </main>
    @stack('scripts')
</body>
</html>
