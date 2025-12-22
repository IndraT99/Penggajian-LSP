@extends('layouts.app')

@section('title', 'Tambah Divisi Baru')

@section('content')
<div class="row">
    <div class="col-lg-6 col-md-12">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Formulir Divisi Baru</h5>
                <a href="{{ route('admin.divisis.index') }}" class="btn btn-secondary btn-sm">
                    <i class="bx bx-arrow-back me-1"></i> Kembali
                </a>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.divisis.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label" for="nama_divisi">Nama Divisi</label>
                        <input type="text" class="form-control @error('nama_divisi') is-invalid @enderror"
                            id="nama_divisi" name="nama_divisi" value="{{ old('nama_divisi') }}"
                            placeholder="Contoh: Keuangan" required />
                        @error('nama_divisi')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Simpan Divisi</button>
                </form>
            </div>
        </div>
    </div>
</div>


@endsection
