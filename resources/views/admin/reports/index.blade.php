@extends('layouts.app')

@section('title', 'Laporan Kehadiran')

@push('styles')
    <style>
        .report-heading { align-items:center; gap:1rem; padding:1rem 1.15rem; }
        .report-heading h1 { font-size:1.45rem; }
        .report-heading__intro { min-width:14rem; }
        .report-toolbar,.report-filter,.report-export-actions { align-items:center; display:flex; flex-wrap:wrap; gap:.45rem; }
        .report-toolbar { justify-content:flex-end; }
        .report-month-input { min-height:2.45rem; width:10.5rem; }
        .report-action { font-size:.84rem; min-height:2.45rem; padding:.52rem .75rem; white-space:nowrap; }
        .report-card .card-body { padding:1.25rem!important; }
        .report-card .table > :not(caption) > * > * { padding:.72rem .65rem; }
        .report-card__icon { padding:.6rem!important; }

        @media (max-width: 991.98px) {
            .report-heading__intro,.report-toolbar { width:100%; }
            .report-toolbar { justify-content:flex-start; }
        }

        @media (max-width: 575.98px) {
            .report-filter { width:100%; }
            .report-month-input { flex:1; width:auto; }
            .report-filter .report-action { flex:0 0 auto; }
            .report-export-actions { width:100%; }
            .report-export-actions .report-action { flex:1; }
        }
    </style>
@endpush

@section('content')
    <div class="page-heading report-heading reveal">
        <div class="report-heading__intro">
            <span class="page-eyebrow">Analitik kehadiran</span>
            <h1 class="h2 fw-bold mb-1 mt-2">Laporan Kehadiran</h1>
            <p class="text-muted mb-0 small">Rekap kehadiran karyawan berdasarkan bulan.</p>
        </div>

        <div class="report-toolbar">
            <form method="GET" class="report-filter" aria-label="Filter laporan">
                <label class="visually-hidden" for="report-month">Pilih bulan laporan</label>
                <input id="report-month" class="form-control report-month-input" type="month" name="month" value="{{ $month }}">
                <button class="btn btn-primary report-action" type="submit">
                    <i class="bi bi-funnel-fill me-1"></i>Tampilkan
                </button>
            </form>

            <div class="report-export-actions" aria-label="Pilihan ekspor laporan">
                <a class="btn btn-outline-primary report-action" href="{{ route('admin.reports.export', ['month' => $month]) }}">
                    <i class="bi bi-filetype-csv me-1"></i>CSV
                </a>
                <a class="btn btn-outline-danger report-action" href="{{ route('admin.reports.export-pdf', ['month' => $month]) }}">
                    <i class="bi bi-filetype-pdf me-1"></i>PDF
                </a>
            </div>
        </div>
    </div>

    <div class="card report-card reveal">
        <div class="card-body">
            <div class="d-flex align-items-center gap-2 mb-3">
                <span class="report-card__icon rounded-3 bg-primary-subtle text-primary">
                    <i class="bi bi-file-earmark-bar-graph"></i>
                </span>
                <div>
                    <h2 class="h5 fw-bold mb-0">Rekap {{ \Carbon\Carbon::createFromFormat('Y-m', $month)->translatedFormat('F Y') }}</h2>
                    <small class="text-muted">Unduh laporan dalam format CSV atau PDF.</small>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Karyawan</th>
                            <th class="text-center">Hadir</th>
                            <th class="text-center">Terlambat</th>
                            <th class="text-center">Izin</th>
                            <th class="text-center">Sakit</th>
                            <th class="text-center">Alpa</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($employees as $employee)
                            @php($counts = $employee->attendances->countBy('status'))
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <x-user-avatar :user="$employee" />
                                        <div>
                                            <strong>{{ $employee->name }}</strong>
                                            <small class="text-muted d-block">{{ $employee->nip ?: $employee->email }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center"><span class="badge text-bg-success">{{ $counts->get('hadir', 0) }}</span></td>
                                <td class="text-center"><span class="badge text-bg-warning">{{ $counts->get('terlambat', 0) }}</span></td>
                                <td class="text-center">{{ $counts->get('izin', 0) }}</td>
                                <td class="text-center">{{ $counts->get('sakit', 0) }}</td>
                                <td class="text-center">{{ $counts->get('alpa', 0) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-5">
                                    <i class="bi bi-bar-chart d-block fs-2 mb-2"></i>
                                    Belum ada data karyawan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
