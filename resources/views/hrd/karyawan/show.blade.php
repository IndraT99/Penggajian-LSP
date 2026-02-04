@extends('layouts.app')

@section('title', 'Profil Karyawan: ' . $karyawan->nama_lengkap)

@section('content')

    <div class="row">
        <!-- Kolom Kiri: Info Utama Karyawan -->
        <div class="col-xl-4 col-lg-5 col-md-5">
            <div class="card mb-4">
                <div class="info-container">
                    <h5 class="pb-2 border-bottom mb-4">Detail</h5>
                    <ul class="list-unstyled">
                        <li class="mb-3">
                            <span class="fw-semibold me-2">NIK:</span>
                            <span>{{ $karyawan->nik }}</span>
                        </li>
                        <li class="mb-3">
                            <span class="fw-semibold me-2">Divisi:</span>
                            <span>{{ $karyawan->divisi->nama_divisi ?? '-' }}</span>
                        </li>
                        <li class="mb-3">
                            <span class="fw-semibold me-2">Bergabung:</span>
                            <span>{{ $karyawan->tanggal_bergabung->format('d M Y') }}</span>
                        </li>
                        <li class="mb-3">
                            <span class="fw-semibold me-2">Akun Login:</span>
                            <span>{{ $karyawan->user->email ?? 'Tidak ada' }}</span>
                        </li>
                        <li class="mb-3">
                            <span class="fw-semibold me-2">No. Telepon:</span>
                            <span>{{ $karyawan->no_telepon ?? '-' }}</span>
                        </li>
                        <li class="mb-3">
                            <span class="fw-semibold me-2">Tgl. Lahir:</span>
                            <span>{{ $karyawan->tanggal_lahir ? $karyawan->tanggal_lahir->format('d M Y') : '-' }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Kolom Kanan: Tab Info Lainnya -->
    <div class="col-xl-8 col-lg-7 col-md-7">
        <div class="nav-align-top mb-4">
            <ul class="nav nav-pills mb-3" role="tablist">
                <li class="nav-item" role="presentation">
                    <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                        data-bs-target="#navs-komponen-gaji" aria-controls="navs-komponen-gaji" aria-selected="true">
                        <i class="bx bx-money me-1"></i> Komponen Gaji
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                        data-bs-target="#navs-riwayat-gaji" aria-controls="navs-riwayat-gaji" aria-selected="false">
                        <i class="bx bx-receipt me-1"></i> Riwayat Gaji
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                        data-bs-target="#navs-riwayat-cuti" aria-controls="navs-riwayat-cuti" aria-selected="false">
                        <i class="bx bx-calendar-minus me-1"></i> Riwayat Cuti
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                        data-bs-target="#navs-riwayat-lembur" aria-controls="navs-riwayat-lembur" aria-selected="false">
                        <i class="bx bx-time-five me-1"></i> Riwayat Lembur
                    </button>
                </li>
            </ul>
            <div class="tab-content">
                <!-- Tab Komponen Gaji -->
                <div class="tab-pane fade show active" id="navs-komponen-gaji" role="tabpanel">
                    <div class="row">
                        <div class="col-md-6">
                            <h5 class="text-success">Tunjangan</h5>
                            <ul class="list-group">
                                @forelse ($karyawan->components->where('tipe', 'allowance') as $component)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        {{ $component->nama_komponen }}
                                        <span class="fw-bold">Rp
                                            {{ number_format($component->pivot->jumlah, 0, ',', '.') }}</span>
                                    </li>
                                @empty
                                    <li class="list-group-item text-muted">Tidak ada tunjangan.</li>
                                @endforelse
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h5 class="text-danger">Potongan</h5>
                            <ul class="list-group">
                                @forelse ($karyawan->components->where('tipe', 'deduction') as $component)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        {{ $component->nama_komponen }}
                                        <span class="fw-bold">Rp
                                            {{ number_format($component->pivot->jumlah, 0, ',', '.') }}</span>
                                    </li>
                                @empty
                                    <li class="list-group-item text-muted">Tidak ada potongan.</li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Tab Riwayat Gaji -->
                <div class="tab-pane fade" id="navs-riwayat-gaji" role="tabpanel">
                    <div class="table-responsive text-nowrap" style="max-height: 400px;">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Periode</th>
                                    <th>Gaji Bersih</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($karyawan->payrolls as $payroll)
                                    <tr>
                                        <td>{{ $payroll->bulan }} / {{ $payroll->tahun }}</td>
                                        <td><strong>Rp {{ number_format($payroll->gaji_bersih, 0, ',', '.') }}</strong></td>
                                        <td>
                                            <!-- Status Badge -->
                                            @if ($payroll->status == 'paid') <span class="badge bg-label-success">Paid</span>
                                            @elseif ($payroll->status == 'approved_finance') <span
                                                class="badge bg-label-info">Approved</span>
                                            @elseif ($payroll->status == 'pending') <span
                                                class="badge bg-label-warning">Pending</span>
                                            @else <span class="badge bg-label-danger">Rejected</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('hrd.payroll.slip', $payroll->id) }}"
                                                class="btn btn-xs btn-outline-primary">Lihat Slip</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">Belum ada riwayat gaji.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Tab Riwayat Cuti -->
                <div class="tab-pane fade" id="navs-riwayat-cuti" role="tabpanel">
                    <!-- (Sama seperti riwayat gaji, buat tabel untuk $karyawan->leaves) -->
                    <p class="text-center">Data Riwayat Cuti...</p>
                </div>

                <!-- Tab Riwayat Lembur -->
                <div class="tab-pane fade" id="navs-riwayat-lembur" role="tabpanel">
                    <!-- (Sama seperti riwayat gaji, buat tabel untuk $karyawan->overtimes) -->
                    <p class="text-center">Data Riwayat Lembur...</p>
                </div>
            </div>
        </div>
    </div>


    </div>
@endsection