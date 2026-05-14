@extends('template.layout')
@section('title', 'Data Mitra')
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
            <div class="card-header">
                <h4>Request Mitra</h4>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pending as $key => $m)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $m->name }}</td>
                            <td>{{ $m->email }}</td>
                            <td>
                                <form action="{{ route('admin.mitra.approve', $m->id) }}" method="POST">
                                    @csrf
                                    <button class="btn btn-success btn-sm">Approve</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center">Tidak ada mitra pending</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4>Mitra Approved</h4>
            </div>
            <div class="card table-responsive">
                <table class="table table-striped table-hover" style="min-width: 900px;">
                    <thead>
                        <tr>
                            <th style="width: 5%">No</th>
                            <th style="width: 12%">Nama Mitra</th>
                            <th style="width: 12%">Email</th>
                            <th style="width: 30%">Alamat</th>
                            <th style="width: 8%">Kontak</th>
                            <th style="width: 15%">Jam Operasional</th>
                            <th style="width: 8%">Lokasi</th>
                            <th style="width: 10%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($approved as $key => $p)
                        @php
                        $bank = $p->bank;
                        @endphp
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $p->name }}</td>
                            <td>{{ $p->email }}</td>
                            <td>{{ $bank ? \Illuminate\Support\Str::limit($bank->address, 50, '...') : '-' }}</td>
                            <td>{{ $bank ? $bank->contact : '-' }}</td>
                            <td>{{ $bank ? \Illuminate\Support\Str::limit($bank->operation_hours, 35, '...') : '-' }}</td>
                            <td>
                                @if($bank && $bank->latitude && $bank->longitude)
                                <span class="badge badge-success">Tersedia</span>
                                @elseif($bank)
                                <span class="badge badge-warning">Belum</span>
                                @else
                                -
                                @endif
                            </td>
                            <td>
                                @if($bank)
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('admin.banks.edit', $bank->id) }}" class="btn btn-info">Edit Bank</a>
                                    <a href="{{ route('admin.banks.location', $bank->id) }}" class="btn btn-primary">Lokasi</a>
                                    <form action="{{ route('admin.banks.destroy', $bank->id) }}" method="POST" class="d-inline"
                                        onsubmit="return confirm('Yakin hapus?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-danger">Hapus</button>
                                    </form>
                                </div>
                                @else
                                <span class="text-muted">-</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center">Belum ada mitra di-approve</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection