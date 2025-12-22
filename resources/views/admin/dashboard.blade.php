@extends('layouts.app')

@section('title', 'Dashboard Admin')

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
                        <p class="mb-0 text-muted">Anda login sebagai Admin. Anda memiliki kontrol penuh atas data
                            master sistem.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
        <a href="{{ route('admin.users.index') }}" class="card-link">
            <div class="card">
                <div class="card-body">
                    <div class="card-title d-flex align-items-start justify-content-between">
                        <div class="avatar flex-shrink-0">
                            <span class="avatar-initial rounded bg-label-primary"><i class="bx bx-user"></i></span>
                        </div>
                    </div>
                    <span class="fw-semibold d-block mb-1">Total Pengguna</span>
                    <h3 class="card-title mb-2">{{ $stats['total_users'] }}</h3>
                    <small class="text-muted">Akun yang terdaftar</small>
                </div>
            </div>
        </a>
    </div>

    <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
        <div class="card">
            <div class="card-body">
                <div class="card-title d-flex align-items-start justify-content-between">
                    <div class="avatar flex-shrink-0">
                        <span class="avatar-initial rounded bg-label-success"><i class="bx bx-user-pin"></i></span>
                    </div>
                </div>
                <span class="fw-semibold d-block mb-1">Total Karyawan</span>
                <h3 class="card-title mb-2">{{ $stats['total_employees'] }}</h3>
                <small class="text-muted">Dikelola oleh HRD</small>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
        <a href="{{ route('admin.jabatans.index') }}" class="card-link">
            <div class="card">
                <div class="card-body">
                    <div class="card-title d-flex align-items-start justify-content-between">
                        <div class="avatar flex-shrink-0">
                            <span class="avatar-initial rounded bg-label-info"><i class="bx bx-briefcase"></i></span>
                        </div>
                    </div>
                    <span class="fw-semibold d-block mb-1">Total Jabatan</span>
                    <h3 class="card-title mb-2">{{ $stats['total_jabatans'] }}</h3>
                    <small class="text-muted">Data master jabatan</small>
                </div>
            </div>
        </a>
    </div>

    <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
        <a href="{{ route('admin.divisis.index') }}" class="card-link">
            <div class="card">
                <div class="card-body">
                    <div class="card-title d-flex align-items-start justify-content-between">
                        <div class="avatar flex-shrink-0">
                            <span class="avatar-initial rounded bg-label-warning"><i
                                    class="bx bx-building-house"></i></span>
                        </div>
                    </div>
                    <span class="fw-semibold d-block mb-1">Total Divisi</span>
                    <h3 class="card-title mb-2">{{ $stats['total_divisis'] }}</h3>
                    <small class="text-muted">Data master divisi</small>
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
