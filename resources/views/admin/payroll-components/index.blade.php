@extends('layouts.app')

@section('title', 'Komponen Gaji')

@section('content')

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Data Master Komponen Gaji</h5>
            <a href="{{ route('admin.payroll-components.create') }}" class="btn btn-primary">
                <i class="bx bx-plus me-1"></i> Tambah Komponen
            </a>
        </div>
        <div class="table-responsive text-nowrap">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Komponen</th>
                        <th>Tipe</th>
                        <th>Fixed</th>
                        <th>Jumlah Default</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @forelse ($components as $index => $component)
                        <tr>
                            <td>{{ $components->firstItem() + $index }}</td>
                            <td><strong>{{ $component->nama_komponen }}</strong></td>
                            <td>
                                @if ($component->tipe == 'allowance')
                                    <span class="badge bg-label-success">Tunjangan</span>
                                @else
                                    <span class="badge bg-label-danger">Potongan</span>
                                @endif
                            </td>
                            <td>
                                @if ($component->is_fixed)
                                    <span class="badge bg-label-info">Ya</span>
                                @else
                                    <span class="badge bg-label-secondary">Tidak</span>
                                @endif
                            </td>
                            <td>Rp {{ number_format($component->jumlah_default, 0, ',', '.') }}</td>
                            <td>
                                <div class="d-flex">
                                    <a class="btn btn-sm btn-icon btn-info me-2"
                                        href="{{ route('admin.payroll-components.edit', $component) }}" data-bs-toggle="tooltip"
                                        data-bs-offset="0,4" data-bs-placement="top" title="Edit Komponen">
                                        <i class="bx bx-edit-alt"></i>
                                    </a>

                                    <form action="{{ route('admin.payroll-components.destroy', $component) }}" method="POST"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-icon btn-danger" data-bs-toggle="tooltip"
                                            data-bs-offset="0,4" data-bs-placement="top" title="Hapus Komponen">
                                            <i class="bx bx-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Tidak ada data komponen gaji.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($components->hasPages())
            <div class="card-footer d-flex justify-content-center">
                {{ $components->links() }}
            </div>
        @endif
    </div>
@endsection