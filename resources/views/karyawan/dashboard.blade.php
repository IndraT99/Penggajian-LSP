@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card mb-4">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="avatar avatar-xl me-3">
                        <span class="avatar-initial rounded-circle bg-primary">
                            {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                        </span>
                    </div>
                    <div>
                        <h4 class="mb-0">Selamat datang, {{ auth()->user()->name }}!</h4>
                        <p class="mb-0 text-muted">Berikut adalah ringkasan akun Anda.</p>
                    </div>
                </div>
                
                <hr>

                <div class="row">
                    <div class="col-md-4 col-sm-6 mb-2">
                        <span class="fw-semibold">NIK:</span>
                        <span class="text-muted">{{ $employee->nik }}</span>
                    </div>
                    <div class="col-md-4 col-sm-6 mb-2">
                        <span class="fw-semibold">Jabatan:</span>
                        <span class="text-muted">{{ $employee->jabatan->nama_jabatan ?? '-' }}</span>
                    </div>
                    <div class="col-md-4 col-sm-6 mb-2">
                        <span class="fw-semibold">Divisi:</span>
                        <span class="text-muted">{{ $employee->divisi->nama_divisi ?? '-' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
        <a href="{{ route('karyawan.slip.index') }}" class="card-link">
            <div class="card">
                <div class="card-body">
                    <div class="card-title d-flex align-items-start justify-content-between">
                        <div class="avatar flex-shrink-0">
                            <span class="avatar-initial rounded bg-label-success"><i class="bx bx-receipt"></i></span>
                        </div>
                    </div>
                    <span class="fw-semibold d-block mb-1">Slip Gaji</span>
                    <h3 class="card-title mb-2">{{ $stats['total_slips'] }}</h3>
                    <small class="text-muted">Total slip gaji yang telah terbit</small>
                </div>
            </div>
        </a>
    </div>

    <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
        <a href="{{ route('karyawan.pengajuan-cuti.index') }}" class="card-link">
            <div class="card">
                <div class="card-body">
                    <div class="card-title d-flex align-items-start justify-content-between">
                        <div class="avatar flex-shrink-0">
                            <span class="avatar-initial rounded bg-label-warning"><i class="bx bx-calendar-plus"></i></span>
                        </div>
                    </div>
                    <span class="fw-semibold d-block mb-1">Pengajuan Cuti</span>
                    @if ($stats['pending_cuti'] > 0)
                        <h3 class="card-title text-warning mb-2">{{ $stats['pending_cuti'] }}</h3>
                        <small class="text-warning fw-semibold">Pengajuan Menunggu Persetujuan</small>
                    @else
                        <h3 class="card-title mb-2">0</h3>
                        <small class="text-muted">Tidak ada pengajuan tertunda</small>
                    @endif
                </div>
            </div>
        </a>
    </div>
    
    <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
        <a href="{{ route('karyawan.pengajuan-lembur.index') }}" class="card-link">
            <div class="card">
                <div class="card-body">
                    <div class="card-title d-flex align-items-start justify-content-between">
                        <div class="avatar flex-shrink-0">
                            <span class="avatar-initial rounded bg-label-info"><i class="bx bx-timer"></i></span>
                        </div>
                    </div>
                    <span class="fw-semibold d-block mb-1">Pengajuan Lembur</span>
                     @if ($stats['pending_lembur'] > 0)
                        <h3 class="card-title text-info mb-2">{{ $stats['pending_lembur'] }}</h3>
                        <small class="text-info fw-semibold">Pengajuan Menunggu Persetujuan</small>
                    @else
                        <h3 class="card-title mb-2">0</h3>
                        <small class="text-muted">Tidak ada pengajuan tertunda</small>
                    @endif
                </div>
            </div>
        </a>
    </div>
    
    <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
        <a href="{{ route('karyawan.komponen') }}" class="card-link">
            <div class="card">
                <div class="card-body">
                    <div class="card-title d-flex align-items-start justify-content-between">
                        <div class="avatar flex-shrink-0">
                            <span class="avatar-initial rounded bg-label-secondary"><i class="bx bx-list-check"></i></span>
                        </div>
                    </div>
                    <span class="fw-semibold d-block mb-1">Komponen Gaji</span>
                    <h3 class="card-title mb-2">{{ $stats['total_komponen'] }}</h3>
                    <small class="text-muted">Total tunjangan & potongan</small>
                </div>
            </div>
        </a>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Membuat kartu statistik bisa diklik */
    .card-link {
        text-decoration: none;
    }
    .card-link .card {
        transition: all 0.2s ease;
    }
    .card-link .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 12px rgba(0,0,0,0.08);
    }
</style>
@endpush