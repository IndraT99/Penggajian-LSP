@extends('layouts.app')

@section('title', 'Input Absensi Baru')

@section('content')
<div class="row">
    <!-- Form -->
    <div class="col-lg-8 col-md-12">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Formulir Input Absensi</h5>
                <a href="{{ route('hrd.absensi.index') }}" class="btn btn-secondary btn-sm">
                    <i class="bx bx-arrow-back me-1"></i> Kembali
                </a>
            </div>
            <div class="card-body">
                <form action="{{ route('hrd.absensi.store') }}" method="POST">
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
                        <label class="form-label" for="tanggal">Tanggal <span class="text-danger">*</span></label>
                        <input type="date" class="form-control @error('tanggal') is-invalid @enderror" id="tanggal"
                            name="tanggal" value="{{ old('tanggal', now()->format('Y-m-d')) }}" required />
                        @error('tanggal')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="status">Status Kehadiran <span
                                class="text-danger">*</span></label>
                        <select id="status" name="status" class="form-select @error('status') is-invalid @enderror"
                            required>
                            <option value="hadir" {{ old('status') == 'hadir' ? 'selected' : '' }}>Hadir</option>
                            <option value="sakit" {{ old('status') == 'sakit' ? 'selected' : '' }}>Sakit</option>
                            <option value="izin" {{ old('status') == 'izin' ? 'selected' : '' }}>Izin</option>
                            <option value="alpa" {{ old('status') == 'alpa' ? 'selected' : '' }}>Alpa</option>
                            <option value="cuti" {{ old('status') == 'cuti' ? 'selected' : '' }}>Cuti</option>
                        </select>
                        @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="jam_masuk">Jam Masuk (Opsional)</label>
                            <input type="time" class="form-control @error('jam_masuk') is-invalid @enderror"
                                id="jam_masuk" name="jam_masuk" value="{{ old('jam_masuk') }}" />
                            @error('jam_masuk') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="jam_pulang">Jam Pulang (Opsional)</label>
                            <input type="time" class="form-control @error('jam_pulang') is-invalid @enderror"
                                id="jam_pulang" name="jam_pulang" value="{{ old('jam_pulang') }}" />
                            @error('jam_pulang') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="keterangan">Keterangan (Opsional)</label>
                        <textarea id="keterangan" name="keterangan" class="form-control"
                            rows="3">{{ old('keterangan') }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">Simpan Data Absensi</button>
                </form>
            </div>
        </div>
    </div>
</div>


@endsection
