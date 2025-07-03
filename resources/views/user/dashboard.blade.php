@extends('layouts.app') {{-- atau layout utama kamu --}}

@section('content')
    <div class="container py-5">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3">
                <div class="card card-bg-dark border-0">
                    <div class="card-body text-center">
                        <img src="{{ $user->avatar_url }}" class="rounded-circle mb-2" width="100" height="100"
                            alt="Avatar" style="object-fit: cover;">
                        <h5 class="fw-bold mb-1">{{ $user->name }}</h5>
                        <small class="text-muted">{{ $user->email }}</small>
                        <hr class="border-secondary">
                        <ul class="nav nav-pills flex-column" id="profile-tabs" role="tablist">
                            <li class="nav-item mb-2">
                                <a class="nav-link active" data-bs-toggle="pill" href="#profil">Profil</a>
                            </li>
                            <li class="nav-item mb-2">
                                <a class="nav-link" data-bs-toggle="pill" href="#edit">Edit Profil</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="pill" href="#password">Ubah Password</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Konten Dinamis -->
            <div class="col-md-9">
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="profil">
                        @include('user.profile.info')
                    </div>
                    <div class="tab-pane fade" id="edit">
                        @include('user.profile.edit')
                    </div>
                    <div class="tab-pane fade" id="password">
                        @include('user.profile.change')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
