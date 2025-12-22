@extends('layouts.app')

@section('title', 'Buat Pengajuan Lembur Baru')

@section('content')

<div class="row">
<!-- Form -->
<div class="col-lg-8 col-md-12">
<div class="card mb-4">
<div class="card-header d-flex justify-content-between align-items-center">
<h5 class="mb-0">Formulir Pengajuan Lembur</h5>
<a href="{{ route('karyawan.pengajuan-lembur.index') }}" class="btn btn-secondary btn-sm">
<i class="bx bx-arrow-back me-1"></i> Kembali
</a>
</div>
<div class="card-body">
<div class="alert alert-info" role="alert">
<i class="bx bx-info-circle me-2"></i>
Pengajuan Anda akan berstatus <strong>Pending</strong>. Biaya lembur akan ditentukan oleh HRD saat persetujuan.
</div>

            <form action="{{ route('karyawan.pengajuan-lembur.store') }}" method="POST">
                @csrf
                
                <!-- Input Karyawan (Disabled) -->
                <div class="mb-3">
                    <label class="form-label" for="karyawan">Mengajukan Sebagai</label>
                    <input type="text" class="form-control" id="karyawan" 
                           value="{{ $employee->nama_lengkap }} ({{ $employee->nik }})" 
                           disabled />
                </div>

                <div class="mb-3">
                    <label class="form-label" for="tanggal">Tanggal Lembur <span class="text-danger">*</span></label>
                    <input type="date" class="form-control @error('tanggal') is-invalid @enderror" 
                           id="tanggal" name="tanggal" 
                           value="{{ old('tanggal') }}" required />
                    @error('tanggal') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="jam_mulai">Jam Mulai <span class="text-danger">*</span></label>
                        <input type="time" class="form-control @error('jam_mulai') is-invalid @enderror" 
                               id="jam_mulai" name="jam_mulai" 
                               value="{{ old('jam_mulai') }}" required />
                        @error('jam_mulai') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="jam_selesai">Jam Selesai <span class="text-danger">*</span></label>
                        <input type="time" class="form-control @error('jam_selesai') is-invalid @enderror" 
                               id="jam_selesai" name="jam_selesai" 
                               value="{{ old('jam_selesai') }}" required />
                        @error('jam_selesai') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="alasan_lembur">Alasan/Aktivitas Lembur <span class="text-danger">*</span></label>
                    <textarea id="alasan_lembur" name="alasan_lembur" class="form-control @error('alasan_lembur') is-invalid @enderror" 
                              rows="3" placeholder="Contoh: Mengerjakan revisi proyek X" required>{{ old('alasan_lembur') }}</textarea>
                    @error('alasan_lembur') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <button type="submit" class="btn btn-primary">Kirim Pengajuan</button>
            </form>
        </div>
    </div>
</div>


</div>
@endsection