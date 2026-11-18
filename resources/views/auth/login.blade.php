@extends('layouts.auth')

@section('title', 'Masuk')

@section('content')
    <div class="text-center mb-4"><h1 class="h3 fw-bold mb-2">Selamat datang</h1><p class="text-muted mb-0">Masuk untuk mencatat kehadiran Anda.</p></div>
    @if (session('info'))<div class="alert alert-info"><i class="bi bi-info-circle-fill me-2"></i>{{ session('info') }}</div>@endif
    @if (session('status'))<div class="alert alert-success"><i class="bi bi-check-circle-fill me-2"></i>{{ session('status') }}</div>@endif
    <form action="{{ route('login.attempt') }}" method="POST">@csrf
        <div class="mb-3"><label for="email" class="form-label fw-semibold">Email</label><input id="email" name="email" type="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" autocomplete="email" required autofocus>@error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
        <div class="mb-3"><div class="d-flex justify-content-between"><label for="password" class="form-label fw-semibold">Kata sandi</label><a class="small" href="{{ route('password.request') }}">Lupa password?</a></div><input id="password" name="password" type="password" class="form-control @error('password') is-invalid @enderror" autocomplete="current-password" required>@error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
        <div class="form-check mb-4"><input id="remember" name="remember" value="1" type="checkbox" class="form-check-input"><label for="remember" class="form-check-label">Ingat saya di perangkat ini</label></div>
        <button class="btn btn-primary w-100" type="submit"><i class="bi bi-box-arrow-in-right me-2"></i>Masuk ke dashboard</button>
    </form>
    <p class="text-center text-muted mt-4 mb-0">Belum punya akun? <a href="{{ route('register') }}">Daftar sebagai karyawan</a></p>
@endsection
