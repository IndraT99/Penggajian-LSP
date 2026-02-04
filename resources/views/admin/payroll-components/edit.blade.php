@extends('layouts.app')

@section('title', 'Edit Komponen Gaji')

@section('content')
<div class="row">
    <div class="col-lg-8 col-md-12">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Formulir Edit Komponen Gaji</h5>
                <a href="{{ route('admin.payroll-components.index') }}" class="btn btn-secondary btn-sm">
                    <i class="bx bx-arrow-back me-1"></i> Kembali
                </a>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.payroll-components.update', $payrollComponent) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label" for="nama_komponen">Nama Komponen</label>
                        <input type="text" class="form-control @error('nama_komponen') is-invalid @enderror"
                            id="nama_komponen" name="nama_komponen"
                            value="{{ old('nama_komponen', $payrollComponent->nama_komponen) }}" required />
                        @error('nama_komponen')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="tipe">Tipe Komponen</label>
                        <select class="form-select @error('tipe') is-invalid @enderror" id="tipe" name="tipe" required>
                            <option value="allowance"
                                {{ old('tipe', $payrollComponent->tipe) == 'allowance' ? 'selected' : '' }}>Tunjangan
                                (Penambah Gaji)</option>
                            <option value="deduction"
                                {{ old('tipe', $payrollComponent->tipe) == 'deduction' ? 'selected' : '' }}>Potongan
                                (Pengurang Gaji)</option>
                        </select>
                        @error('tipe')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="jumlah_default">Jumlah Default (Opsional)</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" class="form-control @error('jumlah_default') is-invalid @enderror"
                                id="jumlah_default" name="jumlah_default"
                                value="{{ old('jumlah_default', $payrollComponent->jumlah_default) }}" min="0"
                                step="1000" />
                        </div>
                        @error('jumlah_default')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="1" id="is_fixed" name="is_fixed"
                                {{ old('is_fixed', $payrollComponent->is_fixed) ? 'checked' : '' }} />
                            <label class="form-check-label" for="is_fixed">
                                Fixed (Jumlah tidak akan berubah per karyawan)
                            </label>
                        </div>
                        <small class="form-text text-muted">
                            Jika dicentang, jumlah default di atas akan berlaku. Jika tidak, jumlah akan diisi manual
                            per karyawan.
                        </small>
                    </div>

                    <button type="submit" class="btn btn-primary">Update Komponen</button>
                </form>
            </div>
        </div>
    </div>
</div>


@endsection
