@extends('layouts.app')

@section('title', 'Kelola Karyawan')

@section('content')

    <!-- Card Filter -->

    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">Filter Karyawan</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('hrd.karyawan.index') }}" method="GET" class="row g-3">
                <div class="col-md-4">
                    <label class="form-label" for="jabatan_id">Jabatan</label>
                    <select id="jabatan_id" name="jabatan_id" class="form-select">
                        <option value="">Semua Jabatan</option>
                        @foreach ($jabatans as $jabatan)
                            <option value="{{ $jabatan->id }}" {{ request('jabatan_id') == $jabatan->id ? 'selected' : '' }}>
                                {{ $jabatan->nama_jabatan }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label" for="divisi_id">Divisi</label>
                    <select id="divisi_id" name="divisi_id" class="form-select">
                        <option value="">Semua Divisi</option>
                        @foreach ($divisis as $divisi)
                            <option value="{{ $divisi->id }}" {{ request('divisi_id') == $divisi->id ? 'selected' : '' }}>
                                {{ $divisi->nama_divisi }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label" for="status_karyawan">Status</label>
                    <select id="status_karyawan" name="status_karyawan" class="form-select">
                        <option value="">Semua Status</option>
                        <option value="aktif" {{ request('status_karyawan') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="non_aktif" {{ request('status_karyawan') == 'non_aktif' ? 'selected' : '' }}>
                            Non-Aktif</option>
                        <option value="resign" {{ request('status_karyawan') == 'resign' ? 'selected' : '' }}>Resign
                        </option>
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bx bx-filter-alt me-1"></i> Filter
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Card Tabel Karyawan -->

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Data Karyawan</h5>
            <a href="{{ route('hrd.karyawan.create') }}" class="btn btn-primary">
                <i class="bx bx-plus me-1"></i> Tambah Karyawan
            </a>
        </div>
        <div class="table-responsive text-nowrap">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NIK</th>
                        <th>Nama</th>
                        <th>Jabatan</th>
                        <th>Divisi</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @forelse ($employees as $index => $karyawan)
                        <tr>
                            <td>{{ $employees->firstItem() + $index }}</td>
                            <td>{{ $karyawan->nik }}</td>
                            <td><strong>{{ $karyawan->nama_lengkap }}</strong></td>
                            <td>{{ $karyawan->jabatan->nama_jabatan ?? '-' }}</td>
                            <td>{{ $karyawan->divisi->nama_divisi ?? '-' }}</td>
                            <td>
                                @if ($karyawan->status_karyawan == 'aktif')
                                    <span class="badge bg-label-success">Aktif</span>
                                @elseif ($karyawan->status_karyawan == 'non_aktif')
                                    <span class="badge bg-label-secondary">Non-Aktif</span>
                                @else
                                    <span class="badge bg-label-danger">Resign</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex">
                                    <a class="btn btn-sm btn-icon btn-dark me-2"
                                        href="{{ route('hrd.karyawan.show', $karyawan) }}" data-bs-toggle="tooltip"
                                        data-bs-offset="0,4" data-bs-placement="top" title="Detail Karyawan">
                                        <i class="bx bx-show"></i>
                                    </a>
                                    <a class="btn btn-sm btn-icon btn-info me-2"
                                        href="{{ route('hrd.karyawan.edit', $karyawan) }}" data-bs-toggle="tooltip"
                                        data-bs-offset="0,4" data-bs-placement="top" title="Edit Karyawan">
                                        <i class="bx bx-edit-alt"></i>
                                    </a>
                                    <form action="{{ route('hrd.karyawan.destroy', $karyawan) }}" method="POST"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-icon btn-danger" data-bs-toggle="tooltip"
                                            data-bs-offset="0,4" data-bs-placement="top" title="Hapus Karyawan">
                                            <i class="bx bx-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">Tidak ada data karyawan ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <!-- Paginasi -->
        @if ($employees->hasPages())
            <div class="card-footer d-flex justify-content-center">
                {{ $employees->appends(request()->query())->links() }}
                <!-- appends agar filter tetap terbawa -->
            </div>
        @endif
    </div>
@endsection