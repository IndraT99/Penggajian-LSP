<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Divisi;
use Illuminate\Http\Request;

class DivisiController extends Controller
{

    public function index()
    {
        $divisis = Divisi::latest()->paginate(10);
        
        return view('admin.divisis.index', compact('divisis'));
    }

    public function create()
    {
        return view('admin.divisis.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_divisi' => 'required|string|max:255|unique:divisis',
        ]);
        Divisi::create($request->all());

        return redirect()->route('admin.divisis.index')
                         ->with('success', 'Data Divisi berhasil ditambahkan.');
    }

    public function show(Divisi $divisi)
    {
        return redirect()->route('admin.divisis.edit', $divisi);
    }

    public function edit(Divisi $divisi)
    {
        return view('admin.divisis.edit', compact('divisi'));
    }

    public function update(Request $request, Divisi $divisi)
    {
        $request->validate([
            'nama_divisi' => 'required|string|max:255|unique:divisis,nama_divisi,' . $divisi->id,
        ]);

        $divisi->update($request->all());

        return redirect()->route('admin.divisis.index')
                         ->with('success', 'Data Divisi berhasil diperbarui.');
    }

    public function destroy(Divisi $divisi)
    {
        try {
            $divisi->delete();

            return redirect()->route('admin.divisis.index')
                             ->with('success', 'Data Divisi berhasil dihapus.');
                             
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == 23000) { 
                return redirect()->route('admin.divisis.index')
                                 ->with('error', 'Data Divisi tidak bisa dihapus karena masih digunakan oleh Karyawan.');
            }

            return redirect()->route('admin.divisis.index')
                             ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}