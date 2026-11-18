@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
<div class="page-heading reveal">
    <div><span class="page-eyebrow">Akun saya</span><h1 class="h2 fw-bold mt-2 mb-1">Profil saya</h1><p class="text-muted mb-0">Kelola foto, informasi kontak, dan keamanan akun Anda.</p></div>
    <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('karyawan.dashboard') }}" class="btn btn-outline-primary"><i class="bi bi-arrow-left me-1"></i>Kembali ke dashboard</a>
</div>

<div class="row g-4">
    <div class="col-lg-4 reveal">
        <section class="card profile-summary h-100 overflow-hidden">
            <div class="profile-cover"></div>
            <div class="card-body p-4 position-relative">
                <div class="text-center profile-identity">
                    <x-user-avatar :user="$user" class="avatar--large mb-3" data-profile-avatar />
                    <h2 class="h5 fw-bold mb-1">{{ $user->name }}</h2>
                    <p class="text-muted mb-3">{{ $user->jabatan ?: ucfirst($user->role) }}</p>
                    <span class="profile-status"><span></span>Akun aktif</span>
                </div>
                <dl class="profile-details mb-0 mt-4">
                    <div><dt>Email</dt><dd>{{ $user->email }}</dd></div>
                    <div><dt>NIP</dt><dd>{{ $user->nip ?: 'Belum diatur' }}</dd></div>
                    <div><dt>Peran</dt><dd class="text-capitalize">{{ $user->role }}</dd></div>
                </dl>
            </div>
        </section>
    </div>

    <div class="col-lg-8 reveal">
        <form class="card profile-form" method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
            @csrf @method('PATCH')
            <div class="card-body p-4 p-xl-5">
                <section class="profile-section">
                    <div class="section-heading"><span class="section-icon"><i class="bi bi-camera"></i></span><div><h2 class="h5 fw-bold mb-1">Foto profil</h2><p class="text-muted small mb-0">Gunakan foto JPG, PNG, atau WebP hingga 2 MB.</p></div></div>
                    <label class="photo-upload" for="photo"><span class="upload-icon"><i class="bi bi-cloud-arrow-up"></i></span><span><strong>Pilih foto dari perangkat</strong><small class="d-block text-muted" data-photo-name>Foto akan langsung terlihat pada pratinjau.</small></span><span class="btn btn-sm btn-outline-primary ms-auto">Pilih foto</span></label>
                    <input class="visually-hidden @error('photo') is-invalid @enderror" id="photo" type="file" name="photo" accept="image/jpeg,image/png,image/webp" data-photo-input>
                    @error('photo')<div class="text-danger small mt-2">{{ $message }}</div>@enderror
                    @if($user->profile_photo_path)
                        <div class="form-check mt-3"><input class="form-check-input" type="checkbox" name="remove_photo" value="1" id="remove_photo"><label class="form-check-label" for="remove_photo">Hapus foto profil saat ini</label></div>
                    @endif
                </section>

                <section class="profile-section">
                    <div class="section-heading"><span class="section-icon"><i class="bi bi-person-lines-fill"></i></span><div><h2 class="h5 fw-bold mb-1">Informasi kontak</h2><p class="text-muted small mb-0">Pastikan nomor telepon Anda masih dapat dihubungi.</p></div></div>
                    <label class="form-label fw-semibold" for="phone">Nomor telepon</label>
                    <input class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone', $user->phone) }}" maxlength="30" placeholder="Contoh: 0812 3456 7890">
                    @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </section>

                <section class="profile-section profile-section--last">
                    <div class="section-heading"><span class="section-icon"><i class="bi bi-shield-lock"></i></span><div><h2 class="h5 fw-bold mb-1">Keamanan akun</h2><p class="text-muted small mb-0">Kosongkan kata sandi jika tidak ingin mengubahnya.</p></div></div>
                    <div class="row g-3">
                        <div class="col-md-6"><label class="form-label fw-semibold" for="password">Kata sandi baru</label><input class="form-control @error('password') is-invalid @enderror" id="password" name="password" type="password" minlength="8" autocomplete="new-password">@error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                        <div class="col-md-6"><label class="form-label fw-semibold" for="password_confirmation">Konfirmasi kata sandi</label><input class="form-control" id="password_confirmation" name="password_confirmation" type="password" minlength="8" autocomplete="new-password"></div>
                    </div>
                </section>
                <div class="d-flex justify-content-end pt-4"><button class="btn btn-primary px-4" type="submit"><i class="bi bi-check2 me-1"></i>Simpan perubahan</button></div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('styles')
