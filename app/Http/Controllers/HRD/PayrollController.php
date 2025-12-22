<?php

namespace App\Http\Controllers\HRD;

use App\Http\Controllers\Controller;
use App\Models\Payroll;
use App\Models\Employee;
use App\Services\PayrollService; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\Log; 
class PayrollController extends Controller
{
    protected $payrollService;

    public function __construct(PayrollService $payrollService)
    {
        $this->payrollService = $payrollService;
    }

    public function index(Request $request)
    {
        $bulan = (int) $request->input('bulan', now()->month); 
        $tahun = (int) $request->input('tahun', now()->year);
        $status = $request->input('status');

        $query = Payroll::with('employee:id,nama_lengkap,nik') 
                        ->where('bulan', $bulan)
                        ->where('tahun', $tahun);

        if ($status) {
            $query->where('status', $status);
        }

        $payrolls = $query->orderBy('status')->orderBy('created_at', 'desc')->paginate(25);

        return view('hrd.payroll.index', compact('payrolls', 'bulan', 'tahun', 'status'));
    }

    public function showGenerateForm()
    {
        $years = range(now()->year + 1, now()->year - 3);
        
        return view('hrd.payroll.generate', compact('years'));
    }

    public function storeGenerate(Request $request)
    {
        $validated = $request->validate([
            'bulan' => 'required|digits:2',
            'tahun' => 'required|digits:4',
        ]);

        $bulan = $validated['bulan'];
        $tahun = $validated['tahun'];
        $generatorUserId = Auth::id();

        $employees = Employee::where('status_karyawan', 'aktif')->get();

        $generatedCount = 0;
        $errorCount = 0;
        $errors = [];

        foreach ($employees as $employee) {
            try {
                $this->payrollService->generateForEmployee($employee, $bulan, $tahun, $generatorUserId);
                $generatedCount++;
            } catch (\Exception $e) {
                $errorCount++;
                $errors[] = "Gagal generate untuk {$employee->nama_lengkap}: " . $e->getMessage();
                Log::error("Payroll Generation Failed for Employee ID {$employee->id}: " . $e->getMessage());
            }
        }

        $message = "Payroll berhasil digenerate untuk {$generatedCount} karyawan (Bulan: {$bulan}-{$tahun}).";
        if ($errorCount > 0) {
            $message .= " Gagal generate untuk {$errorCount} karyawan.";
            session()->flash('payroll_errors', $errors);
        }

        return redirect()->route('hrd.payroll.index', ['bulan' => $bulan, 'tahun' => $tahun])
                         ->with('success', $message);
    }

    public function showSlip(Payroll $payroll)
    {
        $payroll->load(['employee.jabatan', 'employee.divisi', 'details']);

        return view('hrd.payroll.slip', compact('payroll'));
    }
}