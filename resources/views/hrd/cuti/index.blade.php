@extends('layouts.app')

@section('title', 'Kelola Pengajuan Cuti')

@section('content')

<!-- Card Filter -->

<div class="card mb-4">
    <div class="card-header">
        <h5 class="mb-0">Filter Data Cuti</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('hrd.cuti.index') }}" method="GET" class="row g-3">
            <div class="col-md-3">
                <label class="form-label" for="bulan">Bulan</label>
                <select id="bulan" name="bulan" class="form-select">
                    @for ($i = 1; $i <= 12; $i++) <option value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}"
                        {{ $bulan == $i ? 'selected' : '' }}>
                        {{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}
                        </option>
                        @endfor
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label" for="tahun">Tahun</label>
                <select id="tahun" name="tahun" class="form-select">
                    @php $currentYear = now()->year; @endphp
                    @for ($i = $currentYear + 1; $i >= $currentYear - 4; $i--)
                    <option value="{{ $i }}" {{ $tahun == $i ? 'selected' : '' }}>{{ $i }}</option>
                    @endfor
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label" for="status">Status</label>
                <select id="status" name="status" class="form-select">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ $status == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="approved_hrd" {{ $status == 'approved_hrd' ? 'selected' : '' }}>Disetujui</option>
                    <option value="rejected" {{ $status == 'rejected' ? 'selected' : '' }}>Ditolak</option>
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

<!-- Card Tabel Cuti -->

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Data Pengajuan Cuti ({{ \Carbon\Carbon::create()->month($bulan)->translatedFormat('F') }}
            {{ $tahun }})</h5>
        <a href="{{ route('hrd.cuti.create') }}" class="btn btn-primary">
            <i class="bx bx-plus me-1"></i> Input Cuti
        </a>
    </div>
    <div class="table-responsive text-nowrap">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Karyawan</th>
                    <th>Tgl. Mulai</th>
                    <th>Tgl. Selesai</th>
                    <th>Hari</th>
                    <th>Alasan</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @forelse ($leaves as $index => $cuti)
                <tr>
                    <td>{{ $leaves->firstItem() + $index }}</td>
                    <td><strong>{{ $cuti->employee->nama_lengkap }}</strong></td>
                    <td>{{ $cuti->tanggal_mulai->format('d M Y') }}</td>
                    <td>{{ $cuti->tanggal_selesai->format('d M Y') }}</td>
                    <td>{{ $cuti->total_hari }}</td>
                    <td>{{ Str::limit($cuti->alasan, 30) }}</td>
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
                            <a class="btn btn-sm btn-icon btn-info me-2" href="{{ route('hrd.cuti.edit', $cuti->id) }}"
                                data-bs-toggle="tooltip" data-bs-offset="0,4" data-bs-placement="top"
                                title="Edit/Approve">
                                <i class="bx bx-edit-alt"></i>
                            </a>
                            @if ($cuti->status != 'approved_hrd')
                            <form action="{{ route('hrd.cuti.destroy', $cuti->id) }}" method="POST"
                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-icon btn-danger" data-bs-toggle="tooltip"
                                    data-bs-offset="0,4" data-bs-placement="top" title="Hapus Cuti">
                                    <i class="bx bx-trash"></i>
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center">Tidak ada data pengajuan cuti ditemukan untuk periode ini.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <!-- Paginasi -->
    @if ($leaves->hasPages())
    <div class="card-footer d-flex justify-content-center">
        {{ $leaves->appends(request()->query())->links() }}
        <!-- appends agar filter tetap terbawa -->
    </div>
    @endif
</div>
@endsection
