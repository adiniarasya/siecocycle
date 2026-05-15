<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Setoran - {{ $bank->name ?? 'Bank Sampah' }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            font-size: 18px;
        }
        .header p {
            margin: 5px 0;
            font-size: 12px;
        }
        .summary {
            margin-bottom: 20px;
            width: 100%;
        }
        .summary td {
            padding: 5px;
            border: 1px solid #ddd;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            text-align: center;
        }
        .text-center {
            text-align: center;
        }
        .text-right {
            text-align: right;
        }
        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
            font-size: 10px;
            border-top: 1px solid #ddd;
            padding-top: 5px;
        }
    </style>
</head>
<body>

<div class="header">
    <h1>LAPORAN SETORAN SAMPAH</h1>
    <p>{{ $bank->name ?? 'Bank Sampah' }}</p>
    <p>{{ $bank->address ?? '' }}</p>
    <p>Periode: Semua Data | Tanggal Cetak: {{ date('d F Y H:i') }}</p>
</div>

<table class="summary">
    <tr>
        <td width="33%"><strong>Total Transaksi:</strong> {{ $totalDeposits }} Transaksi</td>
        <td width="33%"><strong>Total Berat:</strong> {{ number_format($totalWeight, 2) }} Kg</td>
        <td width="33%"><strong>Status:</strong> TERVERIFIKASI</td>
    </tr>
</table>

<h3>Detail Setoran</h3>

<table>
    <thead>
        <tr>
            <th class="text-center">No</th>
            <th>Tanggal Setor</th>
            <th>Warga</th>
            <th>Jenis Sampah</th>
            <th class="text-center">Berat (Kg)</th>
            <th>Tanggal Verifikasi</th>
        </tr>
    </thead>
    <tbody>
        @forelse($deposits ?? [] as $index => $item)
        <tr>
            <td class="text-center">{{ $loop->iteration }}</td>
            <td>{{ $item->deposit_date ? \Carbon\Carbon::parse($item->deposit_date)->format('d M Y') : '-' }}</td>
            <td>{{ $item->user->name ?? 'Tidak ada' }}</td>
            <td>{{ $item->wasteType->name ?? 'Tidak ada' }}</td>
            <td class="text-center">{{ number_format($item->weight_kg ?? 0, 2) }}</td>
            <td>{{ $item->updated_at ? \Carbon\Carbon::parse($item->updated_at)->format('d M Y H:i') : '-' }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="6" class="text-center">Belum ada data setoran</td>
        </tr>
        @endforelse
    </tbody>
</table>

<div class="footer">
    Dicetak pada: {{ date('d F Y H:i:s') }} | SIECOCYCLE - Sistem Informasi Bank Sampah
</div>

</body>
</html>