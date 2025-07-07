@extends('layouts.app')
@section('content')
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-warning text-dark">
                        <h5 class="mb-0"><i class="fas fa-user-edit"></i> Edit Profil</h5>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('admin.profile.update', $admin->id) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="name" class="form-label"><i class="fas fa-user"></i> Nama Lengkap</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name" value="{{ old('name', $admin->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label"><i class="fas fa-envelope"></i> Email</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    value="{{ $admin->email }}" readonly disabled>
                                <small class="form-text text-muted">Email tidak dapat diubah</small>
                            </div>
                            <div class="mb-3">
                                <label for="avatar" class="form-label"><i class="fas fa-image"></i> Foto Profil</label>
                                @php
                                    $hasRealAvatar =
                                        $admin->avatar_url &&
                                        $admin->avatar_url !== '/storage/avatars/default-avatar.png' &&
                                        strpos($admin->avatar_url, '/storage/avatars/') === 0;
                                @endphp
                                @if ($hasRealAvatar)
                                    <div class="mb-3">
                                        <img src="{{ $admin->avatar_url }}" alt="Avatar saat ini" class="img-thumbnail"
                                            style="width: 100px; height: 100px; object-fit: cover;" id="current-avatar">
                                        <small class="d-block text-muted">Avatar saat ini</small>
                                        <div class="mt-2">
                                            <button type="button" class="btn btn-sm btn-outline-danger"
                                                onclick="removeAvatar()">
                                                <i class="fas fa-trash"></i> Hapus Avatar
                                            </button>
                                        </div>
                                    </div>
                                @endif
                                <input type="file" class="form-control @error('avatar') is-invalid @enderror"
                                    name="avatar" accept="image/*" id="avatar-input">
                                <input type="hidden" name="remove_avatar" id="remove-avatar" value="0">
                                @error('avatar')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Format: JPG, PNG, GIF. Maksimal 2MB</small>

                                <!-- Preview untuk avatar baru -->
                                <div id="avatar-preview" class="mt-3" style="display: none;">
                                    <img id="preview-img" class="img-thumbnail"
                                        style="width: 100px; height: 100px; object-fit: cover;">
                                    <small class="d-block text-muted">Preview avatar baru</small>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label"><i class="fas fa-lock"></i> Password Baru</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    id="password" name="password"
                                    placeholder="Kosongkan jika tidak ingin mengubah password">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Minimal 8 karakter</small>
                            </div>

                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label"><i class="fas fa-lock"></i> Konfirmasi
                                    Password Baru</label>
                                <input type="password"
                                    class="form-control @error('password_confirmation') is-invalid @enderror"
                                    id="password_confirmation" name="password_confirmation"
                                    placeholder="Konfirmasi password baru">
                                @error('password_confirmation')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('admin.profile.show', $admin->id) }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Kembali
                                </a>
                                <button type="submit" class="btn btn-warning">
                                    <i class="fas fa-save"></i> Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('avatar-input').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('preview-img').src = e.target.result;
                    document.getElementById('avatar-preview').style.display = 'block';
                };
                reader.readAsDataURL(file);
                // Reset remove avatar flag when new file is selected
                document.getElementById('remove-avatar').value = '0';
            } else {
                document.getElementById('avatar-preview').style.display = 'none';
            }
        });

        function removeAvatar() {
            if (confirm('Apakah Anda yakin ingin menghapus avatar?')) {
                document.getElementById('remove-avatar').value = '1';
                document.getElementById('avatar-input').value = '';
                document.getElementById('avatar-preview').style.display = 'none';

                // Hide current avatar and show message
                const currentAvatarContainer = document.getElementById('current-avatar').parentElement;
                currentAvatarContainer.innerHTML =
                    '<small class="text-muted">Avatar akan dihapus setelah menyimpan perubahan</small>';
            }
        }
    </script>
@endsection
