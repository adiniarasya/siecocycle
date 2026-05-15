@extends('template.layout')

@section('title', 'Laporan Setoran - Bank Sampah')

@section('content')

<div class="container-fluid">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">
            <i class="fas fa-file-alt me-2"></i> Laporan Setoran Sampah
        </h4>
        <a href="{{ route('mitra.report.pdf') }}" class="btn btn-danger" target="_blank">
            <i class="fas fa-file-pdf me-2"></i> Export PDF
        </a>
    </div>

    <!-- CARD SUMMARY -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card card-custom text-white bg-primary p-3">
                <h6>Nama Bank</h6>
                <h4>{{ $bank->name ?? '-' }}</h4>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-custom text-white bg-success p-3">
                <h6>Total Transaksi</h6>
                <h3>{{ $totalDeposits ?? 0 }} Transaksi</h3>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-custom text-white bg-warning p-3">
                <h6>Total Berat Sampah</h6>
                <h3>{{ number_format($totalWeight ?? 0, 2) }} Kg</h3>
            </div>
        </div>
    </div>

    <!-- STATISTIK PER JENIS SAMPAH -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0">
                <i class="fas fa-chart-pie me-2"></i> Statistik per Jenis Sampah
            </h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Jenis Sampah</th>
                            <th>Jumlah Transaksi</th>
                            <th>Total Berat (Kg)</th>
                            <th>Persentase</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $no = 1; @endphp
                        @foreach($wasteTypeStats as $name => $stat)
                            @if($stat['count'] > 0)
                            <tr>
                                <td class="text-center">{{ $no++ }}</td>
                                <td>{{ $name }}</td>
                                <td class="text-center">{{ $stat['count'] }}</td>
                                <td class="text-center">{{ number_format($stat['weight'], 2) }} Kg</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="progress flex-grow-1 me-2" style="height: 8px;">
                                            <div class="progress-bar bg-success" 
                                                 style="width:{{ $totalWeight > 0 ? ($stat['weight'] / $totalWeight) * 100 : 0 }}%">
                                            </div>
                                        </div>
                                        <span>{{ number_format($totalWeight > 0 ? ($stat['weight'] / $totalWeight) * 100 : 0, 1) }}%</span>
                                    </div>
                                </td>
                            </tr>
                            @endif
                        @endforeach
                    </tbody>
                    <tfoot class="table-light">
                        <tr>
                            <th colspan="2" class="text-end">Total:</th>
                            <th class="text-center">{{ $totalDeposits }}</th>
                            <th class="text-center">{{ number_format($totalWeight, 2) }} Kg</th>
                            <th>100%</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <!-- TABEL DETAIL SETORAN -->
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0">
                <i class="fas fa-list me-2"></i> Detail Setoran Sampah
            </h5>
        </div>
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-hover align-middle" id="report-table">
                    <thead class="table-light text-center">
                        <tr>
                            <th>No</th>
                            <th>Tanggal Setor</th>
                            <th>Warga</th>
                            <th>Jenis Sampah</th>
                            <th>Berat (Kg)</th>
                            <th>Tanggal Verifikasi</th>
                        </tr>
                    </thead>

                    <tbody>
                    @forelse($deposits ?? [] as $index => $item)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="text-center">
                                {{ $item->deposit_date 
                                    ? \Carbon\Carbon::parse($item->deposit_date)->format('d M Y') 
                                    : '-' }}
                            </td>
                            <td>
                                <strong>{{ $item->user->name ?? 'Tidak ada' }}</strong><br>
                                <small class="text-muted">{{ $item->user->phone ?? '' }}</small>
                            </td>
                            <td>{{ $item->wasteType->name ?? 'Tidak ada' }}</td>
                            <td class="text-center">{{ number_format($item->weight_kg ?? 0, 2) }} Kg</td>
                            <td class="text-center">
                                {{ $item->updated_at 
                                    ? \Carbon\Carbon::parse($item->updated_at)->format('d M Y H:i') 
                                    : '-' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                <i class="fas fa-inbox fa-3x mb-3 d-block"></i>
                                Belum ada data setoran yang disetujui
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>

</div>

@endsection