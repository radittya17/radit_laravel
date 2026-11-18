@extends('layouts.app')

@section('title', 'Dashboard Karyawan')

@section('content')
<div class="page-heading reveal">
    <div>
        <span class="page-eyebrow">Portal karyawan</span>
        <h1 class="h2 fw-bold mb-1 mt-2">Selamat datang, {{ auth()->user()->name }}</h1>
        <p class="text-muted mb-0"><i class="bi bi-calendar3 me-1"></i>{{ now()->translatedFormat('l, d F Y') }}</p>
    </div>
    <div class="d-flex align-items-center gap-2"><x-user-avatar :user="auth()->user()" /><div><strong>{{ auth()->user()->jabatan ?: 'Karyawan' }}</strong><small class="text-muted d-block">Status akun aktif</small></div></div>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-4 reveal"><div class="card stat-card h-100"><div class="card-body p-4 d-flex align-items-center gap-3 position-relative" style="z-index:1"><span class="rounded-4 bg-primary-subtle text-primary p-3"><i class="bi bi-calendar-check fs-4"></i></span><div><div class="text-muted small">Kehadiran bulan ini</div><div class="stat-number text-primary">{{ $monthlyPresentCount }}</div></div></div></div></div>
    <div class="col-md-4 reveal"><div class="card stat-card h-100"><div class="card-body p-4 d-flex align-items-center gap-3 position-relative" style="z-index:1"><span class="rounded-4 bg-warning-subtle text-warning-emphasis p-3"><i class="bi bi-alarm fs-4"></i></span><div><div class="text-muted small">Terlambat bulan ini</div><div class="stat-number text-warning">{{ $monthlyLateCount }}</div></div></div></div></div>
    <div class="col-md-4 reveal"><div class="card stat-card h-100"><div class="card-body p-4 d-flex align-items-center gap-3 position-relative" style="z-index:1"><span class="rounded-4 bg-success-subtle text-success p-3"><i class="bi bi-clock-history fs-4"></i></span><div><div class="text-muted small">Waktu WIB</div><div class="fw-bold fs-4" data-live-clock>--:--:--</div></div></div></div></div>
</div>

