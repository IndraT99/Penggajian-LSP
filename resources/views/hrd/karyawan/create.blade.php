@extends('layouts.app')

@section('title', 'Tambah Karyawan Baru')

@section('content')

<form action="{{ route('hrd.karyawan.store') }}" method="POST">
    @csrf
    <div class="row">
        <!-- Kolom Kiri: Data Pekerjaan -->
        <div class="col-lg-6 col-md-12">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Data Pekerjaan</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label" for="nama_lengkap">Nama Lengkap <span
                                class="text-danger"></span></label>
                        <input type="text" class="form-control @error('nama_lengkap') is-invalid @enderror"
                            id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap') }}" required />
                        @error('nama_lengkap') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="nik">NIK <span class="text-danger"></span></label>
                        <input type="text" class="form-control @error('nik') is-invalid @enderror" id="nik" name="nik"
                            value="{{ old('nik') }}" required />
                        @error('nik') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="gaji_pokok">Gaji Pokok <span class="text-danger"></span></label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" class="form-control @error('gaji_pokok') is-invalid @enderror"
                                id="gaji_pokok" name="gaji_pokok" value="{{ old('gaji_pokok', 0) }}" min="0" required />
                        </div>
                        @error('gaji_pokok') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="jabatan_id">Jabatan <span class="text-danger"></span></label>
                        <select id="jabatan_id" name="jabatan_id"
                            class="form-select @error('jabatan_id') is-invalid @enderror" required>
                            <option value="">Pilih Jabatan...</option>
                            @foreach ($jabatans as $jabatan)
                            <option value="{{ $jabatan->id }}"
                                {{ old('jabatan_id') == $jabatan->id ? 'selected' : '' }}>{{ $jabatan->nama_jabatan }}
                            </option>
                            @endforeach
                        </select>
                        @error('jabatan_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="divisi_id">Divisi <span class="text-danger"></span></label>
                        <select id="divisi_id" name="divisi_id"
                            class="form-select @error('divisi_id') is-invalid @enderror" required>
                            <option value="">Pilih Divisi...</option>
                            @foreach ($divisis as $divisi)
                            <option value="{{ $divisi->id }}" {{ old('divisi_id') == $divisi->id ? 'selected' : '' }}>
                                {{ $divisi->nama_divisi }}</option>
                            @endforeach
                        </select>
                        @error('divisi_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="tanggal_bergabung">Tanggal Bergabung <span
                                class="text-danger"></span></label>
                        <input type="date" class="form-control @error('tanggal_bergabung') is-invalid @enderror"
                            id="tanggal_bergabung" name="tanggal_bergabung" value="{{ old('tanggal_bergabung') }}"
                            required />
                        @error('tanggal_bergabung') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="status_karyawan">Status Karyawan <span
                                class="text-danger">*</span></label>
                        <select id="status_karyawan" name="status_karyawan"
                            class="form-select @error('status_karyawan') is-invalid @enderror" required>
                            <option value="aktif" {{ old('status_karyawan') == 'aktif' ? 'selected' : '' }}>Aktif
                            </option>
                            <option value="non_aktif" {{ old('status_karyawan') == 'non_aktif' ? 'selected' : '' }}>
                                Non-Aktif</option>
                            <option value="resign" {{ old('status_karyawan') == 'resign' ? 'selected' : '' }}>Resign
                            </option>
                        </select>
                        @error('status_karyawan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="user_id">Link Akun Login (Opsional)</label>
                        <select id="user_id" name="user_id" class="form-select @error('user_id') is-invalid @enderror">
                            <option value="">Tidak ada akun login</option>
                            @foreach ($users as $user)
                            <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }} ({{ $user->email }})</option>
                            @endforeach
                        </select>
                        <small class="form-text text-muted">Hanya menampilkan user yang belum tertaut ke karyawan
                            lain.</small>
                        @error('user_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Kolom Kanan: Data Pribadi -->
        <div class="col-lg-6 col-md-12">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Data Pribadi (Opsional)</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label" for="tempat_lahir">Tempat Lahir</label>
                        <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir"
                            value="{{ old('tempat_lahir') }}" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="tanggal_lahir">Tanggal Lahir</label>
                        <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir"
                            value="{{ old('tanggal_lahir') }}" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="jenis_kelamin">Jenis Kelamin</label>
                        <select id="jenis_kelamin" name="jenis_kelamin" class="form-select">
                            <option value="">Pilih...</option>
                            <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="alamat">Alamat</label>
                        <textarea id="alamat" name="alamat" class="form-control" rows="3">{{ old('alamat') }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="no_telepon">No. Telepon</label>
                        <input type="tel" class="form-control" id="no_telepon" name="no_telepon"
                            value="{{ old('no_telepon') }}" />
                    </div>
                </div>
            </div>
        </div>
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Data Keuangan & Pajak</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="nama_bank">Nama Bank</label>
                            <input type="text" class="form-control" id="nama_bank" name="nama_bank"
                                value="{{ old('nama_bank') }}" placeholder="Contoh: BCA" />
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="nomor_rekening">Nomor Rekening</label>
                            <input type="text" class="form-control" id="nomor_rekening" name="nomor_rekening"
                                value="{{ old('nomor_rekening') }}" />
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="npwp">NPWP</label>
                        <input type="text" class="form-control" id="npwp" name="npwp" value="{{ old('npwp') }}" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="ptkp_status">Status PTKP</label>
                        <select id="ptkp_status" name="ptkp_status" class="form-select">
                            <option value="">Pilih Status PTKP...</option>
                            @foreach(['TK/0', 'TK/1', 'TK/2', 'TK/3', 'K/0', 'K/1', 'K/2', 'K/3', 'K/I/0', 'K/I/1',
                            'K/I/2', 'K/I/3'] as $ptkp)
                            <option value="{{ $ptkp }}" {{ old('ptkp_status') == $ptkp ? 'selected' : '' }}>{{ $ptkp }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="bpjs_kesehatan_no">No. BPJS Kesehatan</label>
                        <input type="text" class="form-control" id="bpjs_kesehatan_no" name="bpjs_kesehatan_no"
                            value="{{ old('bpjs_kesehatan_no') }}" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="bpjs_ketenagakerjaan_no">No. BPJS Ketenagakerjaan</label>
                        <input type="text" class="form-control" id="bpjs_ketenagakerjaan_no"
                            name="bpjs_ketenagakerjaan_no" value="{{ old('bpjs_ketenagakerjaan_no') }}" />
                    </div>
                </div>
            </div>
        </div>

        <!-- Baris Penuh: Komponen Gaji -->
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Komponen Gaji Karyawan (Tunjangan & Potongan)</h5>
                </div>
                <div class="card-body">
                    <p>Pilih komponen gaji yang berlaku untuk karyawan ini dan masukkan jumlahnya.</p>
                    <div class="row">
                        @foreach ($components as $component)
                        <div class="col-md-6 mb-3">
                            <div class="input-group">
                                <div class="input-group-text">
                                    <input class="form-check-input mt-0 component-check" type="checkbox"
                                        name="components[{{ $component->id }}][id]" value="{{ $component->id }}"
                                        data-target-input="component-jumlah-{{ $component->id }}"
                                        {{ old("components.$component->id.id") ? 'checked' : '' }}>
                                </div>
                                <label class="form-control" style="background-color: #f5f5f9;">
                                    {{ $component->nama_komponen }}
                                    <span
                                        class="badge {{ $component->tipe == 'allowance' ? 'bg-label-success' : 'bg-label-danger' }} ms-2">
                                        {{ $component->tipe == 'allowance' ? 'Tunjangan' : 'Potongan' }}
                                    </span>
                                </label>
                                <span class="input-group-text">Rp</span>
                                <input type="number" class="form-control component-jumlah"
                                    id="component-jumlah-{{ $component->id }}"
                                    name="components[{{ $component->id }}][jumlah]"
                                    value="{{ old("components.$component->id.jumlah", $component->jumlah_default) }}"
                                    min="0" step="1000" {{ !old("components.$component->id.id") ? 'disabled' : '' }}>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Tombol Simpan -->
        <div class="col-12 text-center">
            <button type="submit" class="btn btn-primary btn-lg">
                <i class="bx bx-save me-1"></i> Simpan Karyawan
            </button>
            <a href="{{ route('hrd.karyawan.index') }}" class="btn btn-secondary btn-lg">
                Batal
            </a>
        </div>
    </div>


</form>
@endsection

@push('scripts')

<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.component-check').forEach(function (checkbox) {
            checkbox.addEventListener('change', function () {
                let targetInput = document.getElementById(this.dataset.targetInput);
                if (targetInput) {
                    targetInput.disabled = !this.checked;
                }
            });
        });
    });

</script>

@endpush
