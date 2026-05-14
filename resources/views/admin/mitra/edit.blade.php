@extends('template.layout')
@section('title', 'Edit Bank & Data Mitra')
@section('content')

<div class="card">
    <div class="card-header">
        <h4>Edit Bank: {{ $bank->name }}</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.banks.update', $bank) }}" method="POST">
            @csrf @method('PUT')

            <h5>Data Mitra (User)</h5>
            <div class="form-group">
                <label>Nama Mitra</label>
                <input type="text" name="user_name" class="form-control"
                    value="{{ old('user_name', $user->name ?? '') }}" required>
            </div>
            <div class="form-group">
                <label>Email Mitra</label>
                <input type="email" name="email" class="form-control" value="{{ old('email', $user->email ?? '') }}"
                    required>
                <small class="text-muted">Email akan digunakan untuk login mitra.</small>
            </div>

            <hr>

            <h5>Data Bank Sampah</h5>
            <div class="form-group">
                <label>Nama Bank</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $bank->name) }}" required>
            </div>
            <div class="form-group">
                <label>Alamat Bank</label>
                <textarea name="address" class="form-control" rows="2">{{ old('address', $bank->address) }}</textarea>
            </div>
            <div class="form-group">
                <label>Kontak</label>
                <input type="text" name="contact" class="form-control" value="{{ old('contact', $bank->contact) }}">
            </div>
            <div class="form-group">
                <label>Jam Operasional</label>
                <input type="text" name="operation_hours" class="form-control"
                    value="{{ old('operation_hours', $bank->operation_hours) }}">
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('admin.mitra') }}" class="btn btn-secondary">Batal</a>
        </form>

        <hr>
        <p class="text-muted">Untuk mengatur lokasi (peta), gunakan menu <strong>Lokasi</strong> di halaman daftar
            bank.</p>
    </div>
</div>

@endsection