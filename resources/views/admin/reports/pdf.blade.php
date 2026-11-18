<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Laporan Kehadiran {{ $month }}</title>
    <style>
        @page { margin: 28px 30px; }
        body { color:#1d2b45; font-family:DejaVu Sans, sans-serif; font-size:10px; }
        .header { border-bottom:2px solid #1769c2; margin-bottom:18px; padding-bottom:12px; }
        .eyebrow { color:#1769c2; font-size:9px; font-weight:bold; letter-spacing:1.2px; text-transform:uppercase; }
        h1 { color:#0b2468; font-size:20px; margin:5px 0 3px; }
        .meta { color:#68758a; font-size:10px; }
        .summary { background:#f1f6fd; border:1px solid #dce7f4; border-radius:6px; color:#36516f; margin-bottom:14px; padding:8px 10px; }
        table { border-collapse:collapse; width:100%; }
        th { background:#0b2468; color:#fff; font-size:9px; padding:8px 7px; text-align:left; text-transform:uppercase; }
        th:not(:first-child), td:not(:first-child) { text-align:center; }
        td { border-bottom:1px solid #e3eaf3; padding:8px 7px; }
        tbody tr:nth-child(even) { background:#f8fafd; }
        .employee-name { font-weight:bold; }
        .employee-meta { color:#68758a; font-size:8px; margin-top:2px; }
        .badge { border-radius:10px; display:inline-block; font-weight:bold; min-width:18px; padding:3px 5px; }
        .badge-success { background:#d8f3e3; color:#146c43; }
        .badge-warning { background:#fff0c2; color:#8a5a00; }
        .empty { color:#68758a; padding:22px; text-align:center; }
        .footer { color:#8793a5; font-size:8px; margin-top:16px; text-align:right; }
    </style>
</head>
<body>
    @php($reportPeriod = \Carbon\Carbon::createFromFormat('Y-m', $month)->translatedFormat('F Y'))
    <div class="header">
        <div class="eyebrow">Analitik kehadiran</div>
        <h1>Laporan Kehadiran</h1>
        <div class="meta">Rekap bulanan untuk {{ $reportPeriod }}</div>
    </div>

    <div class="summary">Total karyawan: <strong>{{ $employees->count() }}</strong> &middot; Dokumen dibuat {{ now()->translatedFormat('d F Y, H:i') }}</div>

    <table>
        <thead>
            <tr>
                <th>Karyawan</th>
                <th>Hadir</th>
                <th>Terlambat</th>
                <th>Izin</th>
                <th>Sakit</th>
                <th>Alpa</th>
            </tr>
        </thead>
        <tbody>
            @forelse($employees as $employee)
                @php($counts = $employee->attendances->countBy('status'))
                <tr>
                    <td>
                        <div class="employee-name">{{ $employee->name }}</div>
                        <div class="employee-meta">{{ $employee->nip ?: $employee->email }}</div>
                    </td>
                    <td><span class="badge badge-success">{{ $counts->get('hadir', 0) }}</span></td>
                    <td><span class="badge badge-warning">{{ $counts->get('terlambat', 0) }}</span></td>
                    <td>{{ $counts->get('izin', 0) }}</td>
                    <td>{{ $counts->get('sakit', 0) }}</td>
                    <td>{{ $counts->get('alpa', 0) }}</td>
                </tr>
            @empty
                <tr><td colspan="6" class="empty">Belum ada data karyawan.</td></tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">Sistem Kehadiran Terpadu &middot; PT.NOK Indonesia</div>
</body>
</html>
