<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="{{ asset('css/loginstyle.css') }}">
    <link rel="stylesheet" href="{{ asset('css/footer.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
    <div class="wrapper">
        <div class="modal-container">
            <div class="modal-header">
                <h2 class="modal-title">Welcome to Winnews!</h2>
            </div>

            <div class="modal-body">
                <p>Log in to your account to read the latest news and also discuss in the comments column!</p>

                {{-- action="{{ route('login') }}"DISAMPING  METHOD--}}
                <form method="POST">
                    @csrf

                    <div class="form-group">
                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                            name="email" value="{{ old('email') }}" placeholder="Email" required autofocus>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                            name="password" placeholder="Password" required>
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <button type="submit" class="login-button">Log In</button>

                    <div class="remember-me">
                        <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label for="remember">Remember me for 30 days</label>
                    </div>

                    <div class="forgot-password">
                        <a href="">Forgot Password?</a>
                        {{-- "{{ route('password.request') }}" DIDALAM HREF--}}
                    </div>

                    <div class="register-link">
                        Belum punya akun? <a href="{{ route('register') }}">Register</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @include('layouts.footer')
</body>
</html>
