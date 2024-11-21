<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}"> <!-- Đường dẫn tới CSS của Laravel -->
    <style>
        body {
            background: url('https://www.vietnamworks.com/hrinsider/wp-content/uploads/2023/12/ai-la-nguoi-dam-me-nhung-bau-troi-dem-day-sao-dep-den-nao-long-nao.jpg') no-repeat center center fixed; 
            background-size: cover;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .login-container {
            width: 400px;
            padding: 40px;
            background: rgba(255, 255, 255, 0.8); /* Nền trắng bán trong suốt */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            text-align: center;
        }
        .login-header {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
            color: #333;
        }
        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }
        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
            color: #555;
        }
        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .form-check-label {
            margin-left: 5px;
            color: #555;
        }
        .btn-login {
            width: 100%;
            padding: 10px;
            background-color: #333;
            border: none;
            border-radius: 4px;
            color: white;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease;
            /* transition: color 0.3s ease; */
        }
        .btn-login:hover {
            background-color: grey;
            text-shadow: 0 0 8px grey;
        }
        .forgot-password, .register-link {
            display: block;
            margin-top: 10px;
            font-size: 14px;
            color: #007bff;
            text-decoration: none;
        }
        .forgot-password:hover, .register-link:hover {
            text-decoration: underline;
        }
        .invalid-feedback {
            color: #dc3545;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-header">{{ __('Đăng Nhập') }}</div>
        <form method="POST" action="{{ route('user.login') }}">
            @csrf

            <div class="form-group">
                <label for="email">{{ __('Email') }}</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">{{ __('Mật Khẩu') }}</label>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <!-- <div class="form-group">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label class="form-check-label" for="remember">
                        {{ __('Remember Me') }}
                    </label>
                </div>
            </div> -->

            <button type="submit" class="btn-login">
                {{ __('Đăng Nhập') }}
            </button>
            @if (Route::has('password.request'))
                <a class="forgot-password" href="{{ route('password.request') }}">
                    {{ __('Quên mật khẩu?') }}
                </a>
            @endif

            <a class="register-link" href="{{ route('user.register') }}">
                {{ __('Bạn chưa có tài khoản? Đăng ký ngay') }}
            </a>
        </form>
    </div>
</body>
</html>