<section class="card mb-4 reveal overflow-hidden" id="absensi-hari-ini">
    <div class="card-body p-4 p-lg-5">
        <div class="row align-items-center g-4">
            <div class="col-lg">
                <span class="text-primary fw-bold small text-uppercase" style="letter-spacing:.1em">Absensi masuk hari ini</span>
                @if ($attendanceToday?->time_in)
                    <h2 class="h4 fw-bold mt-2 mb-2">Kehadiran Anda sudah tercatat</h2>
                    <p class="text-muted mb-0">Waktu masuk <strong>{{ \Carbon\Carbon::parse($attendanceToday->time_in)->format('H:i') }} WIB</strong> <span class="badge text-bg-primary ms-1">{{ $attendanceToday->shift['name'] }} · {{ $attendanceToday->shift['hours'] }}</span> <span class="badge text-bg-{{ $attendanceToday->status === 'terlambat' ? 'warning' : 'success' }} ms-1">{{ ucfirst($attendanceToday->status) }}</span></p>
                @else
                    <h2 class="h4 fw-bold mt-2 mb-2">{{ $attendanceToday ? 'Absensi masuk belum tercatat' : 'Anda belum melakukan absensi masuk' }}</h2>
                    <p class="text-muted mb-0">Catat waktu kehadiran saat mulai bekerja. Absensi hanya dapat dikirim satu kali dalam sehari.</p>
                @endif
            </div>
            <div class="col-lg-auto">
                <form action="{{ route('attendance.masuk') }}" method="POST">@csrf
                    <button class="btn btn-success btn-lg px-4" {{ $attendanceToday?->time_in ? 'disabled' : '' }}>
                        <i class="bi bi-box-arrow-in-right me-2"></i>{{ $attendanceToday?->time_in ? 'Absensi sudah tercatat' : 'Absen masuk' }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>

<div class="row g-4">
    <div class="col-lg-5 reveal" id="ajukan-izin"><div class="card h-100"><div class="card-body p-4">
        @if ($attendanceToday?->time_in)
            <div class="d-flex h-100 flex-column justify-content-center">
                <div class="d-flex align-items-center gap-2 mb-3"><span class="rounded-3 bg-secondary-subtle text-secondary p-2"><i class="bi bi-lock-fill"></i></span><div><h2 class="h5 fw-bold mb-0">Pengajuan ditutup hari ini</h2><small class="text-muted">Izin, sakit, dan cuti sementara tidak tersedia.</small></div></div>
                <p class="text-muted mb-3">Absensi masuk Anda sudah tercatat. Form pengajuan akan dibuka kembali besok.</p>
                <span class="badge rounded-pill text-bg-secondary align-self-start"><i class="bi bi-calendar-check me-1"></i>Dibuka kembali besok</span>
            </div>
        @else
            <div class="d-flex align-items-center gap-2 mb-3"><span class="rounded-3 bg-primary-subtle text-primary p-2"><i class="bi bi-send-plus"></i></span><div><h2 class="h5 fw-bold mb-0">Ajukan izin atau cuti</h2><small class="text-muted">Pengajuan akan ditinjau oleh admin.</small></div></div>
            <form action="{{ route('leaves.store') }}" method="POST">@csrf
                <div class="mb-3"><label class="form-label fw-semibold" for="type">Jenis pengajuan</label><select id="type" name="type" class="form-select @error('type') is-invalid @enderror" required><option value="" disabled {{ old('type') ? '' : 'selected' }}>Pilih jenis</option><option value="izin" @selected(old('type') === 'izin')>Izin</option><option value="sakit" @selected(old('type') === 'sakit')>Sakit</option><option value="cuti" @selected(old('type') === 'cuti')>Cuti</option></select>@error('type')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                <div class="row"><div class="col-sm-6 mb-3"><label class="form-label fw-semibold" for="start_date">Tanggal mulai</label><input id="start_date" type="date" name="start_date" value="{{ old('start_date') }}" class="form-control @error('start_date') is-invalid @enderror" required>@error('start_date')<div class="invalid-feedback">{{ $message }}</div>@enderror</div><div class="col-sm-6 mb-3"><label class="form-label fw-semibold" for="end_date">Tanggal selesai</label><input id="end_date" type="date" name="end_date" value="{{ old('end_date') }}" class="form-control @error('end_date') is-invalid @enderror" required>@error('end_date')<div class="invalid-feedback">{{ $message }}</div>@enderror</div></div>
                <div class="mb-3"><label class="form-label fw-semibold" for="reason">Alasan</label><textarea id="reason" name="reason" rows="3" class="form-control @error('reason') is-invalid @enderror" placeholder="Jelaskan kebutuhan pengajuan Anda" required>{{ old('reason') }}</textarea>@error('reason')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
                <button class="btn btn-primary" type="submit"><i class="bi bi-send-fill me-1"></i>Kirim pengajuan</button>
            </form>
        @endif
    </div></div></div>
    <div class="col-lg-7 reveal" id="riwayat-absensi"><div class="card h-100"><div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-center mb-3"><div><h2 class="h5 fw-bold mb-0">Riwayat absensi masuk</h2><small class="text-muted">10 catatan terbaru</small></div><i class="bi bi-clock-history text-primary fs-4"></i></div>
        <div class="table-responsive"><table class="table align-middle mb-0"><thead><tr><th>Tanggal</th><th>Jam masuk</th><th>Status</th></tr></thead><tbody>
            @forelse($attendances as $item)
                <tr><td class="fw-semibold">{{ \Carbon\Carbon::parse($item->date)->translatedFormat('l, d F Y') }}</td><td>{{ $item->time_in ? \Carbon\Carbon::parse($item->time_in)->format('H:i').' WIB' : '—' }}</td><td><span class="badge text-bg-{{ $item->status === 'hadir' ? 'success' : ($item->status === 'terlambat' ? 'warning' : 'secondary') }}">{{ ucfirst($item->status) }}</span></td></tr>
            @empty
                <tr><td colspan="3" class="text-center text-muted py-5"><i class="bi bi-calendar-x d-block fs-3 mb-2"></i>Belum ada riwayat absensi.</td></tr>
            @endforelse
        </tbody></table></div>
    </div></div></div>
</div>

<section class="card mt-4 reveal"><div class="card-body p-4">
    <div class="d-flex justify-content-between align-items-center mb-3"><div><h2 class="h5 fw-bold mb-0">Status pengajuan</h2><small class="text-muted">Pantau perkembangan izin, sakit, atau cuti Anda.</small></div><i class="bi bi-clipboard2-check text-primary fs-4"></i></div>
    <div class="table-responsive"><table class="table align-middle mb-0"><thead><tr><th>Jenis</th><th>Periode</th><th>Alasan</th><th>Status</th></tr></thead><tbody>
        @forelse($leaves as $leave)
            <tr><td class="text-capitalize fw-semibold">{{ $leave->type }}</td><td>{{ \Carbon\Carbon::parse($leave->start_date)->translatedFormat('d F Y') }} – {{ \Carbon\Carbon::parse($leave->end_date)->translatedFormat('d F Y') }}</td><td>{{ $leave->reason }}</td><td><span class="badge text-bg-{{ $leave->status === 'approved' ? 'success' : ($leave->status === 'rejected' ? 'danger' : 'warning') }}">{{ $leave->status === 'pending' ? 'Menunggu' : ucfirst($leave->status) }}</span></td></tr>
        @empty
            <tr><td colspan="4" class="text-center text-muted py-5"><i class="bi bi-inbox d-block fs-3 mb-2"></i>Belum ada pengajuan.</td></tr>
        @endforelse
    </tbody></table></div>
</div></section>
@endsection

@if ($attendanceToday?->time_in)
    @push('scripts')
        <script>
            (() => {
                const parts = new Intl.DateTimeFormat('en-GB', {
                    timeZone: 'Asia/Jakarta', year: 'numeric', month: '2-digit', day: '2-digit'
                }).formatToParts(new Date()).reduce((values, part) => {
                    if (part.type !== 'literal') values[part.type] = part.value;
                    return values;
                }, {});
                const nextJakartaMidnight = Date.UTC(Number(parts.year), Number(parts.month) - 1, Number(parts.day) + 1, 0, 0, 2) - (7 * 60 * 60 * 1000);
                window.setTimeout(() => window.location.reload(), Math.max(1000, nextJakartaMidnight - Date.now()));
            })();
        </script>
    @endpush
@endif
