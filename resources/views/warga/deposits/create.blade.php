@extends('template.layout')

@section('content')

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-7">

            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-body p-4">

                    <h4 class="mb-4 fw-semibold">
                        Catat Setoran Sampah
                    </h4>

                    <form method="POST" action="{{ route('deposits.store') }}">
                        @csrf

                        <div class="mb-3">
                            <label>Jenis Sampah</label>
                            <select name="waste_type_id" class="form-control" required>
                                <option value="">Pilih Jenis Sampah</option>
                                @foreach($wasteTypes as $type)
                                <option value="{{ $type->id }}"
                                    {{ old('waste_type_id') == $type->id ? 'selected' : '' }}>
                                    {{ $type->name }} ({{ number_format($type->reward_per_kg) }} poin/kg)
                                </option>
                                @endforeach
                            </select>
                        </div>

                       
                        <div class="mb-3">
                            <label class="form-label">Berat (kg)</label>
                            <input type="number" step="0.1" name="weight_kg" value="{{ old('weight_kg') }}"
                                class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tanggal Setor</label>
                            <input type="date" name="deposit_date" value="{{ old('deposit_date', date('Y-m-d')) }}"
                                class="form-control" required>
                        </div>

                        <!-- BANK -->
                        <div class="mb-3">
                            
                            @if($selectedBank)
                            <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-lg">
                                <p class="font-semibold text-green-800">Bank yang dipilih:</p>
                                <p><strong>{{ $selectedBank->name }}</strong><br>
                                    Alamat: {{ $selectedBank->address }}<br>
                                    Kontak: {{ $selectedBank->contact }}<br>
                                    Jam operasional: {{ $selectedBank->operation_hours }}</p>
                                <input type="hidden" name="bank_id" value="{{ $selectedBank->id }}">
                                <a href="{{ route('warga.pilih-bank') }}" class="text-blue-600 text-sm">Ganti bank</a>
                            </div>
                            @else
                            <div class="mb-4">
                                <label class="block text-gray-700 font-medium">Pilih Bank Sampah Tujuan</label>
                                <select name="bank_id" class="form-control" required>
                                    <option value="">-- Pilih Bank --</option>
                                    @foreach($banks as $bank)
                                    <option value="{{ $bank->id }}" {{ old('bank_id')==$bank->id ? 'selected' : '' }}>
                                        {{ $bank->name }} - {{ $bank->address }}
                                    </option>
                                    @endforeach
                                </select>
                                <p class="text-sm text-gray-500 mt-1">Atau <a href="{{ route('warga.pilih-bank') }}" class="text-blue-600">pilih
                                        bank dari peta</a>.</p>
                            </div>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Catatan (opsional)</label>
                            <textarea name="notes" class="form-control" rows="3">{{ old('notes') }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Foto URL (opsional)</label>
                            <input type="url" name="photo_url" value="{{ old('photo_url') }}" class="form-control">
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-success px-4">
                                Simpan
                            </button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>

@endsection