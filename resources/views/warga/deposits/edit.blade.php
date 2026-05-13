@extends('template.layout')

@section('content')

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-7">

            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-body p-4">

                    <h4 class="mb-4 fw-semibold">
                        Edit Setoran
                    </h4>

                    <form method="POST" action="{{ route('deposits.update', $deposit) }}">
                        @csrf
                        @method('PUT')

                        <!-- Jenis Sampah -->
                        <div class="mb-3">
                            <label class="form-label">Jenis Sampah</label>
                            <select name="waste_type_id" class="form-control" required>
                                @foreach($wasteTypes as $t)
                                <option value="{{ $t->id }}" {{ $deposit->waste_type_id == $t->id ? 'selected' : '' }}>
                                    {{ $t->name }} ({{ number_format($t->reward_per_kg) }} poin/kg)
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Berat -->
                        <div class="mb-3">
                            <label class="form-label">Berat (kg)</label>
                            <input type="number" step="0.1" name="weight_kg" value="{{ $deposit->weight_kg }}"
                                class="form-control" required>
                        </div>

                        <!-- Tanggal -->
                        <div class="mb-3">
                            <label class="form-label">Tanggal</label>
                            <input type="date" name="deposit_date" value="{{ $deposit->deposit_date->format('Y-m-d') }}"
                                class="form-control" required>
                        </div>

                        <!-- Catatan -->
                        <div class="mb-4">
                            <label class="form-label">Catatan</label>
                            <textarea name="notes" class="form-control" rows="3">{{ $deposit->notes }}</textarea>
                        </div>

                        <!-- Button -->
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('warga.dashboard') }}" class="btn btn-secondary">
                                Kembali
                            </a>

                            <button type="submit" class="btn btn-primary">
                                Update
                            </button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>

@endsection