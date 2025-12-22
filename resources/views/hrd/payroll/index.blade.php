@extends('layouts.app')

@section('title', 'Proses Gaji Karyawan')

@section('content')

<!-- Card Filter -->

<div class="card mb-4">
    <div class="card-header">
        <h5 class="mb-0">Filter Data Gaji</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('hrd.payroll.index') }}" method="GET" class="row g-3">
            <div class="col-md-3">
                <label class="form-label" for="bulan">Bulan</label>
                <select id="bulan" name="bulan" class="form-select">
                    @for ($i = 1; $i <= 12; $i++) <option value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}"
                        {{ $bulan == $i ? 'selected' : '' }}>
                        {{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}
                        </option>
                        @endfor
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label" for="tahun">Tahun</label>
                <select id="tahun" name="tahun" class="form-select">
                    @php $currentYear = now()->year; @endphp
                    @for ($i = $currentYear + 1; $i >= $currentYear - 4; $i--)
                    <option value="{{ $i }}" {{ $tahun == $i ? 'selected' : '' }}>{{ $i }}</option>
                    @endfor
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label" for="status">Status</label>
                <select id="status" name="status" class="form-select">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ $status == 'pending' ? 'selected' : '' }}>Pending (Menunggu Keuangan)
                    </option>
                    <option value="approved_finance" {{ $status == 'approved_finance' ? 'selected' : '' }}>Disetujui
                    </option>
                    <option value="rejected" {{ $status == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                    <option value="paid" {{ $status == 'paid' ? 'selected' : '' }}>Telah Dibayar</option>
                </select>
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="bx bx-filter-alt me-1"></i> Filter
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Card Tabel Payroll -->

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Data Gaji ({{ \Carbon\Carbon::create()->month($bulan)->translatedFormat('F') }} {{ $tahun }})
        </h5>
        <a href="{{ route('hrd.payroll.generate') }}" class="btn btn-primary">
            <i class="bx bx-plus me-1"></i> Generate Gaji Baru
        </a>
    </div>
    <div class="table-responsive text-nowrap">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>No</th>
                    <th>NIK</th>
                    <th>Karyawan</th>
                    <th>Gaji Bersih</th>
                    <th>Status</th>
                    <th>Dibuat Oleh</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @forelse ($payrolls as $index => $payroll)
                <tr>
                    <td>{{ $payrolls->firstItem() + $index }}</td>
                    <td>{{ $payroll->employee->nik }}</td>
                    <td><strong>{{ $payroll->employee->nama_lengkap }}</strong></td>
                    <td><strong>Rp {{ number_format($payroll->gaji_bersih, 0, ',', '.') }}</strong></td>
                    <td>
                        @if ($payroll->status == 'approved_finance') <span class="badge bg-label-success">Disetujui
                            Keuangan</span>
                        @elseif ($payroll->status == 'paid') <span class="badge bg-label-primary">Telah Dibayar</span>
                        @elseif ($payroll->status == 'pending') <span class="badge bg-label-warning">Pending</span>
                        @else <span class="badge bg-label-danger" data-bs-toggle="tooltip"
                            title="Alasan: {{ $payroll->catatan_revisi ?? 'N/A' }}">Ditolak</span>
                        @endif
                    </td>
                    <td>{{ $payroll->generatedBy->name ?? '-' }}</td>
                    <td>
                        <a class="btn btn-sm btn-icon btn-dark" href="{{ route('hrd.payroll.slip', $payroll->id) }}"
                            data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="top"
                            title="Lihat Slip Gaji">
                            <i class="bx bx-receipt"></i>
                        </a>
                        <!-- HRD tidak bisa hapus/edit jika sudah diapprove -->
                        @if ($payroll->status == 'pending' || $payroll->status == 'rejected')
                        <!-- Tambahkan tombol edit/hapus jika perlu -->
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center">
                        Tidak ada data gaji ditemukan untuk periode ini.
                        <a href="{{ route('hrd.payroll.generate') }}" class="d-block mt-2">Generate Gaji Sekarang?</a>
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
