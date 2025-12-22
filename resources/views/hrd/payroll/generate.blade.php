@extends('layouts.app')

@section('title', 'Generate Gaji Karyawan')

@section('content')

<div class="row">
    <!-- Form -->
    <div class="col-lg-6 col-md-12">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Formulir Generate Gaji</h5>
                <a href="{{ route('hrd.payroll.index') }}" class="btn btn-secondary btn-sm">
                    <i class="bx bx-arrow-back me-1"></i> Kembali
                </a>
            </div>
            <div class="card-body">
                <p>Pilih bulan dan tahun untuk memulai proses kalkulasi gaji semua karyawan aktif. Proses ini akan
                    menghitung gaji pokok, tunjangan, potongan, dan lembur.</p>
                <p class="text-warning">
                    <i class="bx bx-info-circle me-1"></i> <strong>Perhatian:</strong> Jika data gaji untuk periode ini
                    sudah ada dan berstatus 'Pending', data tersebut akan dihitung ulang dan ditimpa.
                </p>

                <form action="{{ route('hrd.payroll.store') }}" method="POST"
                    onsubmit="return confirm('Apakah Anda yakin ingin men-generate gaji untuk periode ini?');">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="bulan">Bulan <span class="text-danger">*</span></label>
                            <select id="bulan" name="bulan" class="form-select @error('bulan') is-invalid @enderror"
                                required>
                                <!-- Default ke bulan lalu -->
                                @php $defaultBulan = old('bulan', now()->subMonth()->format('m')); @endphp
                                @for ($i = 1; $i <= 12; $i++) <option value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}"
                                    {{ $defaultBulan == $i ? 'selected' : '' }}>
                                    {{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}
                                    </option>
                                    @endfor
                            </select>
                            @error('bulan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="tahun">Tahun <span class="text-danger">*</span></label>
                            <select id="tahun" name="tahun" class="form-select @error('tahun') is-invalid @enderror"
                                required>
                                <!-- Default ke tahun dari bulan lalu -->
                                @php $defaultTahun = old('tahun', now()->subMonth()->format('Y')); @endphp
                                @for ($i = now()->year + 1; $i >= now()->year - 4; $i--)
                                <option value="{{ $i }}" {{ $defaultTahun == $i ? 'selected' : '' }}>{{ $i }}</option>
                                @endfor
                            </select>
                            @error('tahun') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="bx bx-calculator me-1"></i> Mulai Generate Gaji
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Info -->
    <div class="col-lg-6 col-md-12">
        <div class="card card-body">
            <h5>Bagaimana Cara Kerjanya?</h5>
            <ol class="ps-3">
                <li class="mb-1">Sistem akan mengambil semua karyawan dengan status <strong>"Aktif"</strong>.</li>
                <li class="mb-1">Menghitung <strong>Gaji Pokok</strong> + <strong>Semua Tunjangan</strong> yang
                    terdaftar pada karyawan.</li>
                <li class="mb-1">Menghitung <strong>Semua Biaya Lembur</strong> yang telah berstatus <strong>"Disetujui
                        HRD"</strong> pada periode yang dipilih.</li>
                <li class="mb-1">Menghitung <strong>Semua Potongan</strong> yang terdaftar pada karyawan.</li>
                <li class="mb-1">Hasilnya akan berstatus <strong>"Pending"</strong> dan menunggu persetujuan dari
                    <strong>Staff Keuangan</strong>.</li>
            </ol>
            <p class="mb-0">Pastikan semua data cuti dan lembur sudah disetujui sebelum men-generate gaji.</p>
        </div>
    </div>


</div>
@endsection
