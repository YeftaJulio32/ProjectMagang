<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Winnews</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/footer.css') }}">
</head>

<body style="background-color: #363535;">
    <div class="login-page d-flex align-items-center justify-content-center" style="min-height: 100vh;">

        <div class="card shadow p-4"
            style="max-width: 400px; width: 100%; border-radius: 16px; background-color: #ffffff">
            <h2 class="mb-4 text-center">Sign in</h2>

            {{-- Flash message success dari reset password --}}
            @if (session('status'))
                <div class="alert alert-success text-sm">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login.post') }}">
                @csrf

                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                        name="email" placeholder="name@gmail.com" value="{{ old('email') }}" required>
                    @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="password" name="password"
                            placeholder="********" required>
                        <span class="input-group-text" style="cursor:pointer" onclick="togglePassword('password', this)">
                            <i class="fa fa-eye"></i>
                        </span>
                    </div>
                </div>

                {{-- 🔗 Tombol Lupa Password --}}
                <div class="mb-3 text-end">
                    <a href="{{ route('password.request') }}" class="text-decoration-none text-sm">
                        Lupa password?
                    </a>
                </div>

                <div class="d-flex gap-2">
                    <a href="{{ url('/') }}" class="btn btn-outline-secondary w-100">Cancel</a>
                    <button type="submit" class="btn btn-primary w-100">Sign In</button>
                </div>
            </form>

            <p class="text-center mt-3">
                Belum punya akun? <a href="{{ route('register') }}">Register</a>
            </p>
        </div>
    </div>

    <script>
        function togglePassword(inputId, el) {
            const input = document.getElementById(inputId);
            const icon = el.querySelector('i');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>
</body>

</html>
