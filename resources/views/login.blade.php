<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Account - BMB</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f5f5;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-container {
            display: flex;
            width: 100%;
            max-width: 1200px;
            height: 600px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
            overflow: hidden;
        }

        .login-left {
            flex: 1;
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 25%, #3b6cb5 50%, #4a7cc8 75%, #5a8fd9 100%);
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: flex-start;
            padding: 60px;
            color: white;
        }

        .login-left::before {
            content: '';
            position: absolute;
            width: 200%;
            height: 200%;
            background: repeating-linear-gradient(
                45deg,
                transparent,
                transparent 10px,
                rgba(255, 255, 255, 0.05) 10px,
                rgba(255, 255, 255, 0.05) 20px
            );
            animation: slide 20s linear infinite;
        }

        @keyframes slide {
            0% {
                transform: translate(0, 0);
            }
            100% {
                transform: translate(50px, 50px);
            }
        }

        .login-left svg {
            position: absolute;
            opacity: 0.1;
            width: 300px;
            height: 300px;
        }

        .login-left .logo {
            position: relative;
            z-index: 1;
            display: flex;
            align-items: center;
            margin-bottom: 80px;
            font-weight: bold;
            font-size: 14px;
            letter-spacing: 2px;
        }

        .login-left .logo::before {
            content: '';
            width: 30px;
            height: 30px;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            margin-right: 15px;
        }

        .login-left h1 {
            font-size: 48px;
            font-weight: 800;
            line-height: 1.2;
            margin-bottom: 20px;
            position: relative;
            z-index: 1;
        }

        .login-left .subtitle {
            font-size: 14px;
            opacity: 0.9;
            margin-bottom: 10px;
            position: relative;
            z-index: 1;
        }

        .login-left .description {
            font-size: 13px;
            opacity: 0.8;
            line-height: 1.6;
            max-width: 90%;
            position: relative;
            z-index: 1;
        }

        .login-left .divider {
            width: 50px;
            height: 4px;
            background: white;
            margin: 20px 0;
            position: relative;
            z-index: 1;
        }

        .login-right {
            flex: 1;
            padding: 60px 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .login-right h2 {
            font-size: 32px;
            color: #4a7cc8;
            margin-bottom: 15px;
            font-weight: 700;
        }

        .login-right .subtitle-text {
            font-size: 13px;
            color: #b0b0b0;
            margin-bottom: 40px;
            line-height: 1.6;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group input {
            width: 100%;
            padding: 12px 15px;
            border: none;
            border-left: 4px solid #4a7cc8;
            background: #f8f9fa;
            font-size: 14px;
            transition: all 0.3s ease;
            border-radius: 0;
        }

        .form-group input::placeholder {
            color: #d0d0d0;
        }

        .form-group input:focus {
            outline: none;
            background: #f0f0f0;
            border-left-color: #2a5298;
        }

        .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            font-size: 13px;
        }

        .form-options .remember {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #666;
        }

        .form-options .remember input[type="checkbox"] {
            width: 16px;
            height: 16px;
            cursor: pointer;
            accent-color: #4a7cc8;
        }

        .form-options .remember label {
            cursor: pointer;
            margin: 0;
        }

        .form-options a {
            color: #4a7cc8;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .form-options a:hover {
            color: #2a5298;
        }

        .submit-btn {
            width: 100%;
            padding: 14px 30px;
            background: linear-gradient(135deg, #4a7cc8, #2a5298);
            color: white;
            border: none;
            border-radius: 30px;
            font-size: 14px;
            font-weight: 600;
            letter-spacing: 1px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
        }

        .submit-btn:hover {
            background: linear-gradient(135deg, #5a8fd9, #1e3c72);
            box-shadow: 0 5px 20px rgba(42, 82, 152, 0.3);
            transform: translateY(-2px);
        }

        .alert {
            margin-bottom: 20px;
            padding: 12px 15px;
            background: #fee;
            color: #c33;
            border-left: 4px solid #c33;
            border-radius: 3px;
            font-size: 13px;
        }

        .alert ul {
            list-style: none;
            margin: 0;
        }

        .alert li {
            margin: 5px 0;
        }

        @media (max-width: 768px) {
            .login-container {
                flex-direction: column;
                height: auto;
                max-width: 100%;
            }

            .login-left {
                padding: 40px 30px;
                min-height: 300px;
            }

            .login-left h1 {
                font-size: 36px;
            }

            .login-right {
                padding: 40px 30px;
            }

            .login-right h2 {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <!-- Left Panel -->
        <div class="login-left">
            <div class="logo">BMB</div>
           
            <div class="subtitle">Nice to see you again</div>
            <h1>WELCOME BACK</h1>
            <p class="description">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. sed diam nonummy nibh. 
                Ut consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse 
                cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non 
                proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
            </p>
        </div>

        <!-- Right Panel -->
        <div class="login-right">
            <h2>Login Account</h2>
            <p class="subtitle-text">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed diam nonummy nibh. 
                Ut consequat. Duis aute irure dolor in reprehenderit.
            </p>

            @if ($errors->any())
                <div class="alert">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf
                
                <div class="form-group">
                    <input 
                        type="email" 
                        name="email" 
                        placeholder="Email ID" 
                        value="{{ old('email') }}" 
                        required 
                        autofocus
                    >
                </div>

                <div class="form-group">
                    <input 
                        type="password" 
                        name="password" 
                        placeholder="Password" 
                        required
                    >
                </div>

                <div class="form-options">
                    <label class="remember">
                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                        <span>Keep me signed in</span>
                    </label>
                    <a href="#">Already a member?</a>
                </div>

                <button type="submit" class="submit-btn">Login</button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
