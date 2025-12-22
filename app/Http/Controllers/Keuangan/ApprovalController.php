<?php

namespace App\Http\Controllers\Keuangan;

use App\Http\Controllers\Controller;
use App\Models\Payroll; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ApprovalController extends Controller
{
    public function index(Request $request)
    {
        $bulan = (int) $request->input('bulan', now()->month); 
        $tahun = (int) $request->input('tahun', now()->year);
        
        $status = $request->input('status', 'pending');

        $query = Payroll::with('employee:id,nama_lengkap,nik', 'generatedBy:id,name') 
                        ->where('bulan', $bulan)
                        ->where('tahun', $tahun);

        if ($status) {
            $query->where('status', $status);
        }

        $payrolls = $query->orderBy('created_at', 'desc')->paginate(25);

        return view('keuangan.approval.index', compact('payrolls', 'bulan', 'tahun', 'status'));
    }

    public function show(Payroll $payroll)
    {
        $payroll->load(['employee.jabatan', 'employee.divisi', 'details', 'generatedBy']);

        return view('keuangan.approval.show', compact('payroll'));
    }

    public function approve(Payroll $payroll)
    {
        if (!in_array($payroll->status, ['pending', 'rejected'])) {
            return redirect()->route('keuangan.approval.index')
                             ->with('error', 'Gaji ini sudah diproses dan tidak bisa disetujui lagi.');
        }

        $payroll->update([
            'status' => 'approved_finance',
            'finance_approved_by' => Auth::id(), 
            'finance_approved_at' => now(), 
            'catatan_revisi' => null 
        ]);

        return redirect()->route('keuangan.approval.index')
                         ->with('success', "Payroll untuk {$payroll->employee->nama_lengkap} berhasil disetujui.");
    }

    public function reject(Request $request, Payroll $payroll)
    {
        $request->validate([
            'catatan_revisi' => 'required|string|max:1000'
        ], [
            'catatan_revisi.required' => 'Anda harus memberikan alasan penolakan.'
        ]);

        if ($payroll->status !== 'pending') {
            return redirect()->route('keuangan.approval.index')
                             ->with('error', 'Gaji ini sudah diproses dan tidak bisa ditolak.');
        }

        $payroll->update([
            'status' => 'rejected',
            'finance_approved_by' => null,
            'finance_approved_at' => null,
            'catatan_revisi' => $request->catatan_revisi 
        ]);

        return redirect()->route('keuangan.approval.index')
                         ->with('warning', "Payroll untuk {$payroll->employee->nama_lengkap} telah ditolak.");
    }
}