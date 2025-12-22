<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use App\Models\Leave;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon; 

class PengajuanCutiController extends Controller
{
    private function getAuthenticatedEmployee()
    {
        $employee = Auth::user()->employee;
        if (!$employee) {
            abort(403, 'Akun Anda tidak terhubung dengan data karyawan.');
        }
        return $employee;
    }

    public function index()
    {
        $employee = $this->getAuthenticatedEmployee();
        $leaves = Leave::where('employee_id', $employee->id)
                       ->latest('tanggal_mulai') 
                       ->paginate(10);
        
        return view('karyawan.pengajuan-cuti.index', compact('leaves'));
    }

    public function create()
    {
       
        $employee = $this->getAuthenticatedEmployee();
        return view('karyawan.pengajuan-cuti.create', compact('employee'));
    }

    public function store(Request $request)
    {
        $employee = $this->getAuthenticatedEmployee();

        $validatedData = $request->validate([
            'tanggal_mulai' => 'required|date|after_or_equal:today',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'alasan' => 'required|string|max:1000',
        ], [
            'tanggal_mulai.after_or_equal' => 'Tanggal mulai tidak boleh tanggal yang sudah lewat.'
        ]);

        $tanggalMulai = new Carbon($validatedData['tanggal_mulai']);
        $tanggalSelesai = new Carbon($validatedData['tanggal_selesai']);
        $totalHari = $tanggalMulai->diffInDays($tanggalSelesai) + 1;

        Leave::create([
            'employee_id' => $employee->id, 
            'tanggal_mulai' => $validatedData['tanggal_mulai'],
            'tanggal_selesai' => $validatedData['tanggal_selesai'],
            'alasan' => $validatedData['alasan'],
            'total_hari' => $totalHari,
            'status' => 'pending', 
        ]);

        return redirect()->route('karyawan.pengajuan-cuti.index')
                         ->with('success', 'Pengajuan cuti Anda berhasil dikirim dan menunggu persetujuan HRD.');
    }

    public function show(Leave $pengajuan_cuti)
    {
        $employee = $this->getAuthenticatedEmployee();

        if ($pengajuan_cuti->employee_id !== $employee->id) {
            abort(403, 'Anda tidak memiliki izin untuk melihat pengajuan ini.');
        }

        return view('karyawan.pengajuan-cuti.show', compact('pengajuan_cuti'));
    }

    public function edit(Leave $pengajuan_cuti)
    {
        $employee = $this->getAuthenticatedEmployee();

        if ($pengajuan_cuti->employee_id !== $employee->id) {
            abort(403);
        }

        if ($pengajuan_cuti->status !== 'pending') {
            return redirect()->route('karyawan.pengajuan-cuti.index')
                             ->with('error', 'Pengajuan yang sudah diproses (disetujui/ditolak) tidak dapat diubah lagi.');
        }

        return view('karyawan.pengajuan-cuti.edit', compact('pengajuan_cuti'));
    }

    public function update(Request $request, Leave $pengajuan_cuti)
    {
        $employee = $this->getAuthenticatedEmployee();

        if ($pengajuan_cuti->employee_id !== $employee->id) {
            abort(403);
        }
        if ($pengajuan_cuti->status !== 'pending') {
            return redirect()->route('karyawan.pengajuan-cuti.index')
                             ->with('error', 'Pengajuan yang sudah diproses tidak dapat diubah.');
        }

        $validatedData = $request->validate([
            'tanggal_mulai' => 'required|date|after_or_equal:today',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'alasan' => 'required|string|max:1000',
        ]);

        $tanggalMulai = new Carbon($validatedData['tanggal_mulai']);
        $tanggalSelesai = new Carbon($validatedData['tanggal_selesai']);
        $totalHari = $tanggalMulai->diffInDays($tanggalSelesai) + 1;

        $pengajuan_cuti->update([
            'tanggal_mulai' => $validatedData['tanggal_mulai'],
            'tanggal_selesai' => $validatedData['tanggal_selesai'],
            'alasan' => $validatedData['alasan'],
            'total_hari' => $totalHari,
        ]);

        return redirect()->route('karyawan.pengajuan-cuti.index')
                         ->with('success', 'Pengajuan cuti Anda berhasil diperbarui.');
    }

    public function destroy(Leave $pengajuan_cuti)
    {
        $employee = $this->getAuthenticatedEmployee();

        if ($pengajuan_cuti->employee_id !== $employee->id) {
            abort(403);
        }
        if ($pengajuan_cuti->status !== 'pending') {
            return redirect()->route('karyawan.pengajuan-cuti.index')
                             ->with('error', 'Pengajuan yang sudah diproses tidak dapat dibatalkan.');
        }
        $pengajuan_cuti->delete();

        return redirect()->route('karyawan.pengajuan-cuti.index')
                         ->with('success', 'Pengajuan cuti Anda berhasil dibatalkan.');
    }
}