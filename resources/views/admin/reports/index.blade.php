@extends('template.layout')

@section('title', 'Laporan Komunitas RW')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4>Filter Laporan</h4>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('admin.reports.index') }}" class="row">
                    <div class="form-group col-md-4">
                        <label>Nama RW</label>
                        <input type="text" name="rw_name" class="form-control" value="{{ $rwName }}"
                            placeholder="Contoh: RW 05" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label>Periode Mulai</label>
                        <input type="date" name="period_start" class="form-control" value="{{ $startDate }}" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label>Periode Selesai</label>
                        <input type="date" name="period_end" class="form-control" value="{{ $endDate }}" required>
                    </div>
                    <div class="form-group col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary btn-block">Tampilkan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-4 col-md-6 col-sm-12">
        <div class="card card-statistic-2">
            <div class="card-icon shadow-primary bg-primary">
                <i class="fas fa-trash-alt"></i>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <h4>Total Sampah</h4>
                </div>
                <div class="card-body">
                    {{ number_format($totalWeight, 1) }} kg
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-6 col-sm-12">
        <div class="card card-statistic-2">
            <div class="card-icon shadow-primary bg-success">
                <i class="fas fa-leaf"></i>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <h4>Pengurangan CO₂</h4>
                </div>
                <div class="card-body">
                    {{ number_format($totalCo2, 1) }} kg
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-6 col-sm-12">
        <div class="card card-statistic-2">
            <div class="card-icon shadow-primary bg-warning">
                <i class="fas fa-money-bill-wave"></i>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <h4>Penghematan Biaya</h4>
                </div>
                <div class="card-body">
                    Rp {{ number_format($totalSaving, 0, ',', '.') }}
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4>Grafik Sampah per Jenis</h4>
            </div>
            <div class="card-body">
                <canvas id="wasteChart" height="120"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4>Detail Setoran</h4>
                <div class="card-header-action">
                    <a href="{{ route('admin.reports.pdf', ['rw_name' => $rwName, 'period_start' => $startDate, 'period_end' => $endDate]) }}"
                        class="btn btn-danger btn-icon icon-left">
                        <i class="fas fa-file-pdf"></i> Download PDF
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="table-1">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Warga</th>
                                <th>Jenis Sampah</th>
                                <th>Berat (kg)</th>
                                <th>CO₂ (kg)</th>
                                <th>Poin</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($details ?? [] as $d)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($d->deposit_date)->format('d/m/Y') }}</td>
                                <td>{{ $d->user->name }}</td>
                                <td>{{ $d->wasteType->name }}</td>
                                <td>{{ number_format($d->weight_kg, 2) }}</td>
                                <td>{{ number_format($d->co2_saved ?? $d->weight_kg *
                                    $d->wasteType->co2_factor, 2) }}</td>
                                <td>{{ number_format($d->points ?? $d->weight_kg *
                                    $d->wasteType->reward_per_kg, 0) }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center">Tidak ada data setoran untuk periode
                                    ini.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
          const ctx = document.getElementById('wasteChart').getContext('2d');
          const chartData = @json($chartData);
          new Chart(ctx, {
              type: 'bar',
              data: {
                  labels: chartData.map(item => item.name),
                  datasets: [{
                      label: 'Berat Sampah (kg)',
                      data: chartData.map(item => item.total),
                      backgroundColor: 'rgba(54, 162, 235, 0.5)',
                      borderColor: 'rgba(54, 162, 235, 1)',
                      borderWidth: 1
                  }]
              },
              options: {
                  responsive: true,
                  scales: {
                      y: {
                          beginAtZero: true,
                          title: { display: true, text: 'Berat (kg)' }
                      },
                      x: {
                          title: { display: true, text: 'Jenis Sampah' }
                      }
                  }
              }
          });
      });
</script>
@endpush