<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Employee;
use App\Models\Jabatan;
use App\Models\Divisi;
use App\Models\Payroll;
use App\Models\PayrollComponent;
use App\Services\PayrollService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PayrollGenerationTest extends TestCase
{
    use RefreshDatabase;

    public function test_hrd_can_generate_payroll_for_employee()
    {
        // 1. Setup Data Master
        $user = User::factory()->create();
        $hrd = User::factory()->create();
        $this->actingAs($hrd); // Asumsi middleware auth

        $jabatan = Jabatan::create(['nama_jabatan' => 'Staff IT', 'gaji_pokok_default' => 5000000]);
        $divisi = Divisi::create(['nama_divisi' => 'Teknologi Informasi']);

        // 2. Setup Components
        $tunjanganMakan = PayrollComponent::create([
            'nama_komponen' => 'Tunjangan Makan',
            'tipe' => 'allowance',
            'jumlah_default' => 500000,
            'is_taxable' => false
        ]);

        $potonganKoperasi = PayrollComponent::create([
            'nama_komponen' => 'Koperasi',
            'tipe' => 'deduction',
            'jumlah_default' => 100000,
            'is_taxable' => false
        ]);

        // 3. Create Employee
        $employee = Employee::create([
            'nik' => '12345',
            'nama_lengkap' => 'Budi Santoso',
            'jabatan_id' => $jabatan->id,
            'divisi_id' => $divisi->id,
            'gaji_pokok' => 5000000,
            'tanggal_bergabung' => now()->subYear(),
            'status_karyawan' => 'aktif',
            // New fields validation check
            'nama_bank' => 'BCA',
            'nomor_rekening' => '1234567890',
            'npwp' => '09.254.294.3-407.000',
            'ptkp_status' => 'TK/0'
        ]);

        // Attach components
        $employee->components()->attach([
            $tunjanganMakan->id => ['jumlah' => 500000],
            $potonganKoperasi->id => ['jumlah' => 100000]
        ]);

        // 4. Run Service
        $payrollService = new PayrollService();
        $bulan = now()->format('m');
        $tahun = now()->format('Y');

        $payroll = $payrollService->generateForEmployee($employee, $bulan, $tahun, $hrd->id);

        // 5. Assertions
        $this->assertDatabaseHas('payrolls', [
            'employee_id' => $employee->id,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'gaji_pokok' => 5000000.00,
            'total_tunjangan' => 500000.00,
            'total_potongan' => 100000.00,
            'gaji_bersih' => 5400000.00, // 5jt + 500k - 100k
            'status' => 'pending'
        ]);

        $this->assertDatabaseHas('payroll_details', [
            'payroll_id' => $payroll->id,
            'nama_komponen' => 'Tunjangan Makan',
            'jumlah' => 500000.00
        ]);

        $this->assertDatabaseHas('payroll_details', [
            'payroll_id' => $payroll->id,
            'nama_komponen' => 'Koperasi',
            'jumlah' => 100000.00
        ]);
    }
}
