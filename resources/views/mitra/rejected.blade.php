@extends('template.layout')

@section('title', 'Setoran Ditolak - Bank Sampah')

@section('content')

<div class="container-fluid">

    <!-- CARD SUMMARY -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card card-custom text-white bg-danger p-3">
                <h6>Total Setoran Ditolak</h6>
                <h3>{{ $totalRejected ?? 0 }} Transaksi</h3>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card card-custom text-white bg-warning p-3">
                <h6>Total Berat Sampah</h6>
                <h3>{{ number_format($totalWeight ?? 0, 2) }} Kg</h3>
            </div>
        </div>
    </div>

    <!-- TABLE -->
    <div class="card shadow-sm border-0">
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light text-center">
                        <tr>
                            <th>No</th>
                            <th>Warga</th>
                            <th>Jenis Sampah</th>
                            <th>Berat (Kg)</th>
                            <th>Tanggal Setor</th>
                            <th>Tanggal Penolakan</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>
                    @forelse($rejectedDeposits ?? [] as $index => $item)
                        <tr>
                            <td class="text-center">{{ $rejectedDeposits->firstItem() + $index }}</td>
                            <td>
                                <strong>{{ $item->user->name ?? 'Tidak ada' }}</strong><br>
                                <small class="text-muted">{{ $item->user->email ?? '' }}</small>
                            </td>
                            <td>{{ $item->wasteType->name ?? 'Tidak ada' }}</td>
                            <td class="text-center">{{ number_format($item->weight_kg ?? 0, 2) }} Kg</td>
                            <td class="text-center">
                                {{ $item->deposit_date 
                                    ? \Carbon\Carbon::parse($item->deposit_date)->format('d M Y H:i') 
                                    : '-' }}
                            </td>
                            <td class="text-center">
                                {{ $item->updated_at 
                                    ? \Carbon\Carbon::parse($item->updated_at)->format('d M Y H:i') 
                                    : '-' }}
                            </td>
                            <td class="text-center">
                                <span class="badge bg-danger px-3 py-2">
                                    <i class="fas fa-times me-1"></i> Ditolak
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                <i class="fas fa-inbox fa-3x mb-3 d-block"></i>
                                Belum ada data setoran yang ditolak
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-3">
                {{ $rejectedDeposits->links() }}
            </div>

        </div>
    </div>

</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

@endsection