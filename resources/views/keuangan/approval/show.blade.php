@extends('layouts.app')

@section('title', 'Review Slip Gaji: ' . $payroll->employee->nama_lengkap)

@section('content')

<div class="row">
    <!-- Kolom Aksi (Tombol Approve/Reject) -->
    <div class="col-12 mb-4">
        <div class="card">
            <div class="card-body">
                <div class="d-flex flex-wrap justify-content-between align-items-center">
                    <h5 class="mb-0">Aksi Persetujuan</h5>
                    <div class="d-flex">
                        <a href="{{ route('keuangan.approval.index', ['bulan' => $payroll->bulan, 'tahun' => $payroll->tahun]) }}"
                            class="btn btn-secondary me-2">
                            <i class="bx bx-arrow-back me-1"></i> Kembali ke Daftar
                        </a>

                        <!-- Tampilkan tombol hanya jika status masih 'pending' -->
                        @if($payroll->status == 'pending')
                        <!-- Tombol Reject (memakai Modal) -->
                        <button type="button" class="btn btn-danger me-2" data-bs-toggle="modal"
                            data-bs-target="#rejectModal">
                            <i class="bx bx-x-circle me-1"></i> Tolak
                        </button>

                        <!-- Form Tombol Approve -->
                        <form action="{{ route('keuangan.approval.approve', $payroll->id) }}" method="POST"
                            onsubmit="return confirm('Apakah Anda yakin ingin MENYETUJUI slip gaji ini?');">
                            @csrf
                            <button type="submit" class="btn btn-success">
                                <i class="bx bx-check-circle me-1"></i> Setujui
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
                <!-- Jika ditolak, tampilkan alasannya -->
                @if($payroll->status == 'rejected')
                <div class="alert alert-danger mt-3 mb-0">
                    <strong>Ditolak!</strong> Alasan: {{ $payroll->catatan_revisi }}
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Kolom Slip Gaji -->
    <div class="col-lg-10 col-md-12 mx-auto">
        <div class="card" id="slip-gaji-card">
            <div class="card-body p-5">
                <!-- Header Slip -->
                <div class="row">
                    <div class="col-6">
                        <div class="app-brand-link mb-3">
                            <span class="app-brand-logo demo">
                                <!-- (Logo SVG Anda bisa diletakkan di sini) -->
                                <svg width="25" viewBox="0 0 25 42" version="1.1" xmlns="http://www.w3.org/2000/svg"
                                    xmlns:xlink="http://www.w3.org/1999/xlink">
                                    <defs>
                                        <path
                                            d="M13.7918663,0.358365126 L3.39788168,7.44174259 C0.566865006,9.69408886 -0.379795268,12.4788597 0.557900856,15.7960551 C0.68998853,16.2305145 1.09562888,17.7872135 3.12357076,19.2293357 C3.8146334,19.7207684 5.32369333,20.3834223 7.65075054,21.2172976 L7.59773219,21.2525164 L2.63468769,24.5493413 C0.445452254,26.3002124 0.0884951797,28.5083815 1.56381646,31.1738486 C2.83770406,32.8170431 5.20850219,33.2640127 7.09180128,32.5391577 C8.347334,32.0559211 11.4559176,30.0011079 16.4175519,26.3747182 C18.0338572,24.4997857 18.6973423,22.4544883 18.4080071,20.2388261 C17.963753,17.5346866 16.1776345,15.5799961 13.0496516,14.3747546 L10.9194936,13.4715819 L18.6192054,7.984237 L13.7918663,0.358365126 Z"
                                            id="path-1"></path>
                                        <path
                                            d="M5.47320593,6.00457225 C4.05321814,8.216144 4.36334763,10.0722806 6.40359441,11.5729822 C8.61520715,12.571656 10.0999176,13.2171421 10.8577257,13.5094407 L15.5088241,14.433041 L18.6192054,7.984237 C15.5364148,3.11535317 13.9273018,0.573395879 13.7918663,0.358365126 C13.5790555,0.511491653 10.8061687,2.3935607 5.47320593,6.00457225 Z"
                                            id="path-3"></path>
                                        <path
                                            d="M7.50063644,21.2294429 L12.3234468,23.3159332 C14.1688022,24.7579751 14.397098,26.4880487 13.008334,28.506154 C11.6195701,30.5242593 10.3099883,31.790241 9.07958868,32.3040991 C5.78142938,33.4346997 4.13234973,34 4.13234973,34 C4.13234973,34 2.75489982,33.0538207 2.37032616e-14,31.1614621 C-0.55822714,27.8186216 -0.55822714,26.0572515 -4.05231404e-15,25.8773518 C0.83734071,25.6075023 2.77988457,22.8248993 3.3049379,22.52991 C3.65497346,22.3332504 5.05353963,21.8997614 7.50063644,21.2294429 Z"
                                            id="path-4"></path>
                                        <path
                                            d="M20.6,7.13333333 L25.6,13.8 C26.2627417,14.6836556 26.0836556,15.9372583 25.2,16.6 C24.8538077,16.8596443 24.4327404,17 24,17 L14,17 C12.8954305,17 12,16.1045695 12,15 C12,14.5672596 12.1403557,14.1461923 12.4,13.8 L17.4,7.13333333 C18.0627417,6.24967773 19.3163444,6.07059163 20.2,6.73333333 C20.3516113,6.84704183 20.4862915,6.981722 20.6,7.13333333 Z"
                                            id="path-5"></path>
                                    </defs>
                                    <g id="g-app-brand" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <g id="Brand-Logo" transform="translate(-27.000000, -15.000000)">
                                            <g id="Icon" transform="translate(27.000000, 15.000000)">
                                                <g id="Mask" transform="translate(0.000000, 8.000000)">
                                                    <mask id="mask-2" fill="white">
                                                        <use xlink:href="#path-1"></use>
                                                    </mask>
                                                    <use fill="#696cff" xlink:href="#path-1"></use>
                                                    <g id="Path-3" mask="url(#mask-2)">
                                                        <use fill="#696cff" xlink:href="#path-3"></use>
                                                        <use fill-opacity="0.2" fill="#FFFFFF" xlink:href="#path-3">
                                                        </use>
                                                    </g>
                                                    <g id="Path-4" mask="url(#mask-2)">
                                                        <use fill="#696cff" xlink:href="#path-4"></use>
                                                        <use fill-opacity="0.2" fill="#FFFFFF" xlink:href="#path-4">
                                                        </use>
                                                    </g>
                                                </g>
                                                <g id="Triangle"
                                                    transform="translate(19.000000, 11.000000) rotate(-300.000000) translate(-19.000000, -11.000000) ">
                                                    <use fill="#696cff" xlink:href="#path-5"></use>
                                                    <use fill-opacity="0.2" fill="#FFFFFF" xlink:href="#path-5"></use>
                                                </g>
                                            </g>
                                        </g>
                                    </g>
                                </svg>
                            </span>
                            <span class="app-brand-text demo menu-text fw-bolder ms-2 fs-4">Perusahaan Anda</span>
                        </div>
                        <p class="mb-1">Jalan Perusahaan No. 123</p>
                        <p>Jakarta, Indonesia</p>
                    </div>
                    <div class="col-6 text-end">
                        <h4 class="mb-1">SLIP GAJI KARYAWAN</h4>
                        <p class="mb-0 fw-semibold">Periode:
                            {{ \Carbon\Carbon::create()->month($payroll->bulan)->translatedFormat('F') }}
                            {{ $payroll->tahun }}</p>
                        <p class="text-muted mb-0">Status:
                            @if ($payroll->status == 'approved_finance') <span
                                class="badge bg-label-success">Disetujui</span>
                            @elseif ($payroll->status == 'paid') <span class="badge bg-label-primary">Dibayar</span>
                            @elseif ($payroll->status == 'pending') <span class="badge bg-label-warning">Pending</span>
                            @else <span class="badge bg-label-danger">Ditolak</span>
                            @endif
                        </p>
                    </div>
                </div>

                <hr class="my-4">

                <!-- Detail Karyawan -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <label class="fw-semibold">Nama Karyawan:</label>
                        <p class="mb-1">{{ $payroll->employee->nama_lengkap }}</p>
                    </div>
                    <div class="col-md-6">
                        <label class="fw-semibold">NIK:</label>
                        <p class="mb-1">{{ $payroll->employee->nik }}</p>
                    </div>
                    <div class="col-md-6">
                        <label class="fw-semibold">Jabatan:</label>
                        <p class="mb-1">{{ $payroll->employee->jabatan->nama_jabatan ?? '-' }}</p>
                    </div>
                    <div class="col-md-6">
                        <label class="fw-semibold">Divisi:</label>
                        <p class="mb-1">{{ $payroll->employee->divisi->nama_divisi ?? '-' }}</p>
                    </div>
                </div>

                <!-- Rincian Gaji -->
                <div class="row">
                    <!-- Kolom Pendapatan -->
                    <div class="col-md-6">
                        <h5 class="text-success">Pendapatan</h5>
                        <table class="table table-sm table-borderless">
                            <tbody>
                                @foreach($payroll->details->whereIn('tipe', ['allowance', 'overtime']) as $detail)
                                <tr>
                                    <td>{{ $detail->nama_komponen }}</td>
                                    <td class="text-end">Rp {{ number_format($detail->jumlah, 0, ',', '.') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="border-top">
                                <tr>
                                    <td class="fw-semibold">Total Pendapatan (Gaji Kotor)</td>
                                    <td class="text-end fw-semibold text-success">Rp
                                        {{ number_format($payroll->gaji_kotor, 0, ',', '.') }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <!-- Kolom Potongan -->
                    <div class="col-md-6">
                        <h5 class="text-danger">Potongan</h5>
                        <table class="table table-sm table-borderless">
                            <tbody>
                                @forelse($payroll->details->where('tipe', 'deduction') as $detail)
                                <tr>
                                    <td>{{ $detail->nama_komponen }}</td>
                                    <td class="text-end">(Rp {{ number_format($detail->jumlah, 0, ',', '.') }})</td>
                                </tr>
                                @empty
                                <tr>
                                    <td class="text-muted">Tidak ada potongan</td>
                                    <td class="text-end">(Rp 0)</td>
                                </tr>
                                @endforelse
                            </tbody>
                            <tfoot class="border-top">
                                <tr>
                                    <td class="fw-semibold">Total Potongan</td>
                                    <td class="text-end fw-semibold text-danger">(Rp
                                        {{ number_format($payroll->total_potongan, 0, ',', '.') }})</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <!-- Total Gaji Bersih -->
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="alert alert-primary p-4" role="alert">
                            <div class="d-flex justify-content-between align-items-center">
                                <h4 class="alert-heading mb-0">Gaji Bersih (Take Home Pay)</h4>
                                <h4 class="alert-heading mb-0">Rp
                                    {{ number_format($payroll->gaji_bersih, 0, ',', '.') }}</h4>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer Slip -->
                <div class="row mt-4">
                    <div class="col-6">
                        <p>Dibuat oleh (HRD):</p>
                        <p class="mt-5 mb-0 fw-semibold">{{ $payroll->generatedBy->name ?? '-' }}</p>
                    </div>
                    <div class="col-6 text-end">
                        <p>Disetujui oleh (Keuangan):</p>
                        @if($payroll->financeApprovedBy)
                        <p class="mt-5 mb-0 fw-semibold">{{ $payroll->financeApprovedBy->name }}</p>
                        <small class="text-muted">{{ $payroll->finance_approved_at->format('d M Y H:i') }}</Tsmall>
                            @else
                            <p class="mt-5 mb-0 text-muted">(Menunggu Persetujuan)</p>
                            @endif
                    </div>
                </div>

            </div>
        </div>


    </div>

</div> <!-- Penutup .row utama -->

<!-- Modal untuk Reject -->

<div class="modal fade" id="rejectModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('keuangan.approval.reject', $payroll->id) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="rejectModalLabel">Tolak Persetujuan Gaji</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Anda akan menolak slip gaji untuk <strong>{{ $payroll->employee->nama_lengkap }}</strong>
                        periode <strong>{{ \Carbon\Carbon::create()->month($payroll->bulan)->translatedFormat('F') }}
                            {{ $payroll->tahun }}</strong>.
                    </p>
                    <div class="mb-3">
                        <label for="catatan_revisi" class="form-label">Alasan Penolakan <span
                                class="text-danger">*</span></label>
                        <textarea class="form-control @error('catatan_revisi') is-invalid @enderror" id="catatan_revisi"
                            name="catatan_revisi" rows="3"
                            placeholder="Contoh: Perhitungan lembur salah, mohon dikoreksi HRD..."
                            required>{{ old('catatan_revisi') }}</textarea>
                        @error('catatan_revisi')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Tolak</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
