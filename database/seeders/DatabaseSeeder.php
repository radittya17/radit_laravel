<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Attendance;
use App\Models\Leave;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin user
        $admin = User::updateOrCreate(['email' => 'admin@absensi.com'], [
            'name' => 'Administrator HRD',
            'email' => 'admin@absensi.com',
            'nip' => 'ADM-001',
            'jabatan' => 'HR Manager',
            'phone' => '081234567890',
            'role' => 'admin',
            'password' => Hash::make('password123'),
        ]);

        // Sample Karyawan users
        $karyawan1 = User::updateOrCreate(['email' => 'karyawan@absensi.com'], [
            'name' => 'Budi Santoso',
            'email' => 'karyawan@absensi.com',
            'nip' => 'EMP-101',
            'jabatan' => 'Software Engineer',
            'phone' => '082198765432',
            'role' => 'karyawan',
            'password' => Hash::make('password123'),
        ]);

        $karyawan2 = User::updateOrCreate(['email' => 'siti@absensi.com'], [
            'name' => 'Siti Rahma',
            'email' => 'siti@absensi.com',
            'nip' => 'EMP-102',
            'jabatan' => 'UI/UX Designer',
            'phone' => '085712345678',
            'role' => 'karyawan',
            'password' => Hash::make('password123'),
        ]);

        // Attendance history seed
        for ($i = 5; $i >= 1; $i--) {
            $date = Carbon::now()->subDays($i)->format('Y-m-d');
            Attendance::updateOrCreate(['user_id' => $karyawan1->id, 'date' => $date], [
                'user_id' => $karyawan1->id,
                'date' => $date,
                'time_in' => '07:55:00',
                'status' => 'hadir',
                'notes' => 'Hadir tepat waktu',
            ]);

            Attendance::updateOrCreate(['user_id' => $karyawan2->id, 'date' => $date], [
                'user_id' => $karyawan2->id,
                'date' => $date,
                'time_in' => '08:15:00',
                'status' => 'terlambat',
                'notes' => 'Macet lalu lintas',
            ]);
        }

        // Leave request seed
        Leave::firstOrCreate([
            'user_id' => $karyawan2->id,
            'type' => 'izin',
            'start_date' => Carbon::now()->addDays(2)->format('Y-m-d'),
        ], [
            'end_date' => Carbon::now()->addDays(3)->format('Y-m-d'),
            'reason' => 'Urusan keluarga mendadak',
            'status' => 'pending',
        ]);
    }
}
