@extends('layouts.app')

@section('title', 'Riwayat Pengajuan Lembur')

@section('content')

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Riwayat Pengajuan Lembur Anda</h5>
        <a href="{{ route('karyawan.pengajuan-lembur.create') }}" class="btn btn-primary">
            <i class="bx bx-plus me-1"></i> Buat Pengajuan Baru
        </a>
    </div>
    <div class="table-responsive text-nowrap">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Jam</th>
                    <th>Total</th>
                    <th>Alasan</th>
                    <th>Status</th>
                    <th>Biaya Lembur</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @forelse ($overtimes as $index => $lembur)
                <tr>
                    <td>{{ $overtimes->firstItem() + $index }}</td>
                    <td>{{ $lembur->tanggal->format('d M Y') }}</td>
                    <td>{{ $lembur->jam_mulai }} - {{ $lembur->jam_selesai }}</td>
                    <td>{{ $lembur->total_jam }} jam</td>
                    <td>{{ Str::limit($lembur->alasan_lembur, 30) }}</td>
                    <td>
                        @if ($lembur->status == 'approved_hrd')
                        <span class="badge bg-label-success">Disetujui</span>
                        @elseif ($lembur->status == 'pending')
                        <span class="badge bg-label-warning">Pending</span>
                        @else
                        <span class="badge bg-label-danger">Ditolak</span>
                        @endif
                    </td>
                    <td>
                        <!-- Biaya lembur hanya tampil jika sudah disetujui HRD -->
                        @if ($lembur->status == 'approved_hrd')
                        <span class="fw-semibold text-success">Rp
                            {{ number_format($lembur->biaya_lembur, 0, ',', '.') }}</span>
                        @else
                        <span class="text-muted">-</span>
                        @endif
                    </td>
                    <td>
                        <div class="d-flex">
                            <a class="btn btn-sm btn-icon btn-dark me-2"
                                href="{{ route('karyawan.pengajuan-lembur.show', $lembur->id) }}"
                                data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="top"
                                title="Lihat Detail">
                                <i class="bx bx-show"></i>
                            </a>
                            <!-- Karyawan hanya bisa edit/hapus jika masih pending -->
                            @if ($lembur->status == 'pending')
                            <a class="btn btn-sm btn-icon btn-info me-2"
                                href="{{ route('karyawan.pengajuan-lembur.edit', $lembur->id) }}"
                                data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="top"
                                title="Edit Pengajuan">
                                <i class="bx bx-edit-alt"></i>
                            </a>
                            <form action="{{ route('karyawan.pengajuan-lembur.destroy', $lembur->id) }}" method="POST"
                                onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pengajuan ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-icon btn-danger" data-bs-toggle="tooltip"
                                    data-bs-offset="0,4" data-bs-placement="top" title="Batalkan Pengajuan">
                                    <i class="bx bx-trash"></i>
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center">
                        <h5 class="my-3">Anda belum memiliki riwayat pengajuan lembur.</h5>
                        <a href="{{ route('karyawan.pengajuan-lembur.create') }}" class="btn btn-primary btn-sm">
                            <i class="bx bx-plus me-1"></i> Buat Pengajuan Pertama Anda
                        </a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <!-- Paginasi -->
    @if ($overtimes->hasPages())
    <div class="card-footer d-flex justify-content-center">
        {{ $overtimes->links() }}
    </div>
    @endif
</div>
@endsection
