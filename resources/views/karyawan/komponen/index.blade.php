@extends('layouts.app')

@section('title', 'Komponen Gaji Saya')

@section('content')

<div class="row">
<!-- Info Karyawan -->
<div class="col-12">
<div class="card mb-4">
<div class="card-body">
<h5 class="mb-1">Komponen Gaji untuk:</h5>
<h4 class="mb-0">{{ $employee->nama_lengkap }} ({{ $employee->nik }})</h4>
<p class="mt-3 text-muted">
<i class="bx bx-info-circle me-1"></i>
Ini adalah daftar tunjangan dan potongan yang terikat pada akun Anda.
Komponen ini digunakan untuk menghitung gaji bulanan Anda.
</p>
</div>
</div>
</div>

<!--  -->

<!-- Kolom Tunjangan -->
<div class="col-md-6">
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0 text-success">
                <i class="bx bx-plus-circle me-1"></i> Tunjangan (Pendapatan)
            </h5>
        </div>
        <div class="card-body">
            <ul class="list-group list-group-flush">
                @forelse ($allowances as $component)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>{{ $component->nama_komponen }}</span>
                        <strong class="text-success">
                            Rp {{ number_format($component->pivot->jumlah, 0, ',', '.') }}
                        </strong>
                    </li>
                @empty
                    <li class="list-group-item text-muted text-center">
                        Anda tidak memiliki komponen tunjangan.
                    </li>
                @endforelse
            </ul>
        </div>
    </div>
</div>

<!-- Kolom Potongan -->
<div class="col-md-6">
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0 text-danger">
                <i class="bx bx-minus-circle me-1"></i> Potongan
            </h5>
        </div>
        <div class="card-body">
            <ul class="list-group list-group-flush">
                @forelse ($deductions as $component)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>{{ $component->nama_komponen }}</span>
                        <strong class="text-danger">
                            (Rp {{ number_format($component->pivot->jumlah, 0, ',', '.') }})
                        </strong>
                    </li>
                @empty
                    <li class="list-group-item text-muted text-center">
                        Anda tidak memiliki komponen potongan.
                    </li>
                @endforelse
            </ul>
        </div>
    </div>
</div>


</div>
@endsection