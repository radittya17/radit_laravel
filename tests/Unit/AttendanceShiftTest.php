<?php

namespace Tests\Unit;

use App\Models\Attendance;
use PHPUnit\Framework\TestCase;

class AttendanceShiftTest extends TestCase
{
    public function test_shift_is_determined_by_attendance_time(): void
    {
        $times = [
            '06:59:59' => 'shift_3',
            '07:00:00' => 'shift_1',
            '14:59:59' => 'shift_1',
            '15:00:00' => 'shift_2',
            '21:59:59' => 'shift_2',
            '22:00:00' => 'shift_3',
            '00:00:00' => 'shift_3',
        ];

        foreach ($times as $time => $expectedShift) {
            $this->assertSame($expectedShift, Attendance::shiftForTime($time)['key']);
        }

        $this->assertNull(Attendance::shiftForTime(null));
    }
}