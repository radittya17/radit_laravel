<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Leave;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function dashboard(Request $request)
    {
        $user = $request->user();
        $month = now()->format('Y-m');
        $monthlyAttendances = Attendance::where('user_id', $user->id)
            ->where('date', 'like', "{$month}%")
            ->whereNotNull('time_in')
            ->get();

        return view('user.dashboard', [
            'attendanceToday' => Attendance::where('user_id', $user->id)->where('date', today()->toDateString())->first(),
            'attendances' => Attendance::where('user_id', $user->id)->latest('date')->limit(10)->get(),
            'leaves' => Leave::where('user_id', $user->id)->latest()->limit(10)->get(),
            'monthlyPresentCount' => $monthlyAttendances->whereIn('status', ['hadir', 'terlambat'])->count(),
            'monthlyLateCount' => $monthlyAttendances->where('status', 'terlambat')->count(),
        ]);
    }
}
