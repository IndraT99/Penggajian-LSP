@extends('layouts.app')

@section('title', 'Data Divisi')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Data Master Divisi</h5>
            <a href="{{ route('admin.divisis.create') }}" class="btn btn-primary">
                <i class="bx bx-plus me-1"></i> Tambah Divisi
            </a>
        </div>
        <div class="table-responsive text-nowrap">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Divisi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @forelse ($divisis as $index => $divisi)
                        <tr>
                            <td>{{ $divisis->firstItem() + $index }}</td>
                            <td><strong>{{ $divisi->nama_divisi }}</strong></td>
                            <td>
                                <div class="d-flex">
                                    <a class="btn btn-sm btn-icon btn-info me-2"
                                        href="{{ route('admin.divisis.edit', $divisi) }}" data-bs-toggle="tooltip"
                                        data-bs-offset="0,4" data-bs-placement="top" title="Edit Divisi">
                                        <i class="bx bx-edit-alt"></i>
                                    </a>

                                    <form action="{{ route('admin.divisis.destroy', $divisi) }}" method="POST"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-icon btn-danger" data-bs-toggle="tooltip"
                                            data-bs-offset="0,4" data-bs-placement="top" title="Hapus Divisi">
                                            <i class="bx bx-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center">Tidak ada data divisi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($divisis->hasPages())
            <div class="card-footer d-flex justify-content-center">
                {{ $divisis->links() }}
            </div>
        @endif
    </div>


@endsection