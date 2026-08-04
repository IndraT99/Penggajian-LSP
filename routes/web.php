<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\LoginController;

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\JabatanController;
use App\Http\Controllers\Admin\DivisiController;
use App\Http\Controllers\Admin\PayrollComponentController;

use App\Http\Controllers\Owner\LaporanController;

use App\Http\Controllers\HRD\KaryawanController;
use App\Http\Controllers\HRD\AbsensiController;
use App\Http\Controllers\HRD\CutiController;
use App\Http\Controllers\HRD\LemburController;
use App\Http\Controllers\HRD\PayrollController;

use App\Http\Controllers\Keuangan\ApprovalController;

use App\Http\Controllers\Karyawan\KaryawanSlipGajiController;
use App\Http\Controllers\Karyawan\PengajuanCutiController;
use App\Http\Controllers\Karyawan\PengajuanLemburController;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/setup-database', function () {
        try {
            Artisan::call('migrate --force');
            return '✅ Database berhasil dimigrasi! Tabel penggajian sudah siap.';
        } catch (\Exception $e) {
            return '❌ Gagal migrasi: ' . $e->getMessage();
        }
    });

    Route::get('/fix-ssl', function () {
        // 1. Paksa bersihkan Cache Konfigurasi
        Artisan::call('config:clear');
        Artisan::call('cache:clear');

        // 2. Cek apakah file sertifikat ada di server?
        $certPath = '/etc/ssl/certs/ca-certificates.crt';
        $certExists = file_exists($certPath) ? 'ADA ✅' : 'TIDAK ADA ❌';

        // 3. Tes Koneksi Database
        try {
            DB::connection()->getPdo();
            return "<h1>SUKSES! ✅</h1> <p>Sertifikat SSL: $certExists</p> <p>Koneksi ke TiDB Berhasil. Database siap.</p> <p>Silakan buka <a href='/setup-database'>/setup-database</a> sekarang.</p>";
        } catch (\Exception $e) {
            return "<h1>GAGAL ❌</h1> <p>Sertifikat SSL: $certExists</p> <p>Pesan Error: " . $e->getMessage() . "</p>";
        }
    });
});

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login']);
});


Route::middleware('auth')->group(function () {
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::resource('users', UserController::class);
        Route::resource('jabatans', JabatanController::class);
        Route::resource('divisis', DivisiController::class);
        Route::resource('payroll-components', PayrollComponentController::class);
    });

    Route::middleware('role:owner')->prefix('owner')->name('owner.')->group(function () {
        Route::get('laporan/gaji', [LaporanController::class, 'laporanGaji'])->name('laporan.gaji');
    });

    Route::middleware('role:staff_hrd')->prefix('hrd')->name('hrd.')->group(function () {
        Route::resource('karyawan', KaryawanController::class);
        Route::resource('absensi', AbsensiController::class);
        Route::resource('cuti', CutiController::class);
        Route::resource('lembur', LemburController::class);
        
        Route::get('payroll', [PayrollController::class, 'index'])->name('payroll.index');
        Route::get('payroll/generate', [PayrollController::class, 'showGenerateForm'])->name('payroll.generate');
        Route::post('payroll/generate', [PayrollController::class, 'storeGenerate'])->name('payroll.store');
        Route::get('payroll/{payroll}/slip', [PayrollController::class, 'showSlip'])->name('payroll.slip');
    });

    Route::middleware('role:staff_keuangan')->prefix('keuangan')->name('keuangan.')->group(function () {
        Route::get('approval-gaji', [ApprovalController::class, 'index'])->name('approval.index');
        Route::get('approval-gaji/{payroll}', [ApprovalController::class, 'show'])->name('approval.show');
        Route::post('approval-gaji/{payroll}/approve', [ApprovalController::class, 'approve'])->name('approval.approve');
        Route::post('approval-gaji/{payroll}/reject', [ApprovalController::class, 'reject'])->name('approval.reject');
    });

    Route::middleware('role:karyawan')->prefix('karyawan')->name('karyawan.')->group(function () {
        Route::get('slip-gaji', [KaryawanSlipGajiController::class, 'index'])->name('slip.index');
        Route::get('slip-gaji/{payroll}', [KaryawanSlipGajiController::class, 'show'])->name('slip.show');
        Route::get('komponen-gaji', [KaryawanSlipGajiController::class, 'komponen'])->name('komponen');
        Route::get('slip-gaji/{payroll}/pdf', [KaryawanSlipGajiController::class, 'generatePDF'])->name('slip-gaji.pdf');
        Route::resource('pengajuan-cuti', PengajuanCutiController::class);
        Route::resource('pengajuan-lembur', PengajuanLemburController::class);
    });

});

