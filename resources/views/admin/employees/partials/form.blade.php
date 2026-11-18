@php($editing = filled($employee))
@php($activeValue = old('is_active', $editing ? ($employee->is_active ? '1' : '0') : '1'))
<div class="modal fade" id="{{ $editing ? 'editEmployee'.$employee->id : 'createEmployee' }}" tabindex="-1" aria-hidden="true"><div class="modal-dialog modal-lg"><div class="modal-content">
    <form method="POST" action="{{ $editing ? route('admin.employees.update', $employee) : route('admin.employees.store') }}">@csrf @if($editing) @method('PUT') @endif
        <div class="modal-header"><h2 class="h5 modal-title">{{ $editing ? 'Ubah data karyawan' : 'Tambah karyawan' }}</h2><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
        <div class="modal-body"><div class="row g-3">
            <div class="col-md-6"><label class="form-label">Nama lengkap</label><input name="name" value="{{ $editing ? $employee->name : old('name') }}" class="form-control" required></div>
            <div class="col-md-6"><label class="form-label">NIP</label><input name="nip" value="{{ $editing ? $employee->nip : old('nip') }}" class="form-control" placeholder="Opsional"></div>
            <div class="col-md-6"><label class="form-label">Email</label><input type="email" name="email" value="{{ $editing ? $employee->email : old('email') }}" class="form-control" required></div>
            <div class="col-md-6"><label class="form-label">Nomor telepon</label><input name="phone" value="{{ $editing ? $employee->phone : old('phone') }}" class="form-control" placeholder="Opsional"></div>
            <div class="col-md-6"><label class="form-label">Jabatan</label><input name="jabatan" value="{{ $editing ? $employee->jabatan : old('jabatan') }}" class="form-control" placeholder="Opsional"></div>
            <div class="col-md-6"><label class="form-label">Status akun</label><select name="is_active" class="form-select" required><option value="1" @selected((string) $activeValue === '1')>Aktif</option><option value="0" @selected((string) $activeValue === '0')>Nonaktif</option></select><div class="form-text">Akun nonaktif tidak dapat masuk ke aplikasi.</div></div>
            <div class="col-md-6"><label class="form-label">Kata sandi {{ $editing ? '(kosongkan bila tidak diubah)' : '' }}</label><input type="password" name="password" class="form-control" {{ $editing ? '' : 'required' }} minlength="8"></div>
            <div class="col-md-6"><label class="form-label">Konfirmasi kata sandi</label><input type="password" name="password_confirmation" class="form-control" {{ $editing ? '' : 'required' }} minlength="8"></div>
        </div></div>
        <div class="modal-footer"><button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button><button class="btn btn-primary">{{ $editing ? 'Simpan perubahan' : 'Tambah karyawan' }}</button></div>
    </form>
</div></div></div>
