@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Reset Password</h2>

    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div class="mb-3">
            <label for="email">Alamat Email</label>
            <input type="email" name="email" class="form-control" required autofocus>
            @error('email')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Kirim Link Reset</button>
    </form>
</div>
@endsection
