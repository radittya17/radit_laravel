<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function recordEntry(Request $request)
    {
        $now = now();
        $today = $now->toDateString();
        $attendance = Attendance::where('user_id', $request->user()->id)->where('date', $today)->first();

        if ($attendance?->time_in) {
            return back()->with('info', 'Absensi masuk Anda hari ini sudah tercatat.');
        }

        Attendance::updateOrCreate(
            ['user_id' => $request->user()->id, 'date' => $today],
            ['time_in' => $now->format('H:i:s'), 'status' => $now->format('H:i') > '08:00' ? 'terlambat' : 'hadir']
        );

        return back()->with('success', 'Absensi masuk berhasil dicatat pada '.$now->format('H:i').' WIB.');
    }
}
