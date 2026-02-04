@extends('layouts.app')

@section('title', 'Dashboard Owner')

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
                            <p class="mb-0 text-muted">Berikut adalah ringkasan finansial (biaya gaji) untuk bulan ini.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>





    <div class="row">

        <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
            <a href="{{ route('owner.laporan.gaji') }}" class="card-link">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="avatar flex-shrink-0">
                                <span class="avatar-initial rounded bg-label-primary"><i class="bx bx-wallet"></i></span>
                            </div>
                        </div>
                        <span class="fw-semibold d-block mb-1">Total Gaji Dibayar (Bersih)</span>
                        <h4 class="card-title mb-2">Rp {{ number_format($stats['total_gaji_bersih'], 0, ',', '.') }}</h4>
                        <small class="text-muted">Total (Take Home Pay) bulan ini</small>
                    </div>
                </div>
            </a>
        </div>


        <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
            <a href="{{ route('owner.laporan.gaji') }}" class="card-link">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="avatar flex-shrink-0">
                                <span class="avatar-initial rounded bg-label-danger"><i
                                        class="bx bx-dollar-circle"></i></span>
                            </div>
                        </div>
                        <span class="fw-semibold d-block mb-1">Total Biaya Gaji (Kotor)</span>
                        <h4 class="card-title mb-2">Rp {{ number_format($stats['total_gaji_kotor'], 0, ',', '.') }}</h4>
                        <small class="text-muted">Total biaya gaji (sebelum potongan)</small>
                    </div>
                </div>
            </a>
        </div>


        <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
            <a href="{{ route('owner.laporan.gaji') }}" class="card-link">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="avatar flex-shrink-0">
                                <span class="avatar-initial rounded bg-label-info"><i class="bx bx-time-five"></i></span>
                            </div>
                        </div>
                        <span class="fw-semibold d-block mb-1">Total Biaya Lembur</span>
                        <h4 class="card-title mb-2">Rp {{ number_format($stats['total_lembur'], 0, ',', '.') }}</h4>
                        <small class="text-muted">Biaya variabel lembur bulan ini</small>
                    </div>
                </div>
            </a>
        </div>


        <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
            <a href="{{ route('owner.laporan.gaji') }}" class="card-link">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="avatar flex-shrink-0">
                                <span class="avatar-initial rounded bg-label-success"><i
                                        class="bx bx-user-check"></i></span>
                            </div>
                        </div>
                        <span class="fw-semibold d-block mb-1">Karyawan Dibayar</span>
                        <h3 class="card-title mb-2">{{ $stats['total_karyawan_paid'] }}</h3>
                        <small class="text-muted">Orang yang menerima gaji bulan ini</small>
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
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.08);
        }
    </style>

@endpush