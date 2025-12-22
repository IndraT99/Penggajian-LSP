<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Slip Gaji - {{ $payroll->employee->nama_lengkap }}</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; }
        .rincian-gaji th, .rincian-gaji td { border: 1px solid #ccc; padding: 8px; }
        .text-end { text-align: right; }
        .total-row { font-weight: bold; background-color: #f4f4f4; }
        .gaji-bersih { font-weight: bold; font-size: 1.2em; background-color: #eee; }
    </style>
</head>
<body>

    <h1 style="text-align: center;">Slip Gaji</h1>

    <table style="margin-bottom: 20px;">
        <tr>
            <td style="width: 15%;"><strong>Nama</strong></td>
            <td style="width: 35%;">: {{ $payroll->employee->nama_lengkap }}</td>
            <td style="width: 15%;"><strong>Periode</strong></td>
            <td style="width: 35%;">: {{ \Carbon\Carbon::create()->month($payroll->bulan)->translatedFormat('F') }} {{ $payroll->tahun }}</td>
        </tr>
        <tr>
            <td><strong>NIK</strong></td>
            <td>: {{ $payroll->employee->nik }}</td>
            <td><strong>Status</strong></td>
            <td>: 
                @if ($payroll->status == 'approved_finance') Disetujui
                @elseif ($payroll->status == 'paid') Dibayar
                @elseif ($payroll->status == 'pending') Pending
                @else Ditolak
                @endif
            </td>
        </tr>
        <tr>
            <td><strong>Jabatan</strong></td>
            <td>: {{ $payroll->employee->jabatan->nama_jabatan ?? '-' }}</td>
            <td><strong>Divisi</strong></td>
            <td>: {{ $payroll->employee->divisi->nama_divisi ?? '-' }}</td>
        </tr>
    </table>

    @if($payroll->status == 'rejected')
        <div style="border: 1px solid #900; background-color: #fdd; padding: 10px; margin-bottom: 20px;">
            <strong>Ditolak!</strong> Alasan: {{ $payroll->catatan_revisi }}
        </div>
    @endif

    <table class="rincian-gaji">
        <thead>
            <tr style="background-color: #f4f4f4;">
                <th>Komponen</th>
                <th class="text-end">Pendapatan</th>
                <th class="text-end">Potongan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($payroll->details->whereIn('tipe', ['allowance', 'overtime']) as $detail)
            <tr>
                <td>{{ $detail->nama_komponen }}</td>
                <td class="text-end">{{ number_format($detail->jumlah, 0, ',', '.') }}</td>
                <td class="text-end"></td>
            </tr>
            @endforeach

            <tr class="total-row">
                <td>Total Pendapatan (Kotor)</td>
                <td class="text-end">{{ number_format($payroll->gaji_kotor, 0, ',', '.') }}</td>
                <td class="text-end"></td>
            </tr>

            @forelse($payroll->details->where('tipe', 'deduction') as $detail)
            <tr>
                <td>{{ $detail->nama_komponen }}</td>
                <td class="text-end"></td>
                <td class="text-end">({{ number_format($detail->jumlah, 0, ',', '.') }})</td>
            </tr>
            @empty
            <tr>
                <td>- Tidak Ada Potongan -</td>
                <td class="text-end"></td>
                <td class="text-end"></td>
            </tr>
            @endforelse

            <tr class="total-row">
                <td>Total Potongan</td>
                <td class="text-end"></td>
                <td class="text-end">({{ number_format($payroll->total_potongan, 0, ',', '.') }})</td>
            </tr>
        </tbody>
        <tfoot>
            <tr class="gaji-bersih">
                <td colspan="2">Gaji Bersih (Take Home Pay)</td>
                <td class="text-end">Rp {{ number_format($payroll->gaji_bersih, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>

</body>
</html>