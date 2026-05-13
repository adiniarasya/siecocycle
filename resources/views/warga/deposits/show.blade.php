@extends('template.layout')

@section('content')

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-7">

            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-body p-4">

                    <h4 class="mb-4 fw-semibold">
                        Detail Setoran
                    </h4>

                    <table class="table table-borderless">
                        <tr>
                            <th style="width: 150px;">Tanggal</th>
                            <td>{{ $deposit->deposit_date->format('d/m/Y') }}</td>
                        </tr>
                        <tr>
                            <th>Jenis</th>
                            <td>{{ $deposit->wasteType->name }}</td>
                        </tr>
                        <tr>
                            <th>Berat</th>
                            <td>{{ $deposit->weight_kg }} kg</td>
                        </tr>
                        <tr>
                            <th>Poin</th>
                            <td>
                                {{ $deposit->weight_kg * $deposit->wasteType->reward_per_kg }}
                            </td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                <span class="badge 
                                    @if($deposit->status == 'pending') bg-warning
                                    @elseif($deposit->status == 'approved') bg-success
                                    @else bg-secondary
                                    @endif">
                                    {{ ucfirst($deposit->status) }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>Catatan</th>
                            <td>{{ $deposit->notes ?? '-' }}</td>
                        </tr>
                    </table>

                    <!-- Foto -->
                    @if($deposit->photo_url)
                    <div class="mt-3">
                        <label class="fw-semibold mb-2">Foto:</label><br>
                        <img src="{{ $deposit->photo_url }}"
                            class="img-fluid rounded"
                            style="max-height: 200px;">
                    </div>
                    @endif

                    <!-- Button -->
                    <div class="mt-4 d-flex justify-content-between">
                        <a href="{{ route('warga.dashboard') }}" class="btn btn-secondary">
                            Kembali
                        </a>

                        @if($deposit->status == 'pending')
                        <a href="{{ route('deposits.edit', $deposit) }}"
                            class="btn btn-warning">
                            Edit
                        </a>
                        @endif
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

@endsection