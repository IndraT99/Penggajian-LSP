<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use App\Models\Overtime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use Carbon\Carbon; 

class PengajuanLemburController extends Controller
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

        $overtimes = Overtime::where('employee_id', $employee->id)
                             ->latest('tanggal') 
                             ->paginate(10);
        
        return view('karyawan.pengajuan-lembur.index', compact('overtimes'));
    }

    public function create()
    {
        $employee = $this->getAuthenticatedEmployee();
        return view('karyawan.pengajuan-lembur.create', compact('employee'));
    }

    public function store(Request $request)
    {
        $employee = $this->getAuthenticatedEmployee();

        $validatedData = $request->validate([
            'tanggal' => 'required|date',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            'alasan_lembur' => 'required|string|max:1000',
        ]);

        $jamMulai = new Carbon($validatedData['jam_mulai']);
        $jamSelesai = new Carbon($validatedData['jam_selesai']);
        $totalJam = $jamMulai->diffInHours($jamSelesai);

        Overtime::create([
            'employee_id' => $employee->id, 
            'tanggal' => $validatedData['tanggal'],
            'jam_mulai' => $validatedData['jam_mulai'],
            'jam_selesai' => $validatedData['jam_selesai'],
            'alasan_lembur' => $validatedData['alasan_lembur'],
            'total_jam' => $totalJam,
            'biaya_lembur' => 0, 
            'status' => 'pending',
        ]);

        return redirect()->route('karyawan.pengajuan-lembur.index')
                         ->with('success', 'Pengajuan lembur Anda berhasil dikirim dan menunggu persetujuan HRD.');
    }

    public function show(Overtime $pengajuan_lembur)
    {
        $employee = $this->getAuthenticatedEmployee();

        if ($pengajuan_lembur->employee_id !== $employee->id) {
            abort(403, 'Anda tidak memiliki izin untuk melihat pengajuan ini.');
        }

        return view('karyawan.pengajuan-lembur.show', compact('pengajuan_lembur'));
    }

    public function edit(Overtime $pengajuan_lembur)
    {
        $employee = $this->getAuthenticatedEmployee();

        if ($pengajuan_lembur->employee_id !== $employee->id) {
            abort(403);
        }
        if ($pengajuan_lembur->status !== 'pending') {
            return redirect()->route('karyawan.pengajuan-lembur.index')
                             ->with('error', 'Pengajuan yang sudah diproses (disetujui/ditolak) tidak dapat diubah lagi.');
        }

        return view('karyawan.pengajuan-lembur.edit', compact('pengajuan_lembur'));
    }

    public function update(Request $request, Overtime $pengajuan_lembur)
    {
        $employee = $this->getAuthenticatedEmployee();

        if ($pengajuan_lembur->employee_id !== $employee->id) {
            abort(403);
        }
        if ($pengajuan_lembur->status !== 'pending') {
            return redirect()->route('karyawan.pengajuan-lembur.index')
                             ->with('error', 'Pengajuan yang sudah diproses tidak dapat diubah.');
        }

        $validatedData = $request->validate([
            'tanggal' => 'required|date',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            'alasan_lembur' => 'required|string|max:1000',
        ]);

        $jamMulai = new Carbon($validatedData['jam_mulai']);
        $jamSelesai = new Carbon($validatedData['jam_selesai']);
        $totalJam = $jamMulai->diffInHours($jamSelesai);

        $pengajuan_lembur->update([
            'tanggal' => $validatedData['tanggal'],
            'jam_mulai' => $validatedData['jam_mulai'],
            'jam_selesai' => $validatedData['jam_selesai'],
            'alasan_lembur' => $validatedData['alasan_lembur'],
            'total_jam' => $totalJam,
        ]);

        return redirect()->route('karyawan.pengajuan-lembur.index')
                         ->with('success', 'Pengajuan lembur Anda berhasil diperbarui.');
    }

    public function destroy(Overtime $pengajuan_lembur)
    {
        $employee = $this->getAuthenticatedEmployee();

        if ($pengajuan_lembur->employee_id !== $employee->id) {
            abort(403);
        }
        if ($pengajuan_lembur->status !== 'pending') {
            return redirect()->route('karyawan.pengajuan-lembur.index')
                             ->with('error', 'Pengajuan yang sudah diproses tidak dapat dibatalkan.');
        }

        $pengajuan_lembur->delete();

        return redirect()->route('karyawan.pengajuan-lembur.index')
                         ->with('success', 'Pengajuan lembur Anda berhasil dibatalkan.');
    }
}