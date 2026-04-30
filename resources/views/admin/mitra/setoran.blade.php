@extends('template/layout')
@section('title', 'Data Setoran')
@section('content')

<div class="card">
    <div class="card-header">
        <h4>Data Setoran Disetujui</h4>
    </div>

    <div class="card-body table-responsive">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Warga</th>
                    <th>Jenis Sampah</th>
                    <th>Berat (Kg)</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($setoran as $key => $s)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $s->user->name ?? '-' }}</td>
                    <td>{{ $s->wasteType->name ?? '-' }}</td>
                    <td>{{ $s->weight_kg }} Kg</td>
                    <td>
                        <span class="badge badge-success">Verified</span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center">Tidak ada data</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection