@extends('layouts.app')

@section('title', 'Dashboard Staff HRD')

@section('content')
<div class="row">
    <!-- Kolom Selamat Datang -->
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
                        <p class="mb-0 text-muted">Berikut adalah ringkasan pekerjaan Anda sebagai Staff HRD.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--  -->

<!-- Baris Kartu Statistik (Tugas HRD) -->
<div class="row">
    <!-- Card Karyawan Aktif -->
    <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
        <a href="{{ route('hrd.karyawan.index') }}" class="card-link">
            <div class="card">
                <div class="card-body">
                    <div class="card-title d-flex align-items-start justify-content-between">
                        <div class="avatar flex-shrink-0">
                            <span class="avatar-initial rounded bg-label-success"><i class="bx bx-user-pin"></i></span>
                        </div>
                    </div>
                    <span class="fw-semibold d-block mb-1">Karyawan Aktif</span>
                    <h3 class="card-title mb-2">{{ $stats['total_karyawan_aktif'] }}</h3>
                    <small class="text-muted">Total karyawan yang dikelola</small>
                </div>
            </div>
        </a>
    </div>

    <!-- Card Persetujuan Cuti -->
    <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
        <a href="{{ route('hrd.cuti.index') }}?status=pending" class="card-link">
            <div class="card">
                <div class="card-body">
                    <div class="card-title d-flex align-items-start justify-content-between">
                        <div class="avatar flex-shrink-0">
                            <span class="avatar-initial rounded bg-label-warning"><i class="bx bx-calendar-minus"></i></span>
                        </div>
                    </div>
                    <span class="fw-semibold d-block mb-1">Persetujuan Cuti</span>
                    @if ($stats['pending_cuti'] > 0)
                        <h3 class="card-title text-warning mb-2">{{ $stats['pending_cuti'] }}</h3>
                        <small class="text-warning fw-semibold">Pengajuan menunggu persetujuan</small>
                    @else
                        <h3 class="card-title mb-2">0</h3>
                        <small class="text-muted">Tidak ada pengajuan tertunda</small>
                    @endif
                </div>
            </div>
        </a>
    </div>
    
    <!-- Card Persetujuan Lembur -->
    <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
        <a href="{{ route('hrd.lembur.index') }}?status=pending" class="card-link">
            <div class="card">
                <div class="card-body">
                    <div class="card-title d-flex align-items-start justify-content-between">
                        <div class="avatar flex-shrink-0">
                            <span class="avatar-initial rounded bg-label-info"><i class="bx bx-time-five"></i></span>
                        </div>
                    </div>
                    <span class="fw-semibold d-block mb-1">Persetujuan Lembur</span>
                     @if ($stats['pending_lembur'] > 0)
                        <h3 class="card-title text-info mb-2">{{ $stats['pending_lembur'] }}</h3>
                        <small class="text-info fw-semibold">Pengajuan menunggu persetujuan</small>
                    @else
                        <h3 class="card-title mb-2">0</h3>
                        <small class="text-muted">Tidak ada pengajuan tertunda</small>
                    @endif
                </div>
            </div>
        </a>
    </div>
    
    <!-- Card Payroll Pending -->
    <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
        <a href="{{ route('hrd.payroll.index') }}?status=pending" class="card-link">
            <div class="card">
                <div class="card-body">
                    <div class="card-title d-flex align-items-start justify-content-between">
                        <div class="avatar flex-shrink-0">
                            <span class="avatar-initial rounded bg-label-secondary"><i class="bx bx-calculator"></i></span>
                        </div>
                    </div>
                    <span class="fw-semibold d-block mb-1">Payroll (Pending)</span>
                    <h3 class="card-title mb-2">{{ $stats['pending_payroll'] }}</h3>
                    <small class="text-muted">Menunggu approval Keuangan</small>
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