@extends('layouts.app')

@section('title', 'Manajemen Karyawan')

@section('content')
<div class="page-heading reveal">
    <div><span class="page-eyebrow">Data master</span><h1 class="h2 fw-bold mb-1 mt-2">Manajemen Karyawan</h1><p class="text-muted mb-0">Kelola profil dan status akun karyawan.</p></div>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createEmployee"><i class="bi bi-person-plus-fill me-1"></i>Tambah karyawan</button>
</div>

<div class="card reveal"><div class="card-body p-4">
    <form class="row g-2 mb-4" method="GET">
        <div class="col-sm-8 col-lg-5"><div class="input-group"><span class="input-group-text bg-transparent border-end-0"><i class="bi bi-search"></i></span><input type="search" name="q" value="{{ $search }}" class="form-control border-start-0 ps-0" placeholder="Cari nama, email, atau NIP" aria-label="Cari karyawan"></div></div>
        <div class="col-auto"><button class="btn btn-outline-primary"><i class="bi bi-search me-1"></i>Cari</button></div>
        @if($search)<div class="col-auto"><a class="btn btn-link" href="{{ route('admin.employees.index') }}">Reset</a></div>@endif
    </form>
    <div class="d-flex justify-content-between align-items-center mb-3"><div><h2 class="h5 fw-bold mb-0">Daftar karyawan</h2><small class="text-muted">{{ $employees->total() }} data ditemukan · klik nama atau foto untuk melihat profil</small></div></div>
    <div class="table-responsive"><table class="table table-hover align-middle mb-0"><thead><tr><th>Karyawan</th><th>NIP</th><th>Jabatan</th><th>Status akun</th><th>Kontak</th><th class="text-end">Aksi</th></tr></thead><tbody>
        @forelse($employees as $employee)
            <tr>
                <td><button class="employee-profile-trigger" type="button" data-bs-toggle="modal" data-bs-target="#employeeProfile{{ $employee->id }}" aria-label="Lihat profil {{ $employee->name }}"><x-user-avatar :user="$employee" /><span><strong class="d-block">{{ $employee->name }}</strong><small class="text-muted d-block">{{ $employee->email }}</small></span></button></td>
                <td>{{ $employee->nip ?: '—' }}</td>
                <td>{{ $employee->jabatan ?: '—' }}</td>
                <td>@if($employee->is_active)<span class="badge rounded-pill text-bg-success">Aktif</span>@else<span class="badge rounded-pill text-bg-secondary">Nonaktif</span>@endif</td>
                <td>{{ $employee->phone ?: '—' }}</td>
                <td class="text-end text-nowrap"><button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editEmployee{{ $employee->id }}"><i class="bi bi-pencil-square me-1"></i>Ubah</button><form class="d-inline" action="{{ route('admin.employees.destroy', $employee) }}" method="POST" data-confirm="Hapus akun {{ $employee->name }}? Riwayat absensi dan cutinya juga akan dihapus.">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash3"></i><span class="visually-hidden">Hapus</span></button></form></td>
            </tr>
        @empty
            <tr><td colspan="6" class="text-center text-muted py-5">Data karyawan belum tersedia.</td></tr>
        @endforelse
    </tbody></table></div>
    <div class="mt-3">{{ $employees->links() }}</div>
</div></div>

@foreach($employees as $employee)
    @include('admin.employees.partials.profile-modal', ['employee' => $employee])
    @include('admin.employees.partials.form', ['employee' => $employee])
@endforeach
@include('admin.employees.partials.form', ['employee' => null])
@endsection
