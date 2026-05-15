@extends('template.layout')
@section('title', 'Edit Waste Type')
@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.waste-types.update', $wasteType->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="form-group row mb-3">
                        <label for="name" class="col-sm-3 col-form-label">Nama Waste Type <span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name', $wasteType->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="form-group row mb-3">
                        <label for="co2_factor" class="col-sm-3 col-form-label">CO2 Factor (kg CO₂/kg) <span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <input type="number" step="0.0001" class="form-control @error('co2_factor') is-invalid @enderror" 
                                   id="co2_factor" name="co2_factor" value="{{ old('co2_factor', $wasteType->co2_factor) }}" required>
                            <small class="form-text text-muted">Contoh: 0.5 (1 kg sampah = 0.5 kg CO₂)</small>
                            @error('co2_factor')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="form-group row mb-3">
                        <label for="reward_per_kg" class="col-sm-3 col-form-label">Reward per Kg (Rp) <span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <input type="number" step="100" class="form-control @error('reward_per_kg') is-invalid @enderror" 
                                   id="reward_per_kg" name="reward_per_kg" value="{{ old('reward_per_kg', $wasteType->reward_per_kg) }}" required>
                            <small class="form-text text-muted">Contoh: 2000 (1 kg = Rp 2.000)</small>
                            @error('reward_per_kg')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="form-group row mb-3">
                        <label class="col-sm-3 col-form-label">Status</label>
                        <div class="col-sm-9">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="is_active" 
                                       name="is_active" value="1" {{ old('is_active', $wasteType->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">
                                    Aktif
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <div class="col-sm-9 offset-sm-3">
                            <button type="submit" class="btn btn-primary">Update</button>
                            <a href="{{ route('admin.waste-types.index') }}" class="btn btn-secondary">Batal</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection