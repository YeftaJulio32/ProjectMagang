@extends('layouts.app')

@section('title', 'Profil Pengguna')

@section('content')
    <div class="container py-5">
        {{-- Notifikasi Berhasil --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row justify-content-center">
            <!-- Sidebar -->
            <div class="col-md-4 col-lg-3 mb-4 mb-md-0">
                <div class="card bg-body text-body shadow border">
                    <div class="card-body text-center">
                        <img src="{{ $user->avatar_url ?? asset('/storage/avatars/default-avatar.png') }}"
                            class="rounded-circle mb-3 border object-fit-cover" width="100" height="100" alt="Avatar">
                        <h5 class="fw-bold mb-1">{{ $user->name }}</h5>
                        <small class="text-muted">{{ $user->email }}</small>
                        <hr class="border-secondary my-3">
                        <ul class="nav nav-pills flex-column gap-2" id="profile-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="pill" href="#profil" role="tab">
                                    <i class="fas fa-user me-1"></i> Profil
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="pill" href="#edit" role="tab">
                                    <i class="fas fa-user-edit me-1"></i> Edit Profil
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="pill" href="#password" role="tab">
                                    <i class="fas fa-key me-1"></i> Ubah Password
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Konten Dinamis -->
            <div class="col-md-8 col-lg-9">
                <div class="card bg-body text-body shadow border">
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="profil" role="tabpanel">
                                @include('user.profile.info')
                            </div>
                            <div class="tab-pane fade" id="edit" role="tabpanel">
                                @include('user.profile.edit')
                            </div>
                            <div class="tab-pane fade" id="password" role="tabpanel">
                                @include('user.profile.change')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
