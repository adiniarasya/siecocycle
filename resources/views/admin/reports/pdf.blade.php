<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan EcoCycle</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        h2 {
            text-align: center;
            color: #2c6e3f;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background: #f2f2f2;
        }

        .total {
            font-weight: bold;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <h2>Laporan EcoCycle</h2>
    <p><strong>RW:</strong> {{ $rwName }}</p>
    <p><strong>Periode:</strong> {{ \Carbon\Carbon::parse($startDate)->format('d/m/Y') }} - {{
        \Carbon\Carbon::parse($endDate)->format('d/m/Y') }}</p>

    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Warga</th>
                <th>Jenis</th>
                <th>Berat (kg)</th>
                <th>CO₂ (kg)</th>
                <th>Poin</th>
            </tr>
        </thead>
        <tbody>
            @forelse($details as $d)
            <tr>
                <td>{{ \Carbon\Carbon::parse($d->deposit_date)->format('d/m/Y') }}</td>
                <td>{{ $d->user->name }}</td>
                <td>{{ $d->wasteType->name }}</td>
                <td>{{ $d->weight_kg }}</td>
                <td>{{ number_format($d->co2_saved ?? $d->weight_kg * $d->wasteType->co2_factor, 2) }}</td>
                <td>{{ number_format($d->points ?? $d->weight_kg * $d->wasteType->reward_per_kg, 0) }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" align="center">Tidak ada data</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="total">
        <p>Total Berat: {{ number_format($totalWeight, 1) }} kg</p>
        <p>Total CO2: {{ number_format($totalCo2, 1) }} kg</p>
        <p>Total Penghematan: Rp {{ number_format($totalSaving, 0, ',', '.') }}</p>
    </div>
</body>

</html>