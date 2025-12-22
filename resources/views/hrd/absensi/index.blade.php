@extends('layouts.app')

@section('title', 'Kelola Absensi')

@section('content')

<!-- Card Filter -->

<div class="card mb-4">
    <div class="card-header">
        <h5 class="mb-0">Filter Data Absensi</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('hrd.absensi.index') }}" method="GET" class="row g-3">
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
                <label class="form-label" for="employee_id">Karyawan</label>
                <select id="employee_id" name="employee_id" class="form-select">
                    <option value="">Semua Karyawan</option>
                    @foreach ($employees as $employee)
                    <option value="{{ $employee->id }}" {{ request('employee_id') == $employee->id ? 'selected' : '' }}>
                        {{ $employee->nama_lengkap }} ({{ $employee->nik }})
                    </option>
                    @endforeach
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

<!-- Card Tabel Absensi -->

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Data Absensi ({{ \Carbon\Carbon::create()->month($bulan)->translatedFormat('F') }}
            {{ $tahun }})</h5>
        <a href="{{ route('hrd.absensi.create') }}" class="btn btn-primary">
            <i class="bx bx-plus me-1"></i> Input Absensi
        </a>
    </div>
    <div class="table-responsive text-nowrap">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Karyawan</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                    <th>Jam Masuk</th>
                    <th>Jam Pulang</th>
                    <th>Keterangan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @forelse ($attendances as $index => $absensi)
                <tr>
                    <td>{{ $attendances->firstItem() + $index }}</td>
                    <td><strong>{{ $absensi->employee->nama_lengkap }}</strong></td>
                    <td>{{ $absensi->tanggal->format('d M Y') }}</td>
                    <td>
                        @if ($absensi->status == 'hadir') <span class="badge bg-label-success">Hadir</span>
                        @elseif ($absensi->status == 'sakit') <span class="badge bg-label-warning">Sakit</span>
                        @elseif ($absensi->status == 'izin') <span class="badge bg-label-info">Izin</span>
                        @elseif ($absensi->status == 'cuti') <span class="badge bg-label-primary">Cuti</span>
                        @else <span class="badge bg-label-danger">Alpa</span>
                        @endif
                    </td>
                    <td>{{ $absensi->jam_masuk ? \Carbon\Carbon::parse($absensi->jam_masuk)->format('H:i') : '-' }}</td>
                    <td>{{ $absensi->jam_pulang ? \Carbon\Carbon::parse($absensi->jam_pulang)->format('H:i') : '-' }}
                    </td>
                    <td>{{ Str::limit($absensi->keterangan, 30) }}</td>
                    <td>
                        <div class="d-flex">
                            <a class="btn btn-sm btn-icon btn-info me-2"
                                href="{{ route('hrd.absensi.edit', $absensi->id) }}" data-bs-toggle="tooltip"
                                data-bs-offset="0,4" data-bs-placement="top" title="Edit Absensi">
                                <i class="bx bx-edit-alt"></i>
                            </a>
                            <form action="{{ route('hrd.absensi.destroy', $absensi->id) }}" method="POST"
                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-icon btn-danger" data-bs-toggle="tooltip"
                                    data-bs-offset="0,4" data-bs-placement="top" title="Hapus Absensi">
                                    <i class="bx bx-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center">Tidak ada data absensi ditemukan untuk periode ini.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <!-- Paginasi -->
    @if ($attendances->hasPages())
    <div class="card-footer d-flex justify-content-center">
        {{ $attendances->appends(request()->query())->links() }}
        <!-- appends agar filter tetap terbawa -->
    </div>
    @endif
</div>
@endsection
