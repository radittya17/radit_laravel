@extends('layouts.auth')

@section('title', 'Reset Password Admin')

@section('content')
    <div class="text-center mb-4"><span class="d-inline-flex align-items-center justify-content-center bg-primary-subtle text-primary rounded-circle mb-3" style="width:3.2rem;height:3.2rem"><i class="bi bi-key-fill fs-4"></i></span><h1 class="h3 fw-bold mb-2">Reset password admin</h1><p class="text-muted mb-0">Kami akan mengirim tautan aman ke email admin.</p></div>
    @if (session('status'))<div class="alert alert-success"><i class="bi bi-check-circle-fill me-2"></i>{{ session('status') }}</div>@endif
    <form action="{{ route('password.email') }}" method="POST">@csrf
        <div class="mb-4"><label for="email" class="form-label fw-semibold">Email admin</label><input id="email" name="email" type="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" autocomplete="email" required autofocus>@error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
        <button class="btn btn-primary w-100" type="submit"><i class="bi bi-send-fill me-2"></i>Kirim tautan reset</button>
    </form>
    <p class="text-center text-muted mt-4 mb-0"><a href="{{ route('login') }}"><i class="bi bi-arrow-left me-1"></i>Kembali ke halaman masuk</a></p>
@endsection
