@extends('template.layout')

@section('title', 'Form Persetujuan Setoran')

@section('content')
<div class="container-fluid">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-success text-white">
            <h5 class="mb-0">Form Persetujuan Setoran Sampah</h5>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <form action="{{ route('mitra.approve.store') }}" method="POST">
                @csrf
                <input type="hidden" name="deposit_id" value="{{ $deposit->id ?? '' }}">
                <input type="hidden" name="status" value="verified">

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nama Warga</label>
                        <input type="text" class="form-control" value="{{ $deposit->user->name ?? '' }}" readonly>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Jenis Sampah</label>
                        <input type="text" class="form-control" value="{{ $deposit->wasteType->name ?? '' }}" readonly>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Berat Sampah (Kg)</label>
                        <input type="text" class="form-control" value="{{ $deposit->weight_kg ?? 0 }}" readonly>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tanggal Setor</label>
                        <input type="text" class="form-control" value="{{ $deposit->deposit_date ? \Carbon\Carbon::parse($deposit->deposit_date)->format('d M Y') : '-' }}" readonly>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label class="form-label">Poin yang Didapat</label>
                        <div class="alert alert-info">
                            <strong>{{ number_format(($deposit->weight_kg ?? 0) * ($deposit->wasteType->reward_per_kg ?? 0)) }} Poin</strong>
                            <small>({{ $deposit->weight_kg ?? 0 }} Kg × {{ $deposit->wasteType->reward_per_kg ?? 0 }} poin/kg)</small>
                        </div>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label class="form-label">Catatan (Opsional)</label>
                        <textarea name="notes" class="form-control" rows="3" placeholder="Tambahkan catatan jika diperlukan..."></textarea>
                    </div>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('mitra.dashboard') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-check"></i> Konfirmasi Setuju
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection