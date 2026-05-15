@extends('template.layout')

@section('title', 'Dashboard')

@section('content')

<!-- CARD STAT -->
<div class="row g-3 mb-4">

    <div class="col-lg-4 col-md-6">
        <div class="card text-white bg-primary h-100 shadow-sm">
            <div class="card-body d-flex align-items-center gap-3">
                <i class="fas fa-recycle fa-2x"></i>
                <div>
                    <div>Total Sampah</div>
                    <h4 class="mb-0">{{ $totalBerat }} Kg</h4>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4 col-md-6">
        <div class="card text-white bg-danger h-100 shadow-sm">
            <div class="card-body d-flex align-items-center gap-3">
                <i class="fas fa-cloud fa-2x"></i>
                <div>
                    <div>Total CO₂</div>
                    <h4 class="mb-0">{{ $totalCO2 }} Kg</h4>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4 col-md-6">
        <div class="card text-dark bg-warning h-100 shadow-sm">
            <div class="card-body d-flex align-items-center gap-3">
                <i class="fas fa-coins fa-2x"></i>
                <div>
                    <div>Total Poin</div>
                    <h4 class="mb-0">{{ $totalPoin }}</h4>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- CARD TABLE -->
<div class="card shadow-sm">

    <!-- HEADER -->
    <div class="card-header d-flex justify-content-between align-items-center">

        <h5 class="mb-0">Riwayat Setoran</h5>

        <div class="d-flex gap-2">

            <a href="/ai-scan" class="btn btn-info btn-sm">
                <i class="fas fa-camera"></i> AI Scan
            </a>

            <a href="{{ route('deposits.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Catat Setoran
            </a>

        </div>

    </div>

    <!-- BODY -->
    <div class="card-body p-0">

        <div class="table-responsive">
            <table class="table table-striped mb-0 text-center align-middle">

                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Jenis</th>
                        <th>Berat</th>
                        <th>Poin</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($deposits as $index => $item)
                    <tr>

                        <td>{{ $index + 1 }}</td>

                        <td>{{ \Carbon\Carbon::parse($item->deposit_date)->format('d M Y') }}</td>

                        <td>{{ $item->wasteType->name }}</td>

                        <td>{{ $item->weight_kg }} Kg</td>

                        <td>{{ $item->weight_kg * $item->wasteType->reward_per_kg }}</td>

                       
                        <td>
                            @if($item->status == 'pending')
                            <span class="badge bg-warning text-dark">Pending</span>
                            @elseif($item->status == 'verified')
                            <span class="badge bg-success">Verified</span>
                            @else
                            <span class="badge bg-danger">Rejected</span>
                            @endif
                        </td>

                       
                        <td>
                            <div class="d-flex justify-content-center gap-2">

                                <a href="{{ route('deposits.show', $item->id) }}"
                                    class="btn btn-info btn-sm text-white" data-bs-toggle="tooltip" title="Detail">
                                    <i class="fas fa-eye"></i>
                                </a>

                                @if($item->status == 'pending')
                                <a href="{{ route('deposits.edit', $item->id) }}" class="btn btn-warning btn-sm"
                                    data-bs-toggle="tooltip" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @endif

                                <form action="{{ route('deposits.destroy', $item->id) }}" method="POST"
                                    onsubmit="return confirm('Yakin hapus data ini?')">
                                    @csrf
                                    @method('DELETE')

                                    <button class="btn btn-danger btn-sm" data-bs-toggle="tooltip" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>

                            </div>
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4">
                            Belum ada data setoran
                        </td>
                    </tr>
                    @endforelse
                </tbody>

            </table>
            {{ $deposits->links() }}
        </div>

    </div>
</div>


<script>
document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(el => {
    new bootstrap.Tooltip(el)
});
</script>

@endsection