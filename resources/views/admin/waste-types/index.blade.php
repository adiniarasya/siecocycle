@extends('template.layout')
@section('title', 'Master Waste Type')
@section('content')

@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif
@if(session('error'))
<div class="alert alert-danger">
    {{ session('error') }}
</div>
@endif

<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4>Data Waste Type</h4>
                <a href="{{ route('admin.waste-types.create') }}" class="btn btn-primary btn-sm">
                    Tambah Waste Type
                </a>
            </div>
            <div class="card-body">
                <!-- Filter -->
                <form method="GET" class="row mb-3">
                    <div class="col-md-4">
                        <input type="text" name="search" class="form-control" placeholder="Cari nama waste type..." 
                               value="{{ request('search') }}">
                    </div>
                    <div class="col-md-3">
                        <select name="status" class="form-control">
                            <option value="">Semua Status</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary">Filter</button>
                        <a href="{{ route('admin.waste-types.index') }}" class="btn btn-secondary">Reset</a>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th style="width: 5%">No</th>
                                <th style="width: 25%">Nama Waste Type</th>
                                <th style="width: 20%">CO2 Factor</th>
                                <th style="width: 20%">Reward / Kg</th>
                                <th style="width: 10%">Status</th>
                                <th style="width: 10%">Total Deposit</th>
                                <th style="width: 10%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($wasteTypes as $key => $wt)
                            <tr>
                                <td>{{ $wasteTypes->firstItem() + $key }}</td>
                                <td><strong>{{ $wt->name }}</strong></td>
                                <td>{{ number_format($wt->co2_factor, 4) }} CO₂/kg</td>
                                <td>Rp {{ number_format($wt->reward_per_kg, 0, ',', '.') }}</td>
                                <td>
                                    @if($wt->is_active)
                                        <span class="badge badge-success">Aktif</span>
                                    @else
                                        <span class="badge badge-secondary">Nonaktif</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge {{ $wt->deposits_count > 0 ? 'badge-warning' : 'badge-secondary' }}">
                                        {{ $wt->deposits_count }}
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ route('admin.waste-types.edit', $wt->id) }}" class="btn btn-info btn-sm">Edit</a>
                                        
                                        @if($wt->is_active)
                                            <form action="{{ route('admin.waste-types.toggle-status', $wt->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-warning btn-sm" onclick="return confirm('Nonaktifkan {{ $wt->name }}?')">
                                                    Nonaktifkan
                                                </button>
                                            </form>
                                        @else
                                            <form action="{{ route('admin.waste-types.toggle-status', $wt->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('Aktifkan {{ $wt->name }}?')">
                                                    Aktifkan
                                                </button>
                                            </form>
                                        @endif
                                        
                                        @if($wt->deposits_count == 0)
                                            <form action="{{ route('admin.waste-types.destroy', $wt->id) }}" method="POST" class="d-inline"
                                                onsubmit="return confirm('Yakin hapus {{ $wt->name }}?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger btn-sm">Hapus</button>
                                            </form>
                                        @else
                                            <button class="btn btn-secondary btn-sm" disabled title="Tidak bisa hapus, sudah dipakai di deposit">
                                                Hapus
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center">Belum ada data Waste Type</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-end mt-3">
                    {{ $wasteTypes->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection