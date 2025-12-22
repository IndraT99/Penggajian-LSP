<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PayrollComponent;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule; 

class PayrollComponentController extends Controller
{
    public function index()
    {
        $components = PayrollComponent::orderBy('tipe')->orderBy('nama_komponen')->paginate(15);
        
        return view('admin.payroll-components.index', compact('components'));
    }

    public function create()
    {
        return view('admin.payroll-components.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_komponen' => 'required|string|max:255|unique:payroll_components',
            'tipe' => ['required', Rule::in(['allowance', 'deduction'])], 
            'is_fixed' => 'nullable|boolean',
            'jumlah_default' => 'nullable|numeric|min:0',
        ]);

        $validatedData['is_fixed'] = $request->has('is_fixed');
        
        if (empty($validatedData['jumlah_default'])) {
            $validatedData['jumlah_default'] = 0;
        }

        PayrollComponent::create($validatedData);

        return redirect()->route('admin.payroll-components.index')
                         ->with('success', 'Komponen Gaji berhasil ditambahkan.');
    }

    public function show(PayrollComponent $payrollComponent)
    {
        return redirect()->route('admin.payroll-components.edit', $payrollComponent);
    }

    public function edit(PayrollComponent $payrollComponent)
    {
        return view('admin.payroll-components.edit', compact('payrollComponent'));
    }

    public function update(Request $request, PayrollComponent $payrollComponent)
    {
        $validatedData = $request->validate([
            'nama_komponen' => 'required|string|max:255|unique:payroll_components,nama_komponen,' . $payrollComponent->id,
            'tipe' => ['required', Rule::in(['allowance', 'deduction'])],
            'is_fixed' => 'nullable|boolean',
            'jumlah_default' => 'nullable|numeric|min:0',
        ]);

        $validatedData['is_fixed'] = $request->has('is_fixed');

        if (empty($validatedData['jumlah_default'])) {
            $validatedData['jumlah_default'] = 0;
        }

        $payrollComponent->update($validatedData);

        return redirect()->route('admin.payroll-components.index')
                         ->with('success', 'Komponen Gaji berhasil diperbarui.');
    }

    public function destroy(PayrollComponent $payrollComponent)
    {
        try {
            $payrollComponent->delete();

            return redirect()->route('admin.payroll-components.index')
                             ->with('success', 'Komponen Gaji berhasil dihapus.');

        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == 23000) { 
                return redirect()->route('admin.payroll-components.index')
                                 ->with('error', 'Komponen Gaji tidak bisa dihapus karena masih digunakan oleh Karyawan.');
            }

            return redirect()->route('admin.payroll-components.index')
                             ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}