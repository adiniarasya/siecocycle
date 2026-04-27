@extends('template.layout')

@section('content')

<div class="container mt-4">

    <div class="card">
        <div class="card-header">
            <h4>Tambah Setoran</h4>
        </div>

        <div class="card-body">

            <form action="{{ route('deposits.store') }}" method="POST">
                @csrf

                <!-- Jenis Sampah -->
                <div class="form-group mb-3">
                    <label>Jenis Sampah</label>
                    <select name="waste_type_id" class="form-control">
                        <option value="">-- Pilih Jenis --</option>
                        @foreach($wasteTypes as $type)
                        <option value="{{ $type->id }}">
                            {{ $type->name }}
                            ({{ $type->reward_per_kg }} poin/kg | {{ $type->co2_factor }} CO2)
                        </option>
                        @endforeach
                    </select>
                </div>

                <!-- Berat -->
                <div class="form-group mb-3">
                    <label>Berat (kg)</label>
                    <input type="number" name="weight_kg" class="form-control" placeholder="Masukkan berat">
                </div>

                <!-- Tanggal -->
                <div class="form-group mb-3">
                    <label>Tanggal</label>
                    <input type="date" name="deposit_date" class="form-control">
                </div>

                <!-- Button -->
                <div class="d-flex">
                    <button type="submit" class="btn btn-primary">
                        Simpan
                    </button>

                    <a href="{{ route('warga.index') }}" class="btn btn-secondary ml-2">
                        Kembali
                    </a>
                </div>

            </form>

        </div>
    </div>

</div>

@endsection