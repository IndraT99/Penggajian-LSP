@extends('layouts.app')

@section('title', 'Tambah Jabatan Baru')

@section('content')
<div class="row">
    <div class="col-lg-8 col-md-12">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Formulir Jabatan Baru</h5>
                <a href="{{ route('admin.jabatans.index') }}" class="btn btn-secondary btn-sm">
                    <i class="bx bx-arrow-back me-1"></i> Kembali
                </a>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.jabatans.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label" for="nama_jabatan">Nama Jabatan</label>
                        <input type="text" class="form-control @error('nama_jabatan') is-invalid @enderror"
                            id="nama_jabatan" name="nama_jabatan" value="{{ old('nama_jabatan') }}"
                            placeholder="Contoh: Manajer Pemasaran" required />
                        @error('nama_jabatan')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="deskripsi">Deskripsi (Opsional)</label>
                        <textarea id="deskripsi" name="deskripsi"
                            class="form-control @error('deskripsi') is-invalid @enderror" rows="3"
                            placeholder="Tugas dan tanggung jawab...">{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Simpan Jabatan</button>
                </form>
            </div>
        </div>
    </div>
</div>


@endsection
