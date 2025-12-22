@extends('layouts.app')

@section('title', 'Slip Gaji Saya')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Riwayat Slip Gaji Anda</h5>
            </div>
            <div class="card-body">
                <p class="text-muted">
                    Halaman ini hanya menampilkan slip gaji yang telah disetujui oleh Departemen Keuangan.
                    Jika slip gaji untuk periode terbaru belum muncul, mohon tunggu proses persetujuan.
                </p>
            </div>
            <div class="table-responsive text-nowrap">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Periode</th>
                            <th>Gaji Bersih (Take Home Pay)</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @forelse ($payrolls as $index => $payroll)
                            <tr>
                                <td>{{ $payrolls->firstItem() + $index }}</td>
                                <td>
                                    <span class="fw-semibold">
                                        {{ \Carbon\Carbon::create()->month($payroll->bulan)->translatedFormat('F') }} {{ $payroll->tahun }}
                                    </span>
                                </td>
                                <td>
                                    <strong class="text-primary">Rp {{ number_format($payroll->gaji_bersih, 0, ',', '.') }}</strong>
                                </td>
                                <td>
                                    @if ($payroll->status == 'approved_finance')
                                        <span class="badge bg-label-success">Disetujui</span>
                                    @elseif ($payroll->status == 'paid')
                                        <span class="badge bg-label-primary">Telah Dibayar</span>
                                    @endif
                                </td>
                                <td>
                                    <a class="btn btn-sm btn-info"
                                        href="{{ route('karyawan.slip.show', $payroll->id) }}">
                                        <i class="bx bx-receipt me-1"></i> Lihat Slip
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">
                                    <h5 class="my-3">Belum Ada Slip Gaji</h5>
                                    <p>Slip gaji Anda untuk periode sebelumnya belum tersedia atau belum disetujui.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if ($payrolls->hasPages())
                <div class="card-footer d-flex justify-content-center">
                    {{ $payrolls->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection