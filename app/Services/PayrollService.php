<?php

namespace App\Services;

use App\Models\Employee;
use App\Models\Payroll;
use Illuminate\Support\Facades\DB;

class PayrollService
{
    public function generateForEmployee(Employee $employee, string $bulan, string $tahun, int $generatorUserId): Payroll
    {
        $existing = Payroll::where('employee_id', $employee->id)
            ->where('bulan', $bulan)->where('tahun', $tahun)->first();

        if ($existing && $existing->status !== 'pending') {
             throw new \Exception("Payroll {$employee->nama_lengkap} periode {$bulan}-{$tahun} sudah diproses.");
        }

        return DB::transaction(function () use ($employee, $bulan, $tahun, $generatorUserId) {
            $allowances = $employee->components()->where('tipe', 'allowance')->get()
                ->map(fn($c) => ['nama_komponen' => $c->nama_komponen, 'tipe' => 'allowance', 'jumlah' => $c->pivot->jumlah]);

            $deductions = $employee->components()->where('tipe', 'deduction')->get()
                ->map(fn($c) => ['nama_komponen' => $c->nama_komponen, 'tipe' => 'deduction', 'jumlah' => $c->pivot->jumlah]);

            $lemburTotal = $employee->overtimes()->where('status', 'approved_hrd')
                ->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun)
                ->sum('biaya_lembur');

            $gajiPokok = $employee->gaji_pokok;
            $totalTunjangan = $allowances->sum('jumlah');
            $totalPotongan = $deductions->sum('jumlah');
            $gajiKotor = $gajiPokok + $totalTunjangan + $lemburTotal;

            $payroll = Payroll::updateOrCreate(
                ['employee_id' => $employee->id, 'bulan' => $bulan, 'tahun' => $tahun],
                [
                    'gaji_pokok'      => $gajiPokok,
                    'total_tunjangan' => $totalTunjangan,
                    'total_potongan'  => $totalPotongan,
                    'total_lembur'    => $lemburTotal,
                    'gaji_kotor'      => $gajiKotor,
                    'gaji_bersih'     => $gajiKotor - $totalPotongan,
                    'status'          => 'pending',
                    'generated_by'    => $generatorUserId,
                ]
            );

            $allDetails = collect([['nama_komponen' => 'Gaji Pokok', 'tipe' => 'allowance', 'jumlah' => $gajiPokok]])
                ->merge($allowances)
                ->merge($deductions)
                ->when($lemburTotal > 0, fn($col) => $col->push(['nama_komponen' => 'Lembur', 'tipe' => 'overtime', 'jumlah' => $lemburTotal]));

            $payroll->details()->delete();
            $payroll->details()->createMany($allDetails->toArray());

            return $payroll;
        });
    }
}