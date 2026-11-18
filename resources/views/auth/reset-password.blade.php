@extends('layouts.auth')

@section('title', 'Password Baru Admin')

@section('content')
    <div class="text-center mb-4"><span class="d-inline-flex align-items-center justify-content-center bg-primary-subtle text-primary rounded-circle mb-3" style="width:3.2rem;height:3.2rem"><i class="bi bi-shield-lock-fill fs-4"></i></span><h1 class="h3 fw-bold mb-2">Buat password baru</h1><p class="text-muted mb-0">Gunakan minimal 8 karakter agar akun tetap aman.</p></div>
    <form action="{{ route('password.update') }}" method="POST">@csrf
        <input type="hidden" name="token" value="{{ $token }}">
        <div class="mb-3"><label for="email" class="form-label fw-semibold">Email admin</label><input id="email" name="email" type="email" value="{{ old('email', $email) }}" class="form-control @error('email') is-invalid @enderror" autocomplete="email" required autofocus>@error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
        <div class="mb-3"><label for="password" class="form-label fw-semibold">Password baru</label><input id="password" name="password" type="password" class="form-control @error('password') is-invalid @enderror" autocomplete="new-password" minlength="8" required>@error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
        <div class="mb-4"><label for="password_confirmation" class="form-label fw-semibold">Konfirmasi password baru</label><input id="password_confirmation" name="password_confirmation" type="password" class="form-control" autocomplete="new-password" minlength="8" required></div>
        <button class="btn btn-primary w-100" type="submit"><i class="bi bi-check2-circle me-2"></i>Simpan password baru</button>
    </form>
@endsection
