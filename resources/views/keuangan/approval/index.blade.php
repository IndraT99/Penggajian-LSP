@extends('layouts.app')

@section('title', 'Persetujuan Gaji Karyawan')

@section('content')

    <!-- Card Filter -->

    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">Filter Data Gaji</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('keuangan.approval.index') }}" method="GET" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label" for="bulan">Bulan</label>
                    <select id="bulan" name="bulan" class="form-select">
                        <option value="">Semua Bulan</option>
                        @for ($i = 1; $i <= 12; $i++)
                            <option value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}" {{ $bulan == $i ? 'selected' : '' }}>
                                {{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}
                            </option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label" for="tahun">Tahun</label>
                    <select id="tahun" name="tahun" class="form-select">
                        <option value="">Semua Tahun</option>
                        @php $currentYear = now()->year; @endphp
                        @for ($i = $currentYear + 1; $i >= $currentYear - 4; $i--)
                            <option value="{{ $i }}" {{ $tahun == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label" for="status">Status</label>
                    <select id="status" name="status" class="form-select">
                        <option value="pending" {{ $status == 'pending' ? 'selected' : '' }}>Pending (Menunggu Persetujuan)
                        </option>
                        <option value="approved_finance" {{ $status == 'approved_finance' ? 'selected' : '' }}>Disetujui
                        </option>
                        <option value="rejected" {{ $status == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                        <option value="paid" {{ $status == 'paid' ? 'selected' : '' }}>Telah Dibayar</option>
                        <option value="" {{ !$status ? 'selected' : '' }}>Semua Status</option>
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
            <h5 class="mb-0">
                Data Gaji
                @if($bulan && $tahun)
                    ({{ \Carbon\Carbon::create()->month($bulan)->translatedFormat('F') }} {{ $tahun }})
                @else
                    (Semua Periode)
                @endif
            </h5>
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
                        <th>Dibuat Oleh (HRD)</th>
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
                                @if ($payroll->status == 'approved_finance')
                                    <span class="badge bg-label-success">Disetujui</span>
                                @elseif ($payroll->status == 'paid')
                                    <span class="badge bg-label-primary">Telah Dibayar</span>
                                @elseif ($payroll->status == 'pending')
                                    <span class="badge bg-label-warning">Pending</span>
                                @else
                                    <!-- Tooltip untuk melihat alasan ditolak -->
                                    <span class="badge bg-label-danger" data-bs-toggle="tooltip" data-bs-offset="0,4"
                                        data-bs-placement="top" title="Alasan: {{ $payroll->catatan_revisi ?? 'N/A' }}">
                                        Ditolak
                                    </span>
                                @endif
                            </td>
                            <td>{{ $payroll->generatedBy->name ?? '-' }}</td>
                            <td>
                                <!-- Tombol Review -->
                                <a class="btn btn-sm btn-icon btn-info"
                                    href="{{ route('keuangan.approval.show', ['payroll' => $payroll, 'status' => $status, 'bulan' => $bulan, 'tahun' => $tahun]) }}"
                                    data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="top" title="Review Gaji">
                                    <i class="bx bx-show"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">
                                Tidak ada data gaji yang memerlukan persetujuan untuk periode ini.
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