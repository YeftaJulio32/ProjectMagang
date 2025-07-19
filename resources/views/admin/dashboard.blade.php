@extends('layouts.app')
@section('title', 'Manajemen Pengguna')

@section('content')
    <div class="bg-body min-vh-100 py-4">
        <div class="container">
            {{-- Header & Toolbar --}}
            <div class="row align-items-center mb-4 gy-2">
                <div class="col-lg-6 col-sm-12">
                    <h1 class="fw-bold text-body">Manajemen Pengguna</h1>
                </div>
                <div class="col-lg-6 col-sm-12 d-flex justify-content-lg-end flex-wrap gap-2">
                    {{-- Search --}}
                    <form class="d-flex flex-grow-1 flex-md-grow-0" method="GET" action="{{ route('admin.dashboard') }}">
                        <div class="input-group">
                            <span class="input-group-text bg-body border-secondary text-body">
                                <i class="fas fa-search"></i>
                            </span>
                            <input type="text" name="search" class="form-control bg-body text-body border-secondary"
                                placeholder="Cari pengguna..." value="{{ request('search') }}">
                        </div>
                    </form>
                </div>
            </div>

            {{-- Table Card --}}
            <div class="card bg-body text-body border-0">
                <div class="card-body px-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0 text-body">
                            <thead>
                                <tr >
                                    <th class="fw-semibold">Pengguna</th>
                                    <th class="fw-semibold">Tanggal Bergabung</th>
                                    <th class="fw-semibold">Peran</th>
                                    <th class="fw-semibold">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center gap-3">
                                                @if ($user->avatar_url)
                                                    <img src="{{ $user->avatar_url }}"
                                                        alt="avatar" class="rounded-circle object-fit-cover" width="44"
                                                        height="44">
                                                @else
                                                    <div class="avatar-circle">
                                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                                    </div>
                                                @endif
                                                <div>
                                                    <div class="fw-bold text-body">{{ $user->name }}</div>
                                                    <div class="text-muted small">{{ $user->email }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="small">
                                            {{ $user->joined_at ? \Carbon\Carbon::parse($user->joined_at)->translatedFormat('d F Y') : '-' }}
                                        </td>
                                        <td>
                                            @if ($user->role === 'admin')
                                                <span class="badge bg-primary">Admin</span>
                                            @else
                                                <span class="badge bg-secondary text-white">Pengguna</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex gap-1">
                                                <a href="{{ route('admin.profile.show', $user->id) }}"
                                                    class="btn btn-outline-info btn-sm" title="Lihat">
                                                    <i class="fas fa-eye"></i>
                                                </a>

                                                @if ($user->role !== 'admin')
                                                    <form action="{{ route('admin.delete-user', $user) }}" method="POST"
                                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-outline-danger btn-sm"
                                                            title="Hapus">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                @else
                                                    <button class="btn btn-outline-secondary btn-sm" disabled>Hapus</button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    <div class="d-flex justify-content-end mt-3 px-3">
                        {{ $users->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
