<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Employee;
use App\Models\Jabatan;
use App\Models\Divisi;
use App\Models\Payroll;
use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class KaryawanSlipGajiControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_cannot_access_other_user_pdf_slip()
    {
        $role = Role::create(['name' => 'Karyawan', 'slug' => 'karyawan']);
        $jabatan = Jabatan::create(['nama_jabatan' => 'Staff IT']);
        $divisi = Divisi::create(['nama_divisi' => 'Teknologi Informasi']);

        $user1 = User::factory()->create();
        $user1->roles()->attach($role);
        $employee1 = Employee::create([
            'user_id' => $user1->id,
            'nik' => '12345',
            'nama_lengkap' => 'Budi Santoso',
            'jabatan_id' => $jabatan->id,
            'divisi_id' => $divisi->id,
            'status_karyawan' => 'aktif',
            'gaji_pokok' => 5000000,
            'tanggal_bergabung' => now()->subYear(),
            'nama_bank' => 'BCA',
            'nomor_rekening' => '1234567890',
            'npwp' => '09.254.294.3-407.000',
            'ptkp_status' => 'TK/0'
        ]);

        $user2 = User::factory()->create();
        $user2->roles()->attach($role);
        $employee2 = Employee::create([
            'user_id' => $user2->id,
            'nik' => '67890',
            'nama_lengkap' => 'Andi Setiawan',
            'jabatan_id' => $jabatan->id,
            'divisi_id' => $divisi->id,
            'status_karyawan' => 'aktif',
            'gaji_pokok' => 5000000,
            'tanggal_bergabung' => now()->subYear(),
            'nama_bank' => 'BCA',
            'nomor_rekening' => '1234567890',
            'npwp' => '09.254.294.3-407.000',
            'ptkp_status' => 'TK/0'
        ]);

        $payroll = Payroll::create([
            'employee_id' => $employee2->id,
            'bulan' => '01',
            'tahun' => '2023',
            'status' => 'approved_finance',
            'gaji_pokok' => 5000000,
            'gaji_bersih' => 5000000,
            'total_tunjangan' => 0,
            'total_potongan' => 0,
            'gaji_kotor' => 5000000,
            'generated_by' => $user1->id,
        ]);

        $this->actingAs($user1);

        $response = $this->get(route('karyawan.slip-gaji.pdf', $payroll->getRouteKey()));

        $response->assertStatus(403);
    }

    public function test_user_cannot_access_unapproved_pdf_slip()
    {
        $role = Role::create(['name' => 'Karyawan', 'slug' => 'karyawan']);
        $jabatan = Jabatan::create(['nama_jabatan' => 'Staff IT']);
        $divisi = Divisi::create(['nama_divisi' => 'Teknologi Informasi']);

        $user = User::factory()->create();
        $user->roles()->attach($role);
        $employee = Employee::create([
            'user_id' => $user->id,
            'nik' => '12345',
            'nama_lengkap' => 'Budi Santoso',
            'jabatan_id' => $jabatan->id,
            'divisi_id' => $divisi->id,
            'status_karyawan' => 'aktif',
            'gaji_pokok' => 5000000,
            'tanggal_bergabung' => now()->subYear(),
            'nama_bank' => 'BCA',
            'nomor_rekening' => '1234567890',
            'npwp' => '09.254.294.3-407.000',
            'ptkp_status' => 'TK/0'
        ]);

        $payroll = Payroll::create([
            'employee_id' => $employee->id,
            'bulan' => '01',
            'tahun' => '2023',
            'status' => 'pending',
            'gaji_pokok' => 5000000,
            'gaji_bersih' => 5000000,
            'total_tunjangan' => 0,
            'total_potongan' => 0,
            'gaji_kotor' => 5000000,
            'generated_by' => $user->id,
        ]);

        $this->actingAs($user);

        $response = $this->get(route('karyawan.slip-gaji.pdf', $payroll->getRouteKey()));

        $response->assertStatus(404);
    }

    public function test_user_can_access_own_approved_pdf_slip()
    {
        $role = Role::create(['name' => 'Karyawan', 'slug' => 'karyawan']);
        $jabatan = Jabatan::create(['nama_jabatan' => 'Staff IT']);
        $divisi = Divisi::create(['nama_divisi' => 'Teknologi Informasi']);

        $user = User::factory()->create();
        $user->roles()->attach($role);
        $employee = Employee::create([
            'user_id' => $user->id,
            'nik' => '12345',
            'nama_lengkap' => 'Budi Santoso',
            'jabatan_id' => $jabatan->id,
            'divisi_id' => $divisi->id,
            'status_karyawan' => 'aktif',
            'gaji_pokok' => 5000000,
            'tanggal_bergabung' => now()->subYear(),
            'nama_bank' => 'BCA',
            'nomor_rekening' => '1234567890',
            'npwp' => '09.254.294.3-407.000',
            'ptkp_status' => 'TK/0'
        ]);

        $payroll = Payroll::create([
            'employee_id' => $employee->id,
            'bulan' => '01',
            'tahun' => '2023',
            'status' => 'approved_finance',
            'gaji_pokok' => 5000000,
            'gaji_bersih' => 5000000,
            'total_tunjangan' => 0,
            'total_potongan' => 0,
            'gaji_kotor' => 5000000,
            'generated_by' => $user->id,
        ]);

        $this->actingAs($user);

        $response = $this->get(route('karyawan.slip-gaji.pdf', $payroll->getRouteKey()));

        $response->assertStatus(200);
    }
}
