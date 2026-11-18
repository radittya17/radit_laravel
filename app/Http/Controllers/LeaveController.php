<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Leave;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class LeaveController extends Controller
{
    public function store(Request $request)
    {
        $alreadyAttendedToday = Attendance::query()
            ->where('user_id', $request->user()->id)
            ->whereDate('date', today()->toDateString())
            ->whereNotNull('time_in')
            ->exists();

        if ($alreadyAttendedToday) {
            return back()->with('error', 'Pengajuan izin, sakit, dan cuti ditutup setelah absensi masuk hari ini. Silakan ajukan kembali besok.');
        }

        $data = $request->validate([
            'type' => ['required', Rule::in(['izin', 'sakit', 'cuti'])],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'reason' => ['required', 'string', 'max:1000'],
        ]);

        $hasOverlappingRequest = $request->user()->leaves()
            ->whereIn('status', ['pending', 'approved'])
            ->whereDate('start_date', '<=', $data['end_date'])
            ->whereDate('end_date', '>=', $data['start_date'])
            ->exists();

        if ($hasOverlappingRequest) {
            return back()->withInput()->with('error', 'Sudah ada pengajuan izin/cuti pada rentang tanggal tersebut.');
        }

        $request->user()->leaves()->create($data);

        return back()->with('success', 'Pengajuan berhasil dikirim dan menunggu persetujuan admin.');
    }

    public function updateStatus(Request $request, Leave $leave)
    {
        $data = $request->validate(['status' => ['required', Rule::in(['approved', 'rejected'])]]);
        $leave->update($data);

        return back()->with('success', 'Status pengajuan berhasil diperbarui.');
    }
}
