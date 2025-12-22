<?php

namespace App\Http\Controllers\HRD;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Jabatan;
use App\Models\Divisi; 
use App\Models\User;
use App\Models\PayrollComponent;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class KaryawanController extends Controller
{
    public function index(Request $request)
    {
        $query = Employee::with(['jabatan', 'divisi', 'user']);

        if ($request->filled('status_karyawan')) {
            $query->where('status_karyawan', $request->status_karyawan);
        }
        if ($request->filled('jabatan_id')) {
            $query->where('jabatan_id', $request->jabatan_id);
        }
        if ($request->filled('divisi_id')) {
            $query->where('divisi_id', $request->divisi_id);
        }

        $employees = $query->latest()->paginate(15);
        
        $jabatans = Jabatan::orderBy('nama_jabatan')->get();
        $divisis = Divisi::orderBy('nama_divisi')->get();

        return view('hrd.karyawan.index', compact('employees', 'jabatans', 'divisis'));
    }

    public function create()
    {
        $jabatans = Jabatan::orderBy('nama_jabatan')->get();
        $divisis = Divisi::orderBy('nama_divisi')->get();
        
        $users = User::whereDoesntHave('employee')->orderBy('name')->get();
        
        $components = PayrollComponent::orderBy('tipe')->orderBy('nama_komponen')->get();

        return view('hrd.karyawan.create', compact('jabatans', 'divisis', 'users', 'components'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nik' => 'required|string|max:100|unique:employees,nik',
            'nama_lengkap' => 'required|string|max:255',
            'gaji_pokok' => 'required|numeric|min:0',
            'jabatan_id' => 'required|exists:jabatans,id',
            'divisi_id' => 'required|exists:divisis,id',
            'tanggal_bergabung' => 'required|date',
            'status_karyawan' => ['required', Rule::in(['aktif', 'non_aktif', 'resign'])],
            
            'user_id' => 'nullable|exists:users,id|unique:employees,user_id',
            'tempat_lahir' => 'nullable|string|max:100',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => ['nullable', Rule::in(['L', 'P'])],
            'alamat' => 'nullable|string',
            'no_telepon' => 'nullable|string|max:20',

            'components' => 'nullable|array',
            'components.*.id' => 'required|exists:payroll_components,id',
            'components.*.jumlah' => 'required|numeric|min:0',
        ]);

        $employee = Employee::create($validatedData);

        $syncData = [];
        if ($request->has('components')) {
            foreach ($request->components as $comp) {
                $jumlah = $comp['jumlah'] ?? 0;
                $syncData[$comp['id']] = ['jumlah' => $jumlah];
            }
        }

        $employee->components()->sync($syncData);

        return redirect()->route('hrd.karyawan.index')
                         ->with('success', 'Data Karyawan berhasil ditambahkan.');
    }

    public function show(Employee $karyawan)
    {
        $karyawan->load(['jabatan', 'divisi', 'user', 'components', 'payrolls', 'leaves', 'overtimes']);
        
        return view('hrd.karyawan.show', compact('karyawan'));
    }

    public function edit(Employee $karyawan)
    {
        $jabatans = Jabatan::orderBy('nama_jabatan')->get();
        $divisis = Divisi::orderBy('nama_divisi')->get();
        
        $users = User::whereDoesntHave('employee')
                     ->orWhere('id', $karyawan->user_id)
                     ->orderBy('name')
                     ->get();
        
        $components = PayrollComponent::orderBy('tipe')->orderBy('nama_komponen')->get();
        
        $currentComponentData = $karyawan->components->pluck('pivot.jumlah', 'id');

        return view('hrd.karyawan.edit', compact('karyawan', 'jabatans', 'divisis', 'users', 'components', 'currentComponentData'));
    }

    public function update(Request $request, Employee $karyawan)
    {
        $validatedData = $request->validate([
            'nik' => ['required', 'string', 'max:100', Rule::unique('employees')->ignore($karyawan->id)],
            'nama_lengkap' => 'required|string|max:255',
            'gaji_pokok' => 'required|numeric|min:0',
            'jabatan_id' => 'required|exists:jabatans,id',
            'divisi_id' => 'required|exists:divisis,id',
            'tanggal_bergabung' => 'required|date',
            'status_karyawan' => ['required', Rule::in(['aktif', 'non_aktif', 'resign'])],
            
            'user_id' => ['nullable', 'exists:users,id', Rule::unique('employees')->ignore($karyawan->id)],
            'tempat_lahir' => 'nullable|string|max:100',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => ['nullable', Rule::in(['L', 'P'])],
            'alamat' => 'nullable|string',
            'no_telepon' => 'nullable|string|max:20',

            'components' => 'nullable|array',
            'components.*.id' => 'required|exists:payroll_components,id',
            'components.*.jumlah' => 'required|numeric|min:0',
        ]);

        $karyawan->update($validatedData);

        $syncData = [];
        if ($request->has('components')) {
            foreach ($request->components as $comp) {
                $jumlah = $comp['jumlah'] ?? 0;
                $syncData[$comp['id']] = ['jumlah' => $jumlah];
            }
        }

        $karyawan->components()->sync($syncData);

        return redirect()->route('hrd.karyawan.index')
                         ->with('success', 'Data Karyawan berhasil diperbarui.');
    }

    public function destroy(Employee $karyawan)
    {
        
        try {
            $karyawan->delete();
            
            return redirect()->route('hrd.karyawan.index')
                             ->with('success', 'Data Karyawan berhasil dihapus.');

        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == 23000) { 
                return redirect()->route('hrd.karyawan.index')
                                 ->with('error', 'Karyawan tidak bisa dihapus karena memiliki riwayat data (cth: penggajian). Harap ubah statusnya menjadi "Non-Aktif" atau "Resign" saja.');
            }

            return redirect()->route('hrd.karyawan.index')
                             ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}