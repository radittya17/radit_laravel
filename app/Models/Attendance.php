<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    public static function shiftDefinitions(): array
    {
        return [
            ['key' => 'shift_1', 'name' => 'Shift 1', 'hours' => '07.00–17.00', 'icon' => 'bi-sunrise-fill'],
            ['key' => 'shift_2', 'name' => 'Shift 2', 'hours' => '15.00–00.00', 'icon' => 'bi-sunset-fill'],
            ['key' => 'shift_3', 'name' => 'Shift 3', 'hours' => '22.00–07.00', 'icon' => 'bi-moon-stars-fill'],
        ];
    }

    public static function shiftForTime(?string $time): ?array
    {
        if (! $time) {
            return null;
        }

        $time = substr($time, 0, 5);
        $shiftKey = $time >= '22:00' || $time < '07:00'
            ? 'shift_3'
            : ($time >= '15:00' ? 'shift_2' : 'shift_1');

        return collect(self::shiftDefinitions())->firstWhere('key', $shiftKey);
    }

    public function getShiftAttribute(): ?array
    {
        return self::shiftForTime($this->time_in);
    }

    protected $casts = [
        'date' => 'date',
    ];

    protected $fillable = [
        'user_id',
        'date',
        'time_in',
        'status',
        'notes',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
