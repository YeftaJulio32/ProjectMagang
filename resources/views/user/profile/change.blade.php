<div class="card card-bg-dark border-0">
    <div class="card-body">
        <h5 class="fw-bold mb-4">Ubah Password</h5>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <form method="POST" action="{{ route('profile.password') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label">Password Saat Ini</label>
                <input type="password" name="current_password"
                    class="form-control @error('current_password') is-invalid @enderror">
                @error('current_password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Password Baru</label>
                <input type="password" name="new_password"
                    class="form-control @error('new_password') is-invalid @enderror" id="new_password">
                @error('new_password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="form-text text-muted">Minimal 8 karakter</small>
            </div>
            <div class="mb-3">
                <label class="form-label">Konfirmasi Password Baru</label>
                <input type="password" name="new_password_confirmation"
                    class="form-control @error('new_password_confirmation') is-invalid @enderror"
                    id="new_password_confirmation">
                @error('new_password_confirmation')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="text-end">
                <button type="submit" class="btn btn-warning">
                    <i class="fas fa-key"></i> Simpan Password
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const newPassword = document.getElementById('new_password');
        const confirmPassword = document.getElementById('new_password_confirmation');
        const submitButton = document.querySelector('button[type="submit"]');

        function validatePasswords() {
            if (newPassword.value && confirmPassword.value) {
                if (newPassword.value !== confirmPassword.value) {
                    confirmPassword.classList.add('is-invalid');
                    confirmPassword.classList.remove('is-valid');

                    // Hapus feedback lama jika ada
                    const existingFeedback = confirmPassword.parentNode.querySelector(
                        '.password-mismatch-feedback');
                    if (existingFeedback) {
                        existingFeedback.remove();
                    }

                    // Tambahkan feedback baru
                    const feedback = document.createElement('div');
                    feedback.className = 'invalid-feedback password-mismatch-feedback';
                    feedback.textContent = 'Password dan konfirmasi password tidak sama';
                    confirmPassword.parentNode.appendChild(feedback);

                    submitButton.disabled = true;
                } else {
                    confirmPassword.classList.remove('is-invalid');
                    confirmPassword.classList.add('is-valid');

                    // Hapus feedback mismatch
                    const existingFeedback = confirmPassword.parentNode.querySelector(
                        '.password-mismatch-feedback');
                    if (existingFeedback) {
                        existingFeedback.remove();
                    }

                    submitButton.disabled = false;
                }
            } else {
                confirmPassword.classList.remove('is-invalid', 'is-valid');

                // Hapus feedback mismatch
                const existingFeedback = confirmPassword.parentNode.querySelector(
                '.password-mismatch-feedback');
                if (existingFeedback) {
                    existingFeedback.remove();
                }

                submitButton.disabled = false;
            }
        }

        newPassword.addEventListener('input', validatePasswords);
        confirmPassword.addEventListener('input', validatePasswords);
    });
</script>