<style>
    .profile-summary { position:relative; } .profile-cover { background:radial-gradient(circle at 82% 20%,rgba(255,255,255,.3),transparent 7rem),linear-gradient(125deg,#0c2d79,#1689d0 68%,#35c2dd); height:8.5rem; } .profile-identity { margin-top:-5.9rem; } .profile-details { border-top:1px solid var(--border); padding-top:1.25rem; } .profile-details div { margin-bottom:1rem; } .profile-details dt { color:var(--muted); font-size:.78rem; font-weight:750; margin-bottom:.25rem; } .profile-details dd { color:var(--ink); font-size:.92rem; margin:0; overflow-wrap:anywhere; } .profile-status { align-items:center; background:rgba(25,135,84,.1); border-radius:99px; color:#17844f; display:inline-flex; font-size:.76rem; font-weight:750; gap:.4rem; padding:.35rem .7rem; } .profile-status span { background:#1b9d62; border-radius:50%; height:.42rem; width:.42rem; }
    .profile-section { border-bottom:1px solid var(--border); margin-bottom:1.5rem; padding-bottom:1.5rem; } .profile-section--last { border:0; margin-bottom:0; padding-bottom:0; } .section-heading { align-items:center; display:flex; gap:.8rem; margin-bottom:1.2rem; } .section-icon,.upload-icon { align-items:center; background:linear-gradient(145deg,rgba(23,105,194,.13),rgba(32,185,232,.16)); border-radius:.8rem; color:var(--nok-blue); display:inline-flex; flex:0 0 auto; height:2.8rem; justify-content:center; width:2.8rem; } .photo-upload { align-items:center; background:color-mix(in srgb,var(--surface) 90%,var(--canvas)); border:1px dashed rgba(23,105,194,.42); border-radius:1rem; cursor:pointer; display:flex; gap:.85rem; padding:1rem; transition:background .2s ease,border-color .2s ease,transform .2s ease; } .photo-upload:hover { background:rgba(23,105,194,.06); border-color:var(--nok-blue); transform:translateY(-1px); } .photo-upload strong { color:var(--ink); font-size:.9rem; } .photo-upload small { font-size:.78rem; margin-top:.2rem; }
    @media(max-width:767.98px){.page-heading{align-items:flex-start;flex-direction:column;padding:1.2rem}.profile-form .card-body{padding:1.25rem!important}.photo-upload{align-items:flex-start;flex-wrap:wrap}.photo-upload .btn{margin-left:3.6rem!important}}
</style>
@endpush

@push('scripts')
<script>
(() => {
    const input = document.querySelector('[data-photo-input]');
    const avatar = document.querySelector('[data-profile-avatar]');
    const name = document.querySelector('[data-photo-name]');
    if (!input || !avatar) return;
    input.addEventListener('change', () => {
        const file = input.files?.[0];
        if (!file) return;
        if (name) name.textContent = file.name;
        let image = avatar.querySelector('img');
        if (!image) {
            image = document.createElement('img');
            image.alt = '';
            image.loading = 'eager';
            avatar.prepend(image);
        }
        image.src = URL.createObjectURL(file);
        const fallback = avatar.querySelector('[data-avatar-fallback]');
        if (fallback) fallback.hidden = true;
    });
})();
</script>
@endpush
