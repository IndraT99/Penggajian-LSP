@extends('layouts.app')

@section('title', 'Dashboard Staff Keuangan')

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
                        <p class="mb-0 text-muted">Berikut adalah ringkasan pekerjaan Anda sebagai Staff Keuangan.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--  -->

<!-- Baris Kartu Statistik (Tugas Keuangan) -->
<div class="row">
    <!-- Card Persetujuan Gaji -->
    <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
        <a href="{{ route('keuangan.approval.index') }}?status=pending" class="card-link">
            <div class="card">
                <div class="card-body">
                    <div class="card-title d-flex align-items-start justify-content-between">
                        <div class="avatar flex-shrink-0">
                            <span class="avatar-initial rounded bg-label-warning"><i class="bx bx-check-shield"></i></span>
                        </div>
                    </div>
                    <span class="fw-semibold d-block mb-1">Menunggu Persetujuan</span>
                    @if ($stats['pending_approval'] > 0)
                        <h3 class="card-title text-warning mb-2">{{ $stats['pending_approval'] }}</h3>
                        <small class="text-warning fw-semibold">Gaji perlu di-review</small>
                    @else
                        <h3 class="card-title mb-2">0</h3>
                        <small class="text-muted">Tidak ada pekerjaan tertunda</small>
                    @endif
                </div>
            </div>
        </a>
    </div>

    <!-- Card Disetujui Bulan Ini -->
    <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
        <a href="{{ route('keuangan.approval.index') }}?status=approved_finance" class="card-link">
            <div class="card">
                <div class="card-body">
                    <div class="card-title d-flex align-items-start justify-content-between">
                        <div class="avatar flex-shrink-0">
                            <span class="avatar-initial rounded bg-label-success"><i class="bx bx-calendar-check"></i></span>
                        </div>
                    </div>
                    <span class="fw-semibold d-block mb-1">Disetujui (Bulan Ini)</span>
                    <h3 class="card-title mb-2">{{ $stats['approved_this_month'] }}</h3>
                    <small class="text-muted">Gaji telah disetujui</small>
                </div>
            </div>
        </a>
    </div>
    
    <!-- Card Ditolak Bulan Ini -->
    <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
        <a href="{{ route('keuangan.approval.index') }}?status=rejected" class="card-link">
            <div class="card">
                <div class="card-body">
                    <div class="card-title d-flex align-items-start justify-content-between">
                        <div class="avatar flex-shrink-0">
                            <span class="avatar-initial rounded bg-label-danger"><i class="bx bx-x-circle"></i></span>
                        </div>
                    </div>
                    <span class="fw-semibold d-block mb-1">Ditolak (Bulan Ini)</span>
                    <h3 class="card-title mb-2">{{ $stats['rejected_this_month'] }}</h3>
                    <small class="text-muted">Gaji ditolak (perlu revisi)</small>
                </div>
            </div>
        </a>
    </div>
    
    <!-- Card Total Nominal Disetujui -->
    <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
        <div class="card">
            <div class="card-body">
                <div class="card-title d-flex align-items-start justify-content-between">
                    <div class="avatar flex-shrink-0">
                        <span class="avatar-initial rounded bg-label-primary"><i class="bx bx-wallet"></i></span>
                    </div>
                </div>
                <span class="fw-semibold d-block mb-1">Total Dibayar (Bulan Ini)</span>
                <h4 class="card-title mb-2">Rp {{ number_format($stats['total_approved_amount'], 0, ',', '.') }}</h4>
                <small class="text-muted">Total nominal gaji disetujui</small>
            </div>
        </div>
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