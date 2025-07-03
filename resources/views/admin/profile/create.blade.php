@extends('layouts.app')
@section('title', 'Tambah Profile User')

@section('content')
    <div class="bg-body min-vh-100 py-4">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
                <h1 class="fw-bold text-body">Tambah Profile User</h1>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary text-secondary-emphasis">Kembali</a>
            </div>

            <div class="card bg-body text-body border">
                <div class="card-body">
                    <form action="{{ route('admin.store-user') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        {{-- Nama --}}
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama</label>
                            <input type="text"
                                class="form-control bg-body text-body border @error('name') is-invalid @enderror"
                                id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email"
                                class="form-control bg-body text-body border @error('email') is-invalid @enderror"
                                id="email" name="email" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Password --}}
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password"
                                class="form-control bg-body text-body border @error('password') is-invalid @enderror"
                                id="password" name="password" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Konfirmasi Password --}}
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                            <input type="password"
                                class="form-control bg-body text-body border @error('password_confirmation') is-invalid @enderror"
                                id="password_confirmation" name="password_confirmation" required>
                            @error('password_confirmation')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Avatar --}}
                        <div class="mb-3">
                            <label for="avatar" class="form-label">Avatar (opsional)</label>
                            <input type="file"
                                class="form-control bg-body text-body border @error('avatar') is-invalid @enderror"
                                id="avatar" name="avatar" accept="image/*">
                            @error('avatar')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Peran --}}
                        <div class="mb-3">
                            <label for="role" class="form-label">Peran</label>
                            <select
                                class="form-select bg-body text-body border @error('role') is-invalid @enderror"
                                id="role" name="role" required>
                                <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>Pengguna</option>
                                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                            </select>
                            @error('role')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary fw-semibold">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
