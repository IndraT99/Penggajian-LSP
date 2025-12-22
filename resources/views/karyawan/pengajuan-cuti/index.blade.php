@extends('layouts.app')

@section('title', 'Riwayat Pengajuan Cuti')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Riwayat Pengajuan Cuti Anda</h5>
        <a href="{{ route('karyawan.pengajuan-cuti.create') }}" class="btn btn-primary">
            <i class="bx bx-plus me-1"></i> Buat Pengajuan Baru
        </a>
    </div>
    <div class="table-responsive text-nowrap">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal Mulai</th>
                    <th>Tanggal Selesai</th>
                    <th>Total Hari</th>
                    <th>Alasan</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @forelse ($leaves as $index => $cuti)
                    <tr>
                        <td>{{ $leaves->firstItem() + $index }}</td>
                        <td>{{ $cuti->tanggal_mulai->format('d M Y') }}</td>
                        <td>{{ $cuti->tanggal_selesai->format('d M Y') }}</td>
                        <td>{{ $cuti->total_hari }} hari</td>
                        <td>{{ Str::limit($cuti->alasan, 40) }}</td>
                        <td>
                            @if ($cuti->status == 'approved_hrd')
                                <span class="badge bg-label-success">Disetujui</span>
                            @elseif ($cuti->status == 'pending')
                                <span class="badge bg-label-warning">Pending</span>
                            @else
                                <span class="badge bg-label-danger">Ditolak</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex">
                                <a class="btn btn-sm btn-icon btn-dark me-2"
                                    href="{{ route('karyawan.pengajuan-cuti.show', $cuti->id) }}"
                                    data-bs-toggle="tooltip" data-bs-offset="0,4"
                                    data-bs-placement="top" title="Lihat Detail">
                                    <i class="bx bx-show"></i>
                                </a>
                                @if ($cuti->status == 'pending')
                                    <a class="btn btn-sm btn-icon btn-info me-2"
                                        href="{{ route('karyawan.pengajuan-cuti.edit', $cuti->id) }}"
                                        data-bs-toggle="tooltip" data-bs-offset="0,4"
                                        data-bs-placement="top" title="Edit Pengajuan">
                                        <i class="bx bx-edit-alt"></i>
                                    </a>
                                    <form action="{{ route('karyawan.pengajuan-cuti.destroy', $cuti->id) }}" method="POST"
                                        onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pengajuan ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-icon btn-danger"
                                            data-bs-toggle="tooltip" data-bs-offset="0,4" 
                                            data-bs-placement="top" title="Batalkan Pengajuan">
                                            <i class="bx bx-trash"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">
                            <h5 class="my-3">Anda belum memiliki riwayat pengajuan cuti.</h5>
                            <a href="{{ route('karyawan.pengajuan-cuti.create') }}" class="btn btn-primary btn-sm">
                                <i class="bx bx-plus me-1"></i> Buat Pengajuan Pertama Anda
                            </a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if ($leaves->hasPages())
        <div class="card-footer d-flex justify-content-center">
            {{ $leaves->links() }}
        </div>
    @endif
</div>
@endsection