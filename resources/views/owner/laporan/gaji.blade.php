@extends('layouts.app')

@section('title', 'Laporan Gaji Karyawan')

@section('content')

<!-- Card Filter -->

<div class="card mb-4">
    <div class="card-header">
        <h5 class="mb-0">Filter Laporan Gaji</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('owner.laporan.gaji') }}" method="GET" class="row g-3">
            <div class="col-md-4">
                <label class="form-label" for="bulan">Bulan</label>
                <select id="bulan" name="bulan" class="form-select">
                    @for ($i = 1; $i <= 12; $i++) <option value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}"
                        {{ $bulan == $i ? 'selected' : '' }}>
                        {{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}
                        </option>
                        @endfor
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label" for="tahun">Tahun</label>
                <select id="tahun" name="tahun" class="form-select">
                    @php $currentYear = now()->year; @endphp
                    @for ($i = $currentYear + 1; $i >= $currentYear - 4; $i--)
                    <option value="{{ $i }}" {{ $tahun == $i ? 'selected' : '' }}>{{ $i }}</option>
                    @endfor
                </select>
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="bx bx-filter-alt me-1"></i> Tampilkan Laporan
                </button>
            </div>
        </form>
    </div>
</div>

<!--  -->

<!-- Kartu Statistik Agregat -->

<div class="row g-4 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-start justify-content-between">
                    <div class="content-left">
                        <span>Total Gaji Bersih</span>
                        <div class="d-flex align-items-end mt-2">
                            <h3 class="mb-0 me-2">Rp
                                {{ number_format($aggregates->total_gaji_bersih ?? 0, 0, ',', '.') }}</h3>
                        </div>
                        <small>Total (Take Home Pay) Karyawan</small>
                    </div>
                    <span class="avatar-initial rounded bg-label-primary"><i class="bx bx-wallet"></i></span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-start justify-content-between">
                    <div class="content-left">
                        <span>Total Karyawan</span>
                        <div class="d-flex align-items-end mt-2">
                            <h3 class="mb-0 me-2">{{ $aggregates->total_karyawan ?? 0 }}</h3>
                        </div>
                        <small>Karyawan yang dibayar periode ini</small>
                    </div>
                    <span class="avatar-initial rounded bg-label-success"><i class="bx bx-user-check"></i></span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-start justify-content-between">
                    <div class="content-left">
                        <span>Total Tunjangan</span>
                        <div class="d-flex align-items-end mt-2">
                            <h3 class="mb-0 me-2">Rp {{ number_format($aggregates->total_tunjangan ?? 0, 0, ',', '.') }}
                            </h3>
                        </div>
                        <small>Termasuk Gaji Pokok & Lembur</small>
                    </div>
                    <span class="avatar-initial rounded bg-label-info"><i class="bx bx-up-arrow-alt"></i></span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-start justify-content-between">
                    <div class="content-left">
                        <span>Total Potongan</span>
                        <div class="d-flex align-items-end mt-2">
                            <h3 class="mb-0 me-2">Rp {{ number_format($aggregates->total_potongan ?? 0, 0, ',', '.') }}
                            </h3>
                        </div>
                        <small>Total potongan (BPJS, dll)</small>
                    </div>
                    <span class="avatar-initial rounded bg-label-danger"><i class="bx bx-down-arrow-alt"></i></span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Card Tabel Rincian -->

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Rincian Laporan Gaji ({{ \Carbon\Carbon::create()->month($bulan)->translatedFormat('F') }}
            {{ $tahun }})</h5>
        <small class="text-muted">Hanya menampilkan data yang berstatus "Disetujui" atau "Telah Dibayar"</small>
    </div>
    <div class="table-responsive text-nowrap">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>No</th>
                    <th>NIK</th>
                    <th>Karyawan</th>
                    <th>Gaji Pokok</th>
                    <th>Tunjangan</th>
                    <th>Lembur</th>
                    <th>Potongan</th>
                    <th>Gaji Bersih</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @forelse ($payrolls as $index => $payroll)
                <tr>
                    <td>{{ $payrolls->firstItem() + $index }}</td>
                    <td>{{ $payroll->employee->nik ?? 'N/A' }}</td>
                    <td><strong>{{ $payroll->employee->nama_lengkap ?? 'Karyawan Terhapus' }}</strong></td>
                    <td>Rp {{ number_format($payroll->gaji_pokok, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($payroll->total_tunjangan, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($payroll->total_lembur, 0, ',', '.') }}</td>
                    <td>(Rp {{ number_format($payroll->total_potongan, 0, ',', '.') }})</td>
                    <td><strong>Rp {{ number_format($payroll->gaji_bersih, 0, ',', '.') }}</strong></td>
                    <td>
                        @if ($payroll->status == 'approved_finance')
                        <span class="badge bg-label-success">Disetujui</span>
                        @elseif ($payroll->status == 'paid')
                        <span class="badge bg-label-primary">Telah Dibayar</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center">
                        Tidak ada data gaji yang telah disetujui untuk periode ini.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <!-- Paginasi -->
    @if ($payrolls->hasPages())
    <div class="card-footer d-flex justify-content-center">
        {{ $payrolls->appends(request()->query())->links() }}
        <!-- appends agar filter tetap terbawa -->
    </div>
    @endif
</div>
@endsection
