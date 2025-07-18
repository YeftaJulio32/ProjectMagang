@extends('layouts.app')
@section('title', 'Manajemen Komentar')

@section('content')

@section('content')
<div class="container mt-4">
    <h2>Daftar Komentar</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>Nama User</th>
                <th>Komentar</th>
                <th>Tanggal</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($comments as $komen)
                <tr>
                    <td>{{ $komen->user->name ?? '-' }}</td>
                    <td>{{ $komen->isi }}</td>
                    <td>{{ $komen->created_at->format('d M Y H:i') }}</td>
                    <td>
                        <form action="{{ route('admin.komentar.destroy', $komen->id) }}" method="POST" onsubmit="return confirm('Yakin hapus komentar ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">Belum ada komentar.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $comments->links() }}
</div>
@endsection

@endsection
