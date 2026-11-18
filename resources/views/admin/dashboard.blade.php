@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="page-heading reveal"><div><span class="page-eyebrow">Panel administrasi</span><h1 class="h2 fw-bold mb-1 mt-2">Dashboard Admin</h1><p class="text-muted mb-0"><i class="bi bi-calendar3 me-1"></i>Ringkasan kehadiran {{ now()->translatedFormat('l, d F Y') }}.</p></div><a class="btn btn-primary" href="{{ route('admin.reports.index') }}"><i class="bi bi-bar-chart-line-fill me-1"></i>Lihat laporan</a></div>

<div class="row g-3 mb-4">
    <div class="col-6 col-xl-3 reveal"><div class="card stat-card h-100"><div class="card-body p-4 position-relative" style="z-index:1"><div class="d-flex align-items-start justify-content-between"><div><div class="text-muted small fw-semibold">Total karyawan</div><div class="stat-number text-primary">{{ $totalKaryawan }}</div></div><span class="rounded-4 bg-primary-subtle text-primary p-3"><i class="bi bi-people-fill fs-4"></i></span></div><small class="text-muted">Terdaftar di sistem</small></div></div></div>
    <div class="col-6 col-xl-3 reveal"><div class="card stat-card h-100"><div class="card-body p-4 position-relative" style="z-index:1"><div class="d-flex align-items-start justify-content-between"><div><div class="text-muted small fw-semibold">Sudah absen masuk</div><div class="stat-number text-success">{{ $hadirHariIni }}</div></div><span class="rounded-4 bg-success-subtle text-success p-3"><i class="bi bi-person-check-fill fs-4"></i></span></div><small class="text-muted">Kehadiran tercatat hari ini</small></div></div></div>
    <div class="col-6 col-xl-3 reveal"><div class="card stat-card h-100"><div class="card-body p-4 position-relative" style="z-index:1"><div class="d-flex align-items-start justify-content-between"><div><div class="text-muted small fw-semibold">Terlambat</div><div class="stat-number text-warning">{{ $terlambatHariIni }}</div></div><span class="rounded-4 bg-warning-subtle text-warning-emphasis p-3"><i class="bi bi-alarm-fill fs-4"></i></span></div><small class="text-muted">Setelah pukul 08.00</small></div></div></div>
    <div class="col-6 col-xl-3 reveal"><div class="card stat-card h-100"><div class="card-body p-4 position-relative" style="z-index:1"><div class="d-flex align-items-start justify-content-between"><div><div class="text-muted small fw-semibold">Menunggu persetujuan</div><div class="stat-number text-danger">{{ $cutiMenunggu }}</div></div><span class="rounded-4 bg-danger-subtle text-danger p-3"><i class="bi bi-clipboard2-pulse-fill fs-4"></i></span></div><small class="text-muted">Izin, sakit, atau cuti</small></div></div></div>
</div>

<div class="row g-4">
    <div class="col-xl-8 reveal">
        <div class="d-flex justify-content-between align-items-center mb-3"><div><h2 class="h5 fw-bold mb-0">Kehadiran per shift</h2><small class="text-muted">Karyawan yang sudah absen masuk hari ini. Pada jam tumpang tindih, shift dengan jam mulai paling akhir dipakai.</small></div><span class="small text-success text-nowrap"><i class="bi bi-arrow-repeat me-1"></i>Memperbarui otomatis</span></div>
        <div data-shift-board data-feed-url="{{ route('admin.dashboard.shift-feed') }}">
            @include('admin.partials.shift-board', ['shiftGroups' => $shiftGroups, 'hadirHariIni' => $hadirHariIni])
        </div>
    </div>
    <div class="col-xl-4 reveal"><div class="card h-100"><div class="card-body p-4"><div class="d-flex justify-content-between align-items-center mb-3"><div><h2 class="h5 fw-bold mb-0">Pengajuan menunggu</h2><small class="text-muted">Tinjau dan putuskan permintaan karyawan.</small></div><i class="bi bi-clipboard2-check text-primary fs-4"></i></div>
        @forelse($pendingLeaves as $leave)
            <div class="border rounded-4 p-3 mb-3"><div class="d-flex justify-content-between gap-2"><div><strong>{{ $leave->user->name }}</strong><small class="text-muted d-block">{{ \Carbon\Carbon::parse($leave->start_date)->translatedFormat('d M') }} – {{ \Carbon\Carbon::parse($leave->end_date)->translatedFormat('d M Y') }}</small></div><span class="badge text-bg-warning align-self-start text-capitalize">{{ $leave->type }}</span></div><p class="small mb-3 mt-2">{{ $leave->reason }}</p><div class="d-flex gap-2"><form action="{{ route('admin.leaves.update-status', $leave) }}" method="POST">@csrf @method('PATCH')<input type="hidden" name="status" value="approved"><button class="btn btn-sm btn-success"><i class="bi bi-check-lg me-1"></i>Setujui</button></form><form action="{{ route('admin.leaves.update-status', $leave) }}" method="POST" data-confirm="Tolak pengajuan {{ $leave->user->name }}?">@csrf @method('PATCH')<input type="hidden" name="status" value="rejected"><button class="btn btn-sm btn-outline-danger"><i class="bi bi-x-lg me-1"></i>Tolak</button></form></div></div>
        @empty
            <div class="text-center text-muted py-5"><i class="bi bi-check2-all d-block fs-2 text-success mb-2"></i>Tidak ada pengajuan yang menunggu.</div>
        @endforelse
    </div></div></div>
</div>
@endsection

@push('styles')
<style>
    .shift-card { border-top: 3px solid #1689d0; }
    .shift-card[data-shift="shift_2"] { border-top-color: #e49a32; }
    .shift-card[data-shift="shift_3"] { border-top-color: #5263aa; }
    .shift-card__eyebrow { color: var(--muted); font-size: .75rem; font-weight: 700; }
    .shift-card__icon { align-items: center; background: rgba(22,137,208,.1); border-radius: .7rem; color: #1689d0; display: inline-flex; height: 2.4rem; justify-content: center; width: 2.4rem; }
    [data-shift="shift_2"] .shift-card__icon { background: rgba(228,154,50,.14); color: #a8660b; }
    [data-shift="shift_3"] .shift-card__icon { background: rgba(82,99,170,.12); color: #5263aa; }
    .shift-card__count { color: var(--ink); font-size: 1.65rem; font-weight: 800; line-height: 1.2; }
    .shift-card__count span { color: var(--muted); font-size: .78rem; font-weight: 600; }
    .shift-card__attendances { margin-top: 1rem; }
    .shift-attendance { align-items: center; border-top: 1px solid var(--border); display: flex; gap: .65rem; min-width: 0; padding: .65rem 0; }
    .shift-attendance strong { color: var(--ink); font-size: .82rem; }
    .shift-attendance small { display: block; font-size: .72rem; }
    .shift-attendance__time { color: var(--ink); font-size: .78rem; font-weight: 750; margin-left: auto; }
    .shift-card__empty { align-items: center; border-top: 1px solid var(--border); color: var(--muted); display: flex; font-size: .8rem; gap: .5rem; padding: 1rem 0 .25rem; }
</style>
@endpush

@push('scripts')
<script>
(() => {
    const board = document.querySelector('[data-shift-board]');
    if (!board) return;

    const refreshBoard = async () => {
        try {
            const response = await fetch(board.dataset.feedUrl, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' },
                cache: 'no-store',
            });
            if (response.ok) board.innerHTML = await response.text();
        } catch {}
    };

    window.setInterval(refreshBoard, 10000);
})();
</script>
@endpush
