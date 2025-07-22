<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password - Winnews</title>
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
            <h2 class="mb-4 text-center">Lupa Password</h2>

            <p class="text-center text-muted mb-4">
                Masukkan alamat email Anda dan kami akan mengirimkan link untuk mereset password Anda.
            </p>

            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="mb-3">
                    <label for="email" class="form-label">Alamat Email</label>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                        name="email" value="{{ old('email') }}" required autofocus placeholder="name@gmail.com">
                    @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="d-flex gap-2">
                    <a href="{{ url('login') }}" class="btn btn-outline-secondary w-100">Back</a>
                    <button type="submit" class="btn btn-primary w-100">Send Reset Link</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
