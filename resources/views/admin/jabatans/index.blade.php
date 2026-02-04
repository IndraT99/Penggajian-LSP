@extends('layouts.app')

@section('title', 'Data Jabatan')

@section('content')

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Data Master Jabatan</h5>
            <a href="{{ route('admin.jabatans.create') }}" class="btn btn-primary">
                <i class="bx bx-plus me-1"></i> Tambah Jabatan
            </a>
        </div>
        <div class="table-responsive text-nowrap">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Jabatan</th>
                        <th>Deskripsi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @forelse ($jabatans as $index => $jabatan)
                        <tr>
                            <td>{{ $jabatans->firstItem() + $index }}</td>
                            <td><strong>{{ $jabatan->nama_jabatan }}</strong></td>

                            <td>{{ Str::limit($jabatan->deskripsi, 80, '...') }}</td>

                            <td>
                                <div class="d-flex">
                                    <a class="btn btn-sm btn-icon btn-info me-2"
                                        href="{{ route('admin.jabatans.edit', $jabatan) }}" data-bs-toggle="tooltip"
                                        data-bs-offset="0,4" data-bs-placement="top" title="Edit Jabatan">
                                        <i class="bx bx-edit-alt"></i>
                                    </a>

                                    <form action="{{ route('admin.jabatans.destroy', $jabatan) }}" method="POST"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-icon btn-danger" data-bs-toggle="tooltip"
                                            data-bs-offset="0,4" data-bs-placement="top" title="Hapus Jabatan">
                                            <i class="bx bx-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">Tidak ada data jabatan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <!-- Paginasi -->
        @if ($jabatans->hasPages())
            <div class="card-footer d-flex justify-content-center">
                {{ $jabatans->links() }}
            </div>
        @endif


    </div>
@endsection