<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Owner Login - BMB</title>
    <link rel="icon" href="{{ asset('images/bmb.png') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --bg: #f5ede4;
            --navy: #2c3e50;
            --navy-deep: #1a252f;
            --accent: #d4956b;
            --accent-deep: #b56238;
            --text: #1f2933;
            --muted: #6b7280;
            --line: #e5ded6;
            --field: #faf8f6;
            --danger: #b42318;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background:
                radial-gradient(circle at 15% 20%, rgba(212, 149, 107, 0.18), transparent 45%),
                radial-gradient(circle at 85% 85%, rgba(44, 62, 80, 0.10), transparent 40%),
                var(--bg);
            color: var(--text);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 32px 16px;
            -webkit-font-smoothing: antialiased;
        }

        .shell {
            width: 100%;
            max-width: 1040px;
            min-height: 620px;
            display: grid;
            grid-template-columns: 1.05fr 1fr;
            background: white;
            border-radius: 24px;
            overflow: hidden;
            box-shadow:
                0 1px 2px rgba(16, 24, 40, 0.04),
                0 24px 60px -12px rgba(44, 62, 80, 0.22);
        }

        /* Left: photo panel */
        .visual {
            position: relative;
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            color: white;
            background: var(--navy) url("{{ asset('images/banner.png') }}") center / cover no-repeat;
            isolation: isolate;
        }

        .visual::before {
            content: '';
            position: absolute;
            inset: 0;
            z-index: -1;
            background:
                linear-gradient(180deg, rgba(26, 37, 47, 0.55) 0%, rgba(26, 37, 47, 0.35) 40%, rgba(26, 37, 47, 0.92) 100%),
                linear-gradient(135deg, rgba(212, 149, 107, 0.25), transparent 60%);
        }

        .brand {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            color: white;
            text-decoration: none;
            align-self: flex-start;
            padding: 6px 16px 6px 6px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.18);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            transition: background 0.2s;
        }

        .brand:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        .brand img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: white;
            object-fit: contain;
            padding: 3px;
        }

        .brand span {
            font-weight: 700;
            font-size: 14px;
            letter-spacing: 0.3px;
        }

        .visual-copy .tag {
            display: inline-block;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: #f3c9ab;
            margin-bottom: 14px;
        }

        .visual-copy h1 {
            font-size: 40px;
            line-height: 1.1;
            font-weight: 800;
            letter-spacing: -1px;
            margin-bottom: 14px;
        }

        .visual-copy p {
            font-size: 15px;
            line-height: 1.6;
            color: rgba(255, 255, 255, 0.8);
            max-width: 360px;
        }

        .visual-copy ul {
            list-style: none;
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 22px;
        }

        .visual-copy li {
            font-size: 12px;
            font-weight: 600;
            padding: 6px 12px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.16);
        }

        .visual-copy li i {
            color: #f3c9ab;
            margin-right: 6px;
        }

        /* Right: form panel */
        .panel {
            padding: 48px 56px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            align-self: flex-start;
            color: var(--muted);
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            padding: 6px 12px 6px 8px;
            margin: 0 0 36px -8px;
            border-radius: 8px;
            transition: color 0.2s, background 0.2s;
        }

        .back-link:hover {
            color: var(--navy);
            background: #f3eee9;
        }

        .panel h2 {
            font-size: 30px;
            font-weight: 800;
            letter-spacing: -0.6px;
            color: var(--navy);
            margin-bottom: 8px;
        }

        .panel .lead {
            color: var(--muted);
            font-size: 15px;
            margin-bottom: 32px;
        }

        .alert {
            display: flex;
            gap: 10px;
            align-items: flex-start;
            padding: 12px 14px;
            margin-bottom: 22px;
            border-radius: 12px;
            background: #fef3f2;
            border: 1px solid #fecdca;
            color: var(--danger);
            font-size: 14px;
            line-height: 1.5;
        }

        .alert i {
            margin-top: 3px;
        }

        .field {
            margin-bottom: 18px;
        }

        .field label {
            display: block;
            font-size: 13px;
            font-weight: 700;
            color: var(--text);
            margin-bottom: 8px;
        }

        .input-wrap {
            position: relative;
        }

        .input-wrap > i {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #9aa1ab;
            font-size: 15px;
            pointer-events: none;
            transition: color 0.2s;
        }

        .input-wrap input {
            width: 100%;
            height: 52px;
            padding: 0 48px 0 46px;
            border: 1.5px solid var(--line);
            border-radius: 12px;
            background: var(--field);
            font: inherit;
            font-size: 15px;
            color: var(--text);
            transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
        }

        .input-wrap input::placeholder {
            color: #a8aeb6;
        }

        .input-wrap input:hover {
            border-color: #d6ccc1;
        }

        .input-wrap input:focus {
            outline: none;
            background: white;
            border-color: var(--accent);
            box-shadow: 0 0 0 4px rgba(212, 149, 107, 0.18);
        }

        .input-wrap:focus-within > i {
            color: var(--accent-deep);
        }

        .field.invalid input {
            border-color: #f04438;
            background: #fffbfa;
        }

        .toggle-pass {
            position: absolute;
            right: 6px;
            top: 50%;
            transform: translateY(-50%);
            width: 40px;
            height: 40px;
            border: 0;
            border-radius: 10px;
            background: transparent;
            color: #9aa1ab;
            cursor: pointer;
            font-size: 15px;
            transition: color 0.2s, background 0.2s;
        }

        .toggle-pass:hover {
            color: var(--navy);
            background: #f1ece7;
        }

        .row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin: 6px 0 28px;
        }

        .check {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            font-size: 14px;
            color: var(--muted);
            cursor: pointer;
            user-select: none;
        }

        .check input {
            width: 18px;
            height: 18px;
            accent-color: var(--navy);
            cursor: pointer;
        }

        .submit {
            width: 100%;
            height: 52px;
            border: 0;
            border-radius: 12px;
            background: var(--navy);
            color: white;
            font: inherit;
            font-size: 15px;
            font-weight: 700;
            letter-spacing: 0.3px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            box-shadow: 0 8px 20px -8px rgba(44, 62, 80, 0.6);
            transition: background 0.2s, transform 0.2s, box-shadow 0.2s;
        }

        .submit:hover {
            background: var(--navy-deep);
            transform: translateY(-1px);
            box-shadow: 0 12px 24px -8px rgba(44, 62, 80, 0.55);
        }

        .submit:active {
            transform: translateY(0);
        }

        .submit:focus-visible {
            outline: none;
            box-shadow: 0 0 0 4px rgba(212, 149, 107, 0.35);
        }

        .submit[disabled] {
            opacity: 0.75;
            cursor: progress;
            transform: none;
        }

        .submit i {
            transition: transform 0.2s;
        }

        .submit:hover i {
            transform: translateX(3px);
        }

        .foot-note {
            margin-top: 28px;
            padding-top: 20px;
            border-top: 1px solid #f0ebe5;
            font-size: 13px;
            color: var(--muted);
            line-height: 1.6;
        }

        .foot-note a {
            color: var(--accent-deep);
            font-weight: 600;
            text-decoration: none;
        }

        .foot-note a:hover {
            text-decoration: underline;
        }

        @media (max-width: 860px) {
            body {
                padding: 0;
                align-items: stretch;
            }

            .shell {
                grid-template-columns: 1fr;
                border-radius: 0;
                min-height: 100vh;
                box-shadow: none;
            }

            .visual {
                padding: 20px 20px 24px;
                min-height: 220px;
                gap: 28px;
            }

            .visual-copy h1 {
                font-size: 28px;
            }

            .visual-copy p,
            .visual-copy ul {
                display: none;
            }

            .panel {
                padding: 28px 20px 40px;
                justify-content: flex-start;
            }

            .back-link {
                margin-bottom: 20px;
            }

            .panel h2 {
                font-size: 26px;
            }
        }
    </style>
</head>
<body>
    <main class="shell">
        <section class="visual" aria-hidden="false">
            <a href="{{ route('home') }}" class="brand">
                <img src="{{ asset('images/bmb.png') }}" alt="">
                <span>Blessing Multi Business</span>
            </a>

            <div class="visual-copy">
                <span class="tag">Owner area</span>
                <h1>Welcome back</h1>
                <p>Manage your shop and rentals in one place.</p>
                <ul>
                    <li><i class="fas fa-camera"></i>Photos</li>
                    <li><i class="fas fa-tag"></i>Prices</li>
                    <li><i class="fas fa-calendar-check"></i>Availability</li>
                </ul>
            </div>
        </section>

        <section class="panel">
            <a href="{{ route('home') }}" class="back-link"><i class="fas fa-arrow-left"></i> Back to home</a>

            <h2>Sign in</h2>
            <p class="lead">Sign in to update items, prices and photos.</p>

            @if ($errors->any())
                <div class="alert" role="alert">
                    <i class="fas fa-circle-exclamation"></i>
                    <div>
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" id="login-form" novalidate>
                @csrf

                <div @class(['field', 'invalid' => $errors->has('email')])>
                    <label for="email">Email</label>
                    <div class="input-wrap">
                        <i class="fas fa-envelope"></i>
                        <input type="email" id="email" name="email" value="{{ old('email') }}"
                               placeholder="you@example.com" autocomplete="username" required autofocus>
                    </div>
                </div>

                <div @class(['field', 'invalid' => $errors->has('email')])>
                    <label for="password">Password</label>
                    <div class="input-wrap">
                        <i class="fas fa-lock"></i>
                        <input type="password" id="password" name="password"
                               placeholder="Enter your password" autocomplete="current-password" required>
                        <button type="button" class="toggle-pass" id="toggle-pass" aria-label="Show password">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <div class="row">
                    <label class="check">
                        <input type="checkbox" name="remember" value="1" @checked(old('remember'))>
                        Keep me signed in
                    </label>
                </div>

                <button type="submit" class="submit" id="submit">
                    <span>Sign in</span> <i class="fas fa-arrow-right"></i>
                </button>
            </form>

            <p class="foot-note">
                Looking to buy or rent? You don't need an account.
                <a href="{{ route('shop') }}">Browse the shop</a> or
                <a href="{{ route('contact') }}">contact us</a>.
            </p>
        </section>
    </main>

    <script>
        (function () {
            const pass = document.getElementById('password');
            const toggle = document.getElementById('toggle-pass');
            toggle.addEventListener('click', function () {
                const show = pass.type === 'password';
                pass.type = show ? 'text' : 'password';
                toggle.setAttribute('aria-label', show ? 'Hide password' : 'Show password');
                toggle.firstElementChild.className = show ? 'fas fa-eye-slash' : 'fas fa-eye';
                pass.focus();
            });

            const form = document.getElementById('login-form');
            const submit = document.getElementById('submit');
            form.addEventListener('submit', function (e) {
                if (!form.checkValidity()) {
                    e.preventDefault();
                    form.reportValidity();
                    return;
                }
                submit.disabled = true;
                submit.innerHTML = '<i class="fas fa-circle-notch fa-spin"></i> <span>Signing in…</span>';
            });
        })();
    </script>
</body>
</html>
