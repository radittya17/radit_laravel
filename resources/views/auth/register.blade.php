@extends('layouts.auth')

@section('title', 'Daftar')

@section('content')
    <div class="text-center mb-4"><h1 class="h3 fw-bold mb-2">Buat akun karyawan</h1><p class="text-muted mb-0">Lengkapi data berikut untuk mulai menggunakan sistem.</p></div>
    <form action="{{ route('register.store') }}" method="POST">@csrf
        <div class="mb-3"><label for="name" class="form-label fw-semibold">Nama lengkap</label><input id="name" name="name" type="text" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" autocomplete="name" required autofocus>@error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
        <div class="mb-3"><label for="email" class="form-label fw-semibold">Email</label><input id="email" name="email" type="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" autocomplete="email" required>@error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
        <div class="mb-3"><label for="password" class="form-label fw-semibold">Kata sandi</label><input id="password" name="password" type="password" class="form-control @error('password') is-invalid @enderror" autocomplete="new-password" minlength="8" required>@error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
        <div class="mb-4"><label for="password_confirmation" class="form-label fw-semibold">Konfirmasi kata sandi</label><input id="password_confirmation" name="password_confirmation" type="password" class="form-control" autocomplete="new-password" minlength="8" required></div>
        <button class="btn btn-primary w-100" type="submit"><i class="bi bi-person-plus-fill me-2"></i>Daftar dan masuk</button>
    </form>
    <p class="text-center text-muted mt-4 mb-0">Sudah punya akun? <a href="{{ route('login') }}">Masuk sekarang</a></p>
@endsection
