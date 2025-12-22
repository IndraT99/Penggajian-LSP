@extends('layouts.app')

@section('title', 'Edit Pengajuan Cuti')

@section('content')
<div class="row">
    <div class="col-lg-8 col-md-12">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Formulir Edit Pengajuan Cuti</h5>
                <a href="{{ route('karyawan.pengajuan-cuti.index') }}" class="btn btn-secondary btn-sm">
                    <i class="bx bx-arrow-back me-1"></i> Kembali
                </a>
            </div>
            <div class="card-body">
                <div class="alert alert-warning" role="alert">
                    <i class="bx bx-info-circle me-2"></i>
                    Anda hanya dapat mengedit pengajuan yang masih berstatus <strong>Pending</strong>.
                </div>
                
                <form action="{{ route('karyawan.pengajuan-cuti.update', $pengajuan_cuti->id) }}" method="POST">
                    @csrf
                    @method('PUT') <div class="mb-3">
                        <label class="form-label" for="karyawan">Mengajukan Sebagai</label>
                        <input type="text" class="form-control" id="karyawan" 
                               value="{{ $pengajuan_cuti->employee->nama_lengkap }} ({{ $pengajuan_cuti->employee->nik }})" 
                               disabled />
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="tanggal_mulai">Tanggal Mulai <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('tanggal_mulai') is-invalid @enderror" 
                                   id="tanggal_mulai" name="tanggal_mulai" 
                                   value="{{ old('tanggal_mulai', $pengajuan_cuti->tanggal_mulai->format('Y-m-d')) }}" required />
                            @error('tanggal_mulai') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="tanggal_selesai">Tanggal Selesai <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('tanggal_selesai') is-invalid @enderror" 
                                   id="tanggal_selesai" name="tanggal_selesai" 
                                   value="{{ old('tanggal_selesai', $pengajuan_cuti->tanggal_selesai->format('Y-m-d')) }}" required />
                            @error('tanggal_selesai') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="alasan">Alasan Cuti <span class="text-danger">*</span></label>
                        <textarea id="alasan" name="alasan" class="form-control @error('alasan') is-invalid @enderror" 
                                  rows="3" required>{{ old('alasan', $pengajuan_cuti->alasan) }}</textarea>
                        @error('alasan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Update Pengajuan</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection