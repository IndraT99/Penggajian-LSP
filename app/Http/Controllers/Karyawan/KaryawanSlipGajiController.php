<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use App\Models\Payroll;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use Barryvdh\DomPDF\Facade\Pdf;

class KaryawanSlipGajiController extends Controller
{
    private function getAuthenticatedEmployee()
    {
        $employee = Auth::user()->employee;

        if (!$employee) {
            abort(403, 'Akun Anda tidak terhubung dengan data karyawan.');
        }

        return $employee;
    }

    public function generatePDF(Payroll $payroll)
    {
        $employee = $this->getAuthenticatedEmployee();

        // Security Authorization Check: Prevent IDOR
        if ($payroll->employee_id !== $employee->id) {
            abort(403, 'Anda tidak memiliki izin untuk mengunduh slip gaji ini.');
        }

        // Security State Check: Only finalized payrolls can be downloaded
        if (!in_array($payroll->status, ['approved_finance', 'paid'])) {
             abort(404, 'Slip gaji ini belum final atau tidak tersedia.');
        }

        $pdf = Pdf::loadView('karyawan.slip-gaji.pdf', ['payroll' => $payroll]);

        $pdf->setPaper('A4', 'portrait');

        $namaFile = 'slip-gaji-' . $payroll->employee->nik . '-' . $payroll->bulan . '-' . $payroll->tahun . '.pdf';

        return $pdf->stream($namaFile);
        
    }

    public function index()
    {
        $employee = $this->getAuthenticatedEmployee();

        $payrolls = Payroll::where('employee_id', $employee->id)
                           ->whereIn('status', ['approved_finance', 'paid'])
                           ->latest('tahun') 
                           ->latest('bulan') 
                           ->paginate(12); 

        return view('karyawan.slip-gaji.index', compact('payrolls'));
    }

    public function show(Payroll $payroll)
    {
        $employee = $this->getAuthenticatedEmployee();

        if ($payroll->employee_id !== $employee->id) {
            abort(403, 'Anda tidak memiliki izin untuk melihat slip gaji ini.');
        }

        if (!in_array($payroll->status, ['approved_finance', 'paid'])) {
             abort(404, 'Slip gaji ini belum final atau tidak tersedia.');
        }

        $payroll->load(['employee.jabatan', 'employee.divisi', 'details']);

        return view('karyawan.slip-gaji.show', compact('payroll'));
    }

    public function komponen()
    {
        $employee = $this->getAuthenticatedEmployee();

        $employee->load('components');

        $allowances = $employee->components->where('tipe', 'allowance');
        $deductions = $employee->components->where('tipe', 'deduction');

        return view('karyawan.komponen.index', compact('employee', 'allowances', 'deductions'));
    }
}