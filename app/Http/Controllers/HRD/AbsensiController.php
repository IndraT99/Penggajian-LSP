<?php

namespace App\Http\Controllers\HRD;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Employee; 
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AbsensiController extends Controller
{
    public function index(Request $request)
    {
        $bulan = $request->input('bulan', now()->month);
        $tahun = $request->input('tahun', now()->year);

        $query = Attendance::with('employee')
                           ->whereYear('tanggal', $tahun)
                           ->whereMonth('tanggal', $bulan);
        
        if ($request->filled('employee_id')) {
            $query->where('employee_id', $request->employee_id);
        }

        $attendances = $query->latest('tanggal')->paginate(30);
        $employees = Employee::orderBy('nama_lengkap')->get(); 

        return view('hrd.absensi.index', compact('attendances', 'employees', 'bulan', 'tahun'));
    }

    public function create()
    {
        $employees = Employee::orderBy('nama_lengkap')->get();
        return view('hrd.absensi.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'tanggal' => [
                'required',
                'date',
                Rule::unique('attendances')->where(function ($query) use ($request) {
                    return $query->where('employee_id', $request->employee_id);
                })
            ],
            'jam_masuk' => 'nullable|date_format:H:i',
            'jam_pulang' => 'nullable|date_format:H:i|after_or_equal:jam_masuk',
            'status' => ['required', Rule::in(['hadir', 'sakit', 'izin', 'alpa', 'cuti'])],
            'keterangan' => 'nullable|string',
        ], [
            'tanggal.unique' => 'Karyawan ini sudah memiliki data absensi pada tanggal tersebut.'
        ]);

        Attendance::create($validatedData);

        return redirect()->route('hrd.absensi.index')
                         ->with('success', 'Data absensi berhasil ditambahkan.');
    }

    public function show(Attendance $absensi)
    {
        return redirect()->route('hrd.absensi.edit', $absensi);
    }

    public function edit(Attendance $absensi)
    {
        $employees = Employee::orderBy('nama_lengkap')->get();
        return view('hrd.absensi.edit', compact('absensi', 'employees'));
    }

    public function update(Request $request, Attendance $absensi)
    {
        $validatedData = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'tanggal' => [
                'required',
                'date',
                Rule::unique('attendances')->where(function ($query) use ($request) {
                    return $query->where('employee_id', $request->employee_id);
                })->ignore($absensi->id)
            ],
            'jam_masuk' => 'nullable|date_format:H:i',
            'jam_pulang' => 'nullable|date_format:H:i|after_or_equal:jam_masuk',
            'status' => ['required', Rule::in(['hadir', 'sakit', 'izin', 'alpa', 'cuti'])],
            'keterangan' => 'nullable|string',
        ], [
            'tanggal.unique' => 'Karyawan ini sudah memiliki data absensi pada tanggal tersebut.'
        ]);

        $absensi->update($validatedData);

        return redirect()->route('hrd.absensi.index')
                         ->with('success', 'Data absensi berhasil diperbarui.');
    }

    public function destroy(Attendance $absensi)
    {
        $absensi->delete();

        return redirect()->route('hrd.absensi.index')
                         ->with('success', 'Data absensi berhasil dihapus.');
    }
}