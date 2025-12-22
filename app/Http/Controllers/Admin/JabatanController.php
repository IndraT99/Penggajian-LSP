<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jabatan; 
use Illuminate\Http\Request;

class JabatanController extends Controller
{
    public function index()
    {
        $jabatans = Jabatan::latest()->paginate(10);
        return view('admin.jabatans.index', compact('jabatans')); 
    }

    public function create()
    {
        return view('admin.jabatans.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_jabatan' => 'required|string|max:255|unique:jabatans',
            'deskripsi' => 'nullable|string',
        ]);

        Jabatan::create($request->all());

        return redirect()->route('admin.jabatans.index')
                         ->with('success', 'Data Jabatan berhasil ditambahkan.');
    }

    public function edit(Jabatan $jabatan)
    {
        return view('admin.jabatans.edit', compact('jabatan'));
    }

    public function update(Request $request, Jabatan $jabatan)
    {
        $request->validate([
            'nama_jabatan' => 'required|string|max:255|unique:jabatans,nama_jabatan,'.$jabatan->id,
            'deskripsi' => 'nullable|string',
        ]);

        $jabatan->update($request->all());

        return redirect()->route('admin.jabatans.index')
                         ->with('success', 'Data Jabatan berhasil diperbarui.');
    }

    public function destroy(Jabatan $jabatan)
    {
        try {
            $jabatan->delete();

            return redirect()->route('admin.jabatans.index')
                             ->with('success', 'Data Jabatan berhasil dihapus.');

        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == 23000) { 
                return redirect()->route('admin.jabatans.index')
                                 ->with('error', 'Data Jabatan tidak bisa dihapus karena masih digunakan oleh Karyawan.');
            }
            return redirect()->route('admin.jabatans.index')
                             ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}