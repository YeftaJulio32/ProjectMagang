<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Winnews</title>
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
            <h2 class="mb-4 text-center">Sign up</h2>

            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Full Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                        name="name" placeholder="Your full name" value="{{ old('name') }}" required>
                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
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
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password"
                            name="password" placeholder="********" required>
                        <span class="input-group-text" style="cursor:pointer" onclick="togglePassword('password', this)">
                            <i class="fa fa-eye"></i>
                        </span>
                    </div>
                    @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="password_confirmation"
                            name="password_confirmation" placeholder="********" required>
                        <span class="input-group-text" style="cursor:pointer"
                            onclick="togglePassword('password_confirmation', this)">
                            <i class="fa fa-eye"></i>
                        </span>
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ url('/') }}" class="btn btn-outline-secondary w-100">Cancel</a>
                    <button type="submit" class="btn btn-primary w-100">Sign Up</button>
                </div>
            </form>

            <p class="text-center mt-3">
                Sudah punya akun? <a href="{{ route('login') }}">Login</a>
            </p>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const password = document.getElementById('password');
            const confirmPassword = document.getElementById('password_confirmation');
            const submitButton = document.querySelector('button[type="submit"]');

            function validatePasswords() {
                if (password.value && confirmPassword.value) {
                    if (password.value !== confirmPassword.value) {
                        confirmPassword.classList.add('is-invalid');
                        confirmPassword.classList.remove('is-valid');

                        // Tambahkan feedback jika tidak cocok
                        const feedback = confirmPassword.parentNode.querySelector('.invalid-feedback');
                        if (!feedback) {
                            const feedbackDiv = document.createElement('div');
                            feedbackDiv.className = 'invalid-feedback';
                            feedbackDiv.textContent = 'Passwords do not match';
                            confirmPassword.parentNode.appendChild(feedbackDiv);
                        }

                        submitButton.disabled = true;
                    } else {
                        confirmPassword.classList.remove('is-invalid');
                        confirmPassword.classList.add('is-valid');

                        // Hapus feedback jika cocok
                        const feedback = confirmPassword.parentNode.querySelector('.invalid-feedback');
                        if (feedback) {
                            feedback.remove();
                        }

                        submitButton.disabled = false;
                    }
                } else {
                    confirmPassword.classList.remove('is-invalid', 'is-valid');

                    // Hapus feedback jika kosong
                    const feedback = confirmPassword.parentNode.querySelector('.invalid-feedback');
                    if (feedback) {
                        feedback.remove();
                    }

                    submitButton.disabled = false;
                }
            }

            password.addEventListener('input', validatePasswords);
            confirmPassword.addEventListener('input', validatePasswords);
        });

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
