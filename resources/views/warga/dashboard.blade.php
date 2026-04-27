@extends('template.layout')

@section('title', 'Dashboard')

@section('content')

<div class="row align-items-stretch mb-5">

    <!-- TOTAL SAMPAH -->
    <div class="col-lg-4 col-md-6 col-12">
        <div class="card text-white bg-primary h-100">
            <div class="card-body d-flex align-items-center">
                <div class="mr-3">
                    <i class="fas fa-trash"></i>
                </div>
                <div>
                    <div>Total Sampah</div>
                    <h4>{{ $totalBerat }} Kg</h4>
                </div>
            </div>
        </div>
    </div>

    <!-- CO2 -->
    <div class="col-lg-4 col-md-6 col-12">
        <div class="card text-white bg-danger h-100">
            <div class="card-body d-flex align-items-center">
                <div class="mr-3">
                    <i class="fas fa-cloud"></i>
                </div>
                <div>
                    <div>Total CO₂</div>
                    <h4>{{ $totalCO2 }} Kg</h4>
                </div>
            </div>
        </div>
    </div>

    <!-- POIN -->
    <div class="col-lg-4 col-md-6 col-12">
        <div class="card text-white bg-warning h-100">
            <div class="card-body d-flex align-items-center">
                <div class="mr-3">
                    <i class="fas fa-coins"></i>
                </div>
                <div>
                    <div>Total Poin</div>
                    <h4>{{ $totalPoin }}</h4>
                </div>
            </div>
        </div>
    </div>

</div>

<div class="card">
    <div class="card-header d-flex align-items-center">
        <h4 class="mb-0">Riwayat Setoran</h4>

        <a href="{{ route('deposits.create') }}" class="btn btn-primary btn-sm ml-auto">
            <i class="fas fa-plus"></i> Catat Setoran
        </a>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-striped mb-0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Jenis</th>
                        <th>Berat</th>
                        <th>Poin</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($deposits as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>

                        <!-- FORMAT TANGGAL -->
                        <td>{{ \Carbon\Carbon::parse($item->deposit_date)->format('d M Y') }}</td>

                        <td>{{ $item->wasteType->name }}</td>

                        <td>{{ $item->weight_kg }} Kg</td>

                        <td>
                            {{ $item->weight_kg * $item->wasteType->reward_per_kg }}
                        </td>

                        <!-- STATUS -->
                        <td>
                            @if($item->status == 'pending')
                            <span class="badge bg-warning text-dark">Pending</span>
                            @elseif($item->status == 'verified')
                            <span class="badge bg-success">Verified</span>
                            @else
                            <span class="badge bg-danger">Rejected</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">
                            Belum ada data setoran
                        </td>
                    </tr>
                    @endforelse
                </tbody>

            </table>
        </div>
    </div>
</div>

@endsection