<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use DatabaseTransactions;

    public function test_a_visitor_can_register_as_an_employee(): void
    {
        $email = 'pendaftaran-'.uniqid().'@example.test';

        $response = $this->post(route('register.store'), [
            'name' => 'Pengguna Baru',
            'email' => $email,
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect(route('karyawan.dashboard'));
        $this->assertAuthenticated();
        $this->assertDatabaseHas('users', [
            'email' => $email,
            'role' => 'karyawan',
        ]);
    }

    public function test_an_admin_can_export_the_monthly_attendance_report(): void
    {
        $admin = User::create([
            'name' => 'Administrator Laporan',
            'email' => 'laporan-'.uniqid().'@example.test',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        $this->actingAs($admin)
            ->get(route('admin.reports.export', ['month' => '2026-09']))
            ->assertOk()
            ->assertHeader('content-disposition', 'attachment; filename=laporan-kehadiran-2026-09.csv');
    }

    public function test_an_admin_can_export_the_monthly_attendance_report_as_pdf(): void
    {
        $admin = User::create([
            'name' => 'Administrator PDF',
            'email' => 'laporan-pdf-'.uniqid().'@example.test',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        $this->actingAs($admin)
            ->get(route('admin.reports.export-pdf', ['month' => '2026-09']))
            ->assertOk()
            ->assertHeader('content-type', 'application/pdf')
            ->assertHeader('content-disposition', 'attachment; filename="laporan-kehadiran-2026-09.pdf"');
    }
}
