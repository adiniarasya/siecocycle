@extends('template.layout')

@section('title', 'Dashboard')

@section('content')
    <!-- CARD STATISTIK -->
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

    <!-- FILTER SECTION -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-light">
            <h6 class="mb-0"><i class="fas fa-filter"></i> Filter Data</h6>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('warga.dashboard') }}" id="filterForm">
                <div class="row g-3 align-items-end">
                    <div class="col-md-2">
                        <label for="start_date" class="form-label">Dari Tanggal</label>
                        <input type="date" name="start_date" id="start_date" class="form-control"
                            value="{{ request('start_date') }}">
                    </div>

                    <div class="col-md-2">
                        <label for="end_date" class="form-label">Sampai Tanggal</label>
                        <input type="date" name="end_date" id="end_date" class="form-control"
                            value="{{ request('end_date') }}">
                    </div>

                    <div class="col-md-3">
                        <label for="waste_type" class="form-label">Jenis Sampah</label>
                        <select name="waste_type" id="waste_type" class="form-control">
                            <option value="">Semua Jenis</option>
                            @foreach($wasteTypes as $type)
                                <option value="{{ $type->id }}" {{ request('waste_type') == $type->id ? 'selected' : '' }}>
                                    {{ $type->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label for="status" class="form-label">Status</label>
                        <select name="status" id="status" class="form-control">
                            <option value="">Semua Status</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="verified" {{ request('status') == 'verified' ? 'selected' : '' }}>Verified</option>
                            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                        </select>
                    </div>

                    <div class="d-flex col-md-2 gap-3">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-search"></i>
                        </button>
                        <a href="{{ route('warga.dashboard') }}" class="btn btn-secondary w-100">
                            <i class="fas fa-undo"></i>
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- TABLE RIWAYAT SETORAN -->
    <div class="card shadow-sm">
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
                                <td>{{ $index + $deposits->firstItem() }}</td>
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
                                            <a href="{{ route('deposits.edit', $item->id) }}"
                                                class="btn btn-warning btn-sm" data-bs-toggle="tooltip" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        @endif

                                        <form action="{{ route('deposits.destroy', $item->id) }}" method="POST"
                                            onsubmit="return confirm('Yakin hapus data ini?')" class="d-inline">
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
                <div class="d-flex justify-content-center mt-3">
                    {{ $deposits->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });
    });
</script>
@endpush