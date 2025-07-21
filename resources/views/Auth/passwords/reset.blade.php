@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2 class="mb-4">Reset Password</h2>

    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('password.update') }}">
        @csrf

        <input type="hidden" name="token" value="{{ $token }}">
        <input type="hidden" name="email" value="{{ request()->email }}">

        <div class="mb-3">
            <label for="password" class="form-label">New Password</label>
            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                name="password" required autofocus>

            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password-confirm" class="form-label">Confirm New Password</label>
            <input id="password-confirm" type="password" class="form-control"
                name="password_confirmation" required>
        </div>

        <button type="submit" class="btn btn-dark">Reset Password</button>
    </form>
</div>
@endsection
