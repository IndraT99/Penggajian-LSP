<?php

namespace App\Http\Controllers\HRD;

use App\Http\Controllers\Controller;
use App\Models\Overtime;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class LemburController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->input('status');
        $bulan = $request->input('bulan');
        $tahun = $request->input('tahun');

        $query = Overtime::with('employee');

        if ($tahun) {
            $query->whereYear('tanggal', $tahun);
        }

        if ($bulan) {
            $query->whereMonth('tanggal', $bulan);
        }

        if ($status) {
            $query->where('status', $status);
        }

        $overtimes = $query->latest('tanggal')->paginate(20);

        return view('hrd.lembur.index', compact('overtimes', 'status', 'bulan', 'tahun'));
    }

    public function create()
    {
        $employees = Employee::orderBy('nama_lengkap')->get();
        return view('hrd.lembur.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'tanggal' => 'required|date',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            'alasan_lembur' => 'required|string',
            'biaya_lembur' => 'required|numeric|min:0',
            'status' => ['required', Rule::in(['pending', 'approved_hrd', 'rejected'])],
        ]);

        $jamMulai = new Carbon($validatedData['jam_mulai']);
        $jamSelesai = new Carbon($validatedData['jam_selesai']);
        $totalJam = $jamMulai->diffInHours($jamSelesai);

        $approved_by_id = null;
        if ($validatedData['status'] == 'approved_hrd') {
            $approved_by_id = Auth::id();
        }

        Overtime::create(array_merge($validatedData, [
            'total_jam' => $totalJam,
            'approved_by' => $approved_by_id
        ]));

        return redirect()->route('hrd.lembur.index')
            ->with('success', 'Data lembur berhasil ditambahkan.');
    }

    public function show(Overtime $lembur)
    {
        return redirect()->route('hrd.lembur.edit', $lembur);
    }

    public function edit(Overtime $lembur)
    {
        $employees = Employee::orderBy('nama_lengkap')->get();
        return view('hrd.lembur.edit', compact('lembur', 'employees'));
    }

    public function update(Request $request, Overtime $lembur)
    {
        $validatedData = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'tanggal' => 'required|date',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            'alasan_lembur' => 'required|string',
            'biaya_lembur' => 'required|numeric|min:0',
            'status' => ['required', Rule::in(['pending', 'approved_hrd', 'rejected'])],
        ]);

        $jamMulai = new Carbon($validatedData['jam_mulai']);
        $jamSelesai = new Carbon($validatedData['jam_selesai']);
        $totalJam = $jamMulai->diffInHours($jamSelesai);

        $approved_by_id = $lembur->approved_by;

        if ($validatedData['status'] == 'approved_hrd' && $lembur->status != 'approved_hrd') {
            $approved_by_id = Auth::id();
        } elseif (in_array($validatedData['status'], ['pending', 'rejected'])) {
            $approved_by_id = null;
        }

        $lembur->update(array_merge($validatedData, [
            'total_jam' => $totalJam,
            'approved_by' => $approved_by_id
        ]));

        return redirect()->route('hrd.lembur.index')
            ->with('success', 'Data lembur berhasil diperbarui.');
    }

    public function destroy(Overtime $lembur)
    {
        if ($lembur->status == 'approved_hrd') {
            return redirect()->route('hrd.lembur.index')
                ->with('error', 'Data lembur yang sudah disetujui tidak dapat dihapus. Silakan ubah statusnya menjadi "rejected" jika ingin membatalkan.');
        }

        $lembur->delete();

        return redirect()->route('hrd.lembur.index')
            ->with('success', 'Data lembur berhasil dihapus.');
    }
}