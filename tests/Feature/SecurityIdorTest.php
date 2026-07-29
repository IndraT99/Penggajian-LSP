<?php

namespace Tests\Feature;

use App\Models\Employee;
use App\Models\Payroll;
use App\Models\Role;
use App\Models\User;
use App\Models\Jabatan;
use App\Models\Divisi;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SecurityIdorTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_cannot_access_other_employee_pdf_slip()
    {
        $role = Role::create(['name' => 'Karyawan', 'slug' => 'karyawan']);

        $jabatan = Jabatan::create(['nama_jabatan' => 'Staff', 'gaji_pokok' => 1000, 'tunjangan_jabatan' => 0]);
        $divisi = Divisi::create(['nama_divisi' => 'IT']);

        $user1 = User::create(['name' => 'User1', 'email' => 'user1@test.com', 'password' => bcrypt('password')]);
        $user1->roles()->attach($role);
        $employee1 = Employee::create(['user_id' => $user1->id, 'nama_lengkap' => 'Emp 1', 'nik' => '111', 'email' => 'user1@test.com', 'jenis_kelamin' => 'L', 'status_karyawan' => 'aktif', 'tanggal_bergabung' => now(), 'jabatan_id' => $jabatan->id, 'divisi_id' => $divisi->id, 'no_telepon' => '123456789', 'gaji_pokok' => 1000]);

        $user2 = User::create(['name' => 'User2', 'email' => 'user2@test.com', 'password' => bcrypt('password')]);
        $user2->roles()->attach($role);
        $employee2 = Employee::create(['user_id' => $user2->id, 'nama_lengkap' => 'Emp 2', 'nik' => '222', 'email' => 'user2@test.com', 'jenis_kelamin' => 'P', 'status_karyawan' => 'aktif', 'tanggal_bergabung' => now(), 'jabatan_id' => $jabatan->id, 'divisi_id' => $divisi->id, 'no_telepon' => '987654321', 'gaji_pokok' => 1000]);

        $payroll = Payroll::create([
            'employee_id' => $employee2->id,
            'bulan' => 1,
            'tahun' => 2024,
            'gaji_pokok' => 1000,
            'total_tunjangan' => 0,
            'total_potongan' => 0,
            'total_lembur' => 0,
            'gaji_kotor' => 1000,
            'gaji_bersih' => 1000,
            'status' => 'approved_finance',
            'generated_by' => $user1->id
        ]);

        $this->actingAs($user1);

        $response = $this->get(route('karyawan.slip-gaji.pdf', $payroll));

        $response->assertStatus(403);
    }
}
