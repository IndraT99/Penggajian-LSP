<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use App\Models\Employee;
use App\Models\Jabatan;
use App\Models\Divisi;

use App\Models\Leave;
use App\Models\Overtime;
use App\Models\Payroll;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->hasRole('admin')) {
            $stats = [
                'total_users' => User::count(),
                'total_employees' => Employee::count(),
                'total_jabatans' => Jabatan::count(),
                'total_divisis' => Divisi::count(),
            ];
            return view('admin.dashboard', compact('stats'));

        } elseif ($user->hasRole('staff_hrd')) {
            $stats = [
                'total_karyawan_aktif' => Employee::where('status_karyawan', 'aktif')->count(),
                'pending_cuti' => Leave::where('status', 'pending')->count(),
                'pending_lembur' => Overtime::where('status', 'pending')->count(),
                'pending_payroll' => Payroll::where('status', 'pending')->count(),
            ];
            return view('hrd.dashboard', compact('stats'));

        } elseif ($user->hasRole('staff_keuangan')) {
            $stats = [
                'pending_approval' => Payroll::where('status', 'pending')->count(),
                
                'approved_this_month' => Payroll::where('status', 'approved_finance')
                                                ->whereMonth('finance_approved_at', now()->month)
                                                ->whereYear('finance_approved_at', now()->year)
                                                ->count(),
                                                
                'rejected_this_month' => Payroll::where('status', 'rejected')
                                                ->whereMonth('updated_at', now()->month) 
                                                ->whereYear('updated_at', now()->year)
                                                ->count(),
                                                
                'total_approved_amount' => Payroll::where('status', 'approved_finance')
                                                  ->where('bulan', now()->format('m')) 
                                                  ->where('tahun', now()->year)
                                                  ->sum('gaji_bersih'),
            ];
            return view('keuangan.dashboard', compact('stats'));

        } elseif ($user->hasRole('owner')) {
            $currentMonth = now()->month;
            $currentYear = now()->year; 

            $aggregates = Payroll::where('bulan', $currentMonth)
                                 ->where('tahun', $currentYear)
                                 ->whereIn('status', ['approved_finance', 'paid'])
                                 ->selectRaw("
                                     SUM(gaji_bersih) as total_gaji_bersih,
                                     SUM(gaji_kotor) as total_gaji_kotor,
                                     SUM(total_lembur) as total_lembur,
                                     COUNT(id) as total_karyawan_paid
                                 ")
                                 ->first();
            
            $stats = [
                'total_gaji_bersih' => $aggregates->total_gaji_bersih ?? 0,
                'total_gaji_kotor' => $aggregates->total_gaji_kotor ?? 0,
                'total_lembur' => $aggregates->total_lembur ?? 0,
                'total_karyawan_paid' => $aggregates->total_karyawan_paid ?? 0,
            ];
            
            return view('owner.dashboard', compact('stats'));

            
        } elseif ($user->hasRole('karyawan')) {
            
            $employee = Auth::user()->employee;
            if (!$employee) {
                Auth::logout();
                return redirect()->route('login')->with('error', 'Akun Anda tidak terhubung dengan data karyawan.');
            }
            
            $stats = [
                'total_slips' => Payroll::where('employee_id', $employee->id)
                                        ->whereIn('status', ['approved_finance', 'paid'])
                                        ->count(),
                'pending_cuti' => Leave::where('employee_id', $employee->id)
                                       ->where('status', 'pending')
                                       ->count(),
                'pending_lembur' => Overtime::where('employee_id', $employee->id)
                                            ->where('status', 'pending')
                                            ->count(),
                'total_komponen' => $employee->components()->count(),
            ];

            return view('karyawan.dashboard', compact('employee', 'stats'));

        }

        Auth::logout();
        return redirect()->route('login')->with('error', 'Role Anda tidak terdefinisi.');
    }
}