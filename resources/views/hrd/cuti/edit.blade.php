@extends('layouts.app')

@section('title', 'Edit & Validasi Cuti')

@section('content')

    <div class="row">
        <!-- Form -->
        <div class="col-lg-8 col-md-12">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Formulir Edit Cuti Karyawan</h5>
                    <a href="{{ route('hrd.cuti.index') }}" class="btn btn-secondary btn-sm">
                        <i class="bx bx-arrow-back me-1"></i> Kembali
                    </a>
                </div>
                <div class="card-body">
                    <form action="{{ route('hrd.cuti.update', $cuti) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label" for="employee_id">Karyawan <span class="text-danger">*</span></label>
                            <select id="employee_id" name="employee_id"
                                class="form-select @error('employee_id') is-invalid @enderror" required>
                                <option value="">Pilih Karyawan...</option>
                                @foreach ($employees as $employee)
                                    <option value="{{ $employee->id }}" {{ old('employee_id', $cuti->employee_id) == $employee->id ? 'selected' : '' }}>
                                        {{ $employee->nama_lengkap }} ({{ $employee->nik }})
                                    </option>
                                @endforeach
                            </select>
                            @error('employee_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="tanggal_mulai">Tanggal Mulai <span
                                        class="text-danger">*</span></label>
                                <input type="date" class="form-control @error('tanggal_mulai') is-invalid @enderror"
                                    id="tanggal_mulai" name="tanggal_mulai"
                                    value="{{ old('tanggal_mulai', $cuti->tanggal_mulai->format('Y-m-d')) }}" required />
                                @error('tanggal_mulai') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="tanggal_selesai">Tanggal Selesai <span
                                        class="text-danger">*</span></label>
                                <input type="date" class="form-control @error('tanggal_selesai') is-invalid @enderror"
                                    id="tanggal_selesai" name="tanggal_selesai"
                                    value="{{ old('tanggal_selesai', $cuti->tanggal_selesai->format('Y-m-d')) }}"
                                    required />
                                @error('tanggal_selesai') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="alasan">Alasan Cuti <span class="text-danger">*</span></label>
                            <textarea id="alasan" name="alasan" class="form-control @error('alasan') is-invalid @enderror"
                                rows="3" required>{{ old('alasan', $cuti->alasan) }}</textarea>
                            @error('alasan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="status">Status Pengajuan <span
                                    class="text-danger">*</span></label>
                            <select id="status" name="status" class="form-select @error('status') is-invalid @enderror"
                                required>
                                <option value="pending" {{ old('status', $cuti->status) == 'pending' ? 'selected' : '' }}>
                                    Pending</option>
                                <option value="approved_hrd" {{ old('status', $cuti->status) == 'approved_hrd' ? 'selected' : '' }}>
                                    Disetujui</option>
                                <option value="rejected" {{ old('status', $cuti->status) == 'rejected' ? 'selected' : '' }}>
                                    Ditolak
                                </option>
                            </select>
                            <small class="form-text text-muted">Jika status diubah menjadi Disetujui, nama Anda akan
                                tercatat sebagai approver.</small>
                            @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection