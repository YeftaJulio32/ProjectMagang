<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
    <link rel="stylesheet" href="{{ asset('css/footer.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
    <div class="wrapper">
        <div class="modal-container">
            <div class="modal-content">
                <div class="left-section">
                    <h1>Welcome to Nama!</h1>
                    <p>Create an account to read the latest news and also discuss in the comments column!</p>

                    <form method="POST" action="#">
                        @csrf
                        <button type="button" class="btn btn-primary">
                            <span class="google-icon">
                                <svg width="18" height="18" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48">
                                    <path fill="#EA4335" d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z"/>
                                    <path fill="#4285F4" d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z"/>
                                    <path fill="#FBBC05" d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.97-6.19z"/>
                                    <path fill="#34A853" d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.15 1.45-4.92 2.3-8.16 2.3-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z"/>
                                </svg>
                            </span>
                            Continue with Google
                        </button>
                    </form>
                </div>

                <div class="horizontal-divider">
                    <span>OR</span>
                </div>

                <div class="right-section">

                    <form method="POST">
                        {{-- action="{{ route('register') }}" DISAMPING METHOD --}}
                        @csrf
                        <div class="form-group">
                            <input type="email" name="email" placeholder="Email" required>
                        </div>

                        <div class="form-group">
                            <input type="password" name="password" placeholder="Password" required>
                        </div>

                        <button type="submit" class="btn btn-create">Create Account</button>

                        <div class="login-link">
                            Sudah punya akun? <a href="{{ route('login') }}">Log in</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @include('layouts.footer')
</body>
</html>
