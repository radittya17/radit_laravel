<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Attendance;
use App\Models\Leave;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $today = today()->toDateString();
        $shiftBoard = $this->shiftBoardData();

        return view('admin.dashboard', [
            'totalKaryawan' => User::where('role', 'karyawan')->count(),
            'hadirHariIni' => $shiftBoard['hadirHariIni'],
            'terlambatHariIni' => Attendance::where('date', $today)->whereNotNull('time_in')->where('status', 'terlambat')->count(),
            'cutiMenunggu' => Leave::where('status', 'pending')->count(),
            'shiftGroups' => $shiftBoard['shiftGroups'],
            'pendingLeaves' => Leave::with('user')->where('status', 'pending')->oldest()->get(),
        ]);
    }

    public function shiftFeed()
    {
        return response()->view('admin.partials.shift-board', $this->shiftBoardData());
    }

    public function report(Request $request)
    {
        [$month, $employees] = $this->reportData($request);

        return view('admin.reports.index', compact('employees', 'month'));
    }

    public function exportReport(Request $request)
    {
        [$month, $employees] = $this->reportData($request);
        $filename = "laporan-kehadiran-{$month}.csv";

        return response()->streamDownload(function () use ($employees) {
            $output = fopen('php://output', 'w');
            fwrite($output, "\xEF\xBB\xBF");
            fputcsv($output, ['Nama Karyawan', 'NIP', 'Email', 'Hadir', 'Terlambat', 'Izin', 'Sakit', 'Alpa']);

            foreach ($employees as $employee) {
                $counts = $employee->attendances->countBy('status');
                fputcsv($output, [
                    $employee->name, $employee->nip, $employee->email,
                    $counts->get('hadir', 0), $counts->get('terlambat', 0), $counts->get('izin', 0),
                    $counts->get('sakit', 0), $counts->get('alpa', 0),
                ]);
            }

            fclose($output);
        }, $filename, ['Content-Type' => 'text/csv; charset=UTF-8']);
    }

    public function exportReportPdf(Request $request)
    {
        [$month, $employees] = $this->reportData($request);
        $filename = "laporan-kehadiran-{$month}.pdf";

        return Pdf::loadView('admin.reports.pdf', compact('employees', 'month'))
            ->setPaper('a4', 'landscape')
            ->download($filename);
    }

    private function reportData(Request $request): array
    {
        $month = $request->query('month', now()->format('Y-m'));
        abort_unless(preg_match('/^\d{4}-\d{2}$/', $month), 404);

        $employees = User::where('role', 'karyawan')->with(['attendances' => function ($query) use ($month) {
            $query->where('date', 'like', "{$month}%");
        }])->orderBy('name')->get();

        return [$month, $employees];
    }

    private function shiftBoardData(): array
    {
        $attendances = Attendance::with('user')
            ->where('date', today()->toDateString())
            ->whereNotNull('time_in')
            ->latest('time_in')
            ->get();

        $shiftGroups = collect(Attendance::shiftDefinitions())->map(function (array $shift) use ($attendances) {
            $shiftAttendances = $attendances
                ->filter(fn (Attendance $attendance) => $attendance->shift['key'] === $shift['key']);
            $shift['attendances'] = $shiftAttendances->take(5);
            $shift['count'] = $shiftAttendances->count();

            return $shift;
        });

        return [
            'hadirHariIni' => $attendances->count(),
            'shiftGroups' => $shiftGroups,
        ];
    }
}
