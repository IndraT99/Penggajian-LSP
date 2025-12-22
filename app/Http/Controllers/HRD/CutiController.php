<?php

namespace App\Http\Controllers\HRD;

use App\Http\Controllers\Controller;
use App\Models\Leave;
use App\Models\Employee; 
use Illuminate\Http\Request;
use Illuminate\Validation\Rule; 
use Illuminate\Support\Facades\Auth; 
use Carbon\Carbon; 

class CutiController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->input('status');
        $bulan = $request->input('bulan', now()->month);
        $tahun = $request->input('tahun', now()->year);

        $query = Leave::with('employee')
                       ->whereYear('tanggal_mulai', $tahun)
                       ->whereMonth('tanggal_mulai', $bulan);
        
        if ($status) {
            $query->where('status', $status);
        }

        $leaves = $query->latest()->paginate(20);
        
        return view('hrd.cuti.index', compact('leaves', 'status', 'bulan', 'tahun'));
    }

    public function create()
    {
        $employees = Employee::orderBy('nama_lengkap')->get();
        return view('hrd.cuti.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'alasan' => 'required|string',
            'status' => ['required', Rule::in(['pending', 'approved_hrd', 'rejected'])],
        ]);

        $tanggalMulai = new Carbon($validatedData['tanggal_mulai']);
        $tanggalSelesai = new Carbon($validatedData['tanggal_selesai']);
        $totalHari = $tanggalMulai->diffInDays($tanggalSelesai) + 1;

        $approved_by_id = null;
        if ($validatedData['status'] == 'approved_hrd') {
            $approved_by_id = Auth::id(); 
        }

        Leave::create(array_merge($validatedData, [
            'total_hari' => $totalHari,
            'approved_by' => $approved_by_id
        ]));

        return redirect()->route('hrd.cuti.index')
                         ->with('success', 'Data cuti berhasil ditambahkan.');
    }

    public function show(Leave $cuti)
    {
        return redirect()->route('hrd.cuti.edit', $cuti);
    }

    public function edit(Leave $cuti)
    {
        $employees = Employee::orderBy('nama_lengkap')->get();
        return view('hrd.cuti.edit', compact('cuti', 'employees'));
    }

    public function update(Request $request, Leave $cuti)
    {
        $validatedData = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'alasan' => 'required|string',
            'status' => ['required', Rule::in(['pending', 'approved_hrd', 'rejected'])],
        ]);

        $tanggalMulai = new Carbon($validatedData['tanggal_mulai']);
        $tanggalSelesai = new Carbon($validatedData['tanggal_selesai']);
        $totalHari = $tanggalMulai->diffInDays($tanggalSelesai) + 1;

        $approved_by_id = $cuti->approved_by;
        
        if ($validatedData['status'] == 'approved_hrd' && $cuti->status != 'approved_hrd') {
            $approved_by_id = Auth::id();
        } 

        elseif (in_array($validatedData['status'], ['pending', 'rejected'])) {
            $approved_by_id = null; 
        }

        $cuti->update(array_merge($validatedData, [
            'total_hari' => $totalHari,
            'approved_by' => $approved_by_id
        ]));

        return redirect()->route('hrd.cuti.index')
                         ->with('success', 'Data cuti berhasil diperbarui.');
    }

    public function destroy(Leave $cuti)
    {
        if ($cuti->status == 'approved_hrd') {
            return redirect()->route('hrd.cuti.index')
                             ->with('error', 'Data cuti yang sudah disetujui tidak dapat dihapus. Silakan ubah statusnya menjadi "rejected" jika ingin membatalkan.');
        }

        $cuti->delete();

        return redirect()->route('hrd.cuti.index')
                         ->with('success', 'Data cuti berhasil dihapus.');
    }
}