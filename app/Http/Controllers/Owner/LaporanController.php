<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Payroll; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; 

class LaporanController extends Controller
{

    public function laporanGaji(Request $request)
    {
        $bulan = (int) $request->input('bulan', now()->month);
        $tahun = (int) $request->input('tahun', now()->year);

        $baseQuery = Payroll::where('bulan', $bulan)
                            ->where('tahun', $tahun)
                            ->whereIn('status', ['approved_finance', 'paid']);

        $aggregates = (clone $baseQuery)
            ->selectRaw("
                SUM(gaji_pokok) as total_gaji_pokok,
                SUM(total_tunjangan) as total_tunjangan,
                SUM(total_potongan) as total_potongan,
                SUM(total_lembur) as total_lembur,
                SUM(gaji_kotor) as total_gaji_kotor,
                SUM(gaji_bersih) as total_gaji_bersih,
                COUNT(id) as total_karyawan
            ")
            ->first(); 
        $payrolls = $baseQuery
            ->with('employee:id,nama_lengkap,nik') 
            ->latest('gaji_bersih') 
            ->paginate(50) 
            ->withQueryString(); 

        return view('owner.laporan.gaji', compact(
            'aggregates', 
            'payrolls', 
            'bulan', 
            'tahun'
        ));
    }
}