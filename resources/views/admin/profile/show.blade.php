@extends('layouts.app')
@section('title', 'Profil Pengguna')

@section('content')
    <div class="bg-body min-vh-100 py-4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card bg-body text-body border">
                        <div class="card-header bg-info text-white">
                            <h5 class="mb-0"><i class="fas fa-user"></i> Profil Pengguna</h5>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3 align-items-center">
                                <div class="col-md-4 text-center">
                                    @if ($admin->avatar_url)
                                        <img src="{{ $admin->avatar_url }}" alt="avatar"
                                            class="rounded-circle mb-2 border object-fit-cover" width="120"
                                            height="120">
                                    @else
                                        <img src="{{ asset('/storage/avatars/default-avatar.png') }}" alt="avatar"
                                            class="rounded-circle mb-2 border object-fit-cover" width="120"
                                            height="120">
                                    @endif
                                </div>
                                <div class="col-md-8">
                                    <h4 class="fw-bold text-body">{{ $admin->name }}</h4>
                                    <p class="mb-1"><strong>Email:</strong> <span
                                            class="text-body">{{ $admin->email }}</span></p>
                                    <p class="mb-1"><strong>Role:</strong>
                                        <span class="badge {{ $admin->role === 'admin' ? 'bg-primary' : 'bg-secondary' }}">
                                            {{ ucfirst($admin->role) }}
                                        </span>
                                    </p>
                                    <p class="mb-1"><strong>Tanggal Bergabung:</strong>
                                        <span class="text-body">
                                            {{ $admin->joined_at ? \Carbon\Carbon::parse($admin->joined_at)->translatedFormat('d F Y, H:i') : '-' }}
                                        </span>
                                    </p>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end gap-2 mt-4 flex-wrap">
                                @if(auth()->check() && auth()->id() === $admin->id && $admin->role === 'admin')
                                    <a href="{{ route('admin.profile.edit', $admin->id) }}" class="btn btn-warning">
                                        <i class="fas fa-user-edit"></i> Edit Profil
                                    </a>
                                    <a href="{{ route('admin.komentar.index') }}" class="btn btn-info text-white">
                                        <i class="fas fa-comments"></i> Manajemen Komentar
                                    </a>
                                    <a href="{{ route('admin.profile.create') }}" class="btn btn-success">
                                        <i class="fas fa-plus"></i> Tambah Pengguna
                                    </a>
                                @endif
                                <a href="{{ route('admin.dashboard') }}"
                                    class="btn btn-outline-secondary text-secondary-emphasis">
                                    <i class="fas fa-arrow-left"></i> Kembali
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
