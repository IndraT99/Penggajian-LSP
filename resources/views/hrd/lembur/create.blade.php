@extends('layouts.app')

@section('title', 'Input Lembur Baru')

@section('content')

<div class="row">
    <!-- Form -->
    <div class="col-lg-8 col-md-12">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Formulir Input Lembur Karyawan</h5>
                <a href="{{ route('hrd.lembur.index') }}" class="btn btn-secondary btn-sm">
                    <i class="bx bx-arrow-back me-1"></i> Kembali
                </a>
            </div>
            <div class="card-body">
                <form action="{{ route('hrd.lembur.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label" for="employee_id">Karyawan <span class="text-danger">*</span></label>
                        <select id="employee_id" name="employee_id"
                            class="form-select @error('employee_id') is-invalid @enderror" required>
                            <option value="">Pilih Karyawan...</option>
                            @foreach ($employees as $employee)
                            <option value="{{ $employee->id }}"
                                {{ old('employee_id') == $employee->id ? 'selected' : '' }}>
                                {{ $employee->nama_lengkap }} ({{ $employee->nik }})
                            </option>
                            @endforeach
                        </select>
                        @error('employee_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="tanggal">Tanggal Lembur <span
                                class="text-danger">*</span></label>
                        <input type="date" class="form-control @error('tanggal') is-invalid @enderror" id="tanggal"
                            name="tanggal" value="{{ old('tanggal') }}" required />
                        @error('tanggal') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="jam_mulai">Jam Mulai <span
                                    class="text-danger">*</span></label>
                            <input type="time" class="form-control @error('jam_mulai') is-invalid @enderror"
                                id="jam_mulai" name="jam_mulai" value="{{ old('jam_mulai') }}" required />
                            @error('jam_mulai') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="jam_selesai">Jam Selesai <span
                                    class="text-danger">*</span></label>
                            <input type="time" class="form-control @error('jam_selesai') is-invalid @enderror"
                                id="jam_selesai" name="jam_selesai" value="{{ old('jam_selesai') }}" required />
                            @error('jam_selesai') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="alasan_lembur">Alasan Lembur <span
                                class="text-danger">*</span></label>
                        <textarea id="alasan_lembur" name="alasan_lembur"
                            class="form-control @error('alasan_lembur') is-invalid @enderror" rows="3"
                            required>{{ old('alasan_lembur') }}</textarea>
                        @error('alasan_lembur') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="biaya_lembur">Biaya Lembur (Rp) <span
                                class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" class="form-control @error('biaya_lembur') is-invalid @enderror"
                                id="biaya_lembur" name="biaya_lembur" value="{{ old('biaya_lembur', 0) }}" min="0"
                                required />
                        </div>
                        @error('biaya_lembur') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="status">Status Pengajuan <span
                                class="text-danger">*</span></label>
                        <select id="status" name="status" class="form-select @error('status') is-invalid @enderror"
                            required>
                            <option value="pending" {{ old('status', 'pending') == 'pending' ? 'selected' : '' }}>
                                Pending</option>
                            <option value="approved_hrd" {{ old('status') == 'approved_hrd' ? 'selected' : '' }}>
                                Disetujui</option>
                            <option value="rejected" {{ old('status') == 'rejected' ? 'selected' : '' }}>Ditolak
                            </option>
                        </select>
                        <small class="form-text text-muted">Jika disetujui, akun Anda akan dicatat sebagai
                            approver.</small>
                        @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Simpan Data Lembur</button>
                </form>
            </div>
        </div>
    </div>


</div>
@endsection
