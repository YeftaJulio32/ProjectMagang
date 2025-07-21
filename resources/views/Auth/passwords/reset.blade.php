<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - Winnews</title>
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
            <h2 class="mb-4 text-center">Reset Password</h2>

            @if (session('status'))
                <div class="alert alert-success">{{ session('status') }}</div>
            @endif

            <form method="POST" action="{{ route('password.update') }}">
                @csrf

                <input type="hidden" name="token" value="{{ $token }}">

                {{-- <div class="mb-3">
                    <label for="email" class="form-label">Alamat Email</label>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                        name="email" value="{{ request()->email }}" required readonly>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div> --}}

                <div class="mb-3">
                    <label for="password" class="form-label">Password Baru</label>
                    <div class="input-group">
                        <input id="password" type="password"
                            class="form-control @error('password') is-invalid @enderror" name="password" required
                            autofocus>
                        <span class="input-group-text" style="cursor:pointer"
                            onclick="togglePassword('password', this)">
                            <i class="fa fa-eye"></i>
                        </span>
                    </div>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password-confirm" class="form-label">Konfirmasi Password Baru</label>
                    <div class="input-group">
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation"
                            required>
                        <span class="input-group-text" style="cursor:pointer"
                            onclick="togglePassword('password-confirm', this)">
                            <i class="fa fa-eye"></i>
                        </span>
                    </div>
                    <div id="password-match-message" class="text-danger mt-1" style="display: none;">
                        Passwords do not match.
                    </div>
                </div>

                <button type="submit" class="btn btn-dark w-100">Reset Password</button>
            </form>
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
        const password = document.getElementById('password');
        const passwordConfirm = document.getElementById('password-confirm');
        const passwordMatchMessage = document.getElementById('password-match-message');

        passwordConfirm.addEventListener('input', () => {
            if (password.value !== passwordConfirm.value) {
                passwordMatchMessage.style.display = 'block';
            } else {
                passwordMatchMessage.style.display = 'none';
            }
        });
    </script>
</body>

</html>
