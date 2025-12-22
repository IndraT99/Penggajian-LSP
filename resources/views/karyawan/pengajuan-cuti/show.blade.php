@extends('layouts.app')

@section('title', 'Detail Pengajuan Cuti')

@section('content')
<div class="row">
    <div class="col-lg-8 col-md-12">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Detail Pengajuan Cuti</h5>
                <a href="{{ route('karyawan.pengajuan-cuti.index') }}" class="btn btn-secondary btn-sm">
                    <i class="bx bx-arrow-back me-1"></i> Kembali
                </a>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <label class="col-sm-4 col-form-label">Status Pengajuan</label>
                    <div class="col-sm-8">
                        @if ($pengajuan_cuti->status == 'approved_hrd')
                            <span class="badge bg-label-success fs-6">Disetujui</span>
                        @elseif ($pengajuan_cuti->status == 'pending')
                            <span class="badge bg-label-warning fs-6">Pending</span>
                        @else
                            <span class="badge bg-label-danger fs-6">Ditolak</span>
                        @endif
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-4 col-form-label">Nama Karyawan</label>
                    <div class="col-sm-8">
                        <p class="form-control-plaintext">{{ $pengajuan_cuti->employee->nama_lengkap }}</p>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-4 col-form-label">Tanggal Mulai</label>
                    <div class="col-sm-8">
                        <p class="form-control-plaintext">{{ $pengajuan_cuti->tanggal_mulai->format('d F Y') }}</p>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-4 col-form-label">Tanggal Selesai</label>
                    <div class="col-sm-8">
                        <p class="form-control-plaintext">{{ $pengajuan_cuti->tanggal_selesai->format('d F Y') }}</p>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-4 col-form-label">Total Hari</label>
                    <div class="col-sm-8">
                        <p class="form-control-plaintext">{{ $pengajuan_cuti->total_hari }} hari</p>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-4 col-form-label">Alasan Cuti</label>
                    <div class="col-sm-8">
                        <p class="form-control-plaintext">{{ $pengajuan_cuti->alasan }}</p>
                    </div>
                </div>
                
                @if($pengajuan_cuti->status != 'pending')
                <div class="row mb-3">
                    <label class="col-sm-4 col-form-label">Ditinjau oleh (HRD)</label>
                    <div class="col-sm-8">
                        <p class="form-control-plaintext">{{ $pengajuan_cuti->approvedBy->name ?? 'N/A' }}</p>
                    </div>
                </div>
                @endif

                @if ($pengajuan_cuti->status == 'pending')
                    <div class="d-flex justify-content-start gap-2 mt-4">
                        <a href="{{ route('karyawan.pengajuan-cuti.edit', $pengajuan_cuti->id) }}" class="btn btn-info">
                            <i class="bx bx-edit-alt me-1"></i> Edit Pengajuan
                        </a>
                        <form action="{{ route('karyawan.pengajuan-cuti.destroy', $pengajuan_cuti->id) }}" method="POST"
                            onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pengajuan ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="bx bx-trash me-1"></i> Batalkan Pengajuan
                            </button>
                        </form>
                    </div>
                @endif
                
            </div>
        </div>
    </div>
</div>
@endsection