@extends('template/layout')
@section('content')
@section('title', 'Dashboard')
<div class="row mb-5">
    
    <div class="col-lg-4 col-md-6 col-12 mb-4">
        <div class="card text-white bg-primary h-100">
            <div class="card-body d-flex align-items-center">
                <div class="mr-3">
                    <i class="fas fa-trash"></i>
                </div>
                <div>
                    <div>Total Setoran</div>
                    <h4>{{$totalVerified}}</h4>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4 col-md-6 col-12 mb-4">
        <div class="card text-white bg-success h-100">
            <div class="card-body d-flex align-items-center">
                <div class="mr-3">
                    <i class="fas fa-recycle"></i>
                </div>
                <div>
                    <div>Sampah Terkelola</div>
                    <h4>{{$totalsampah}} Kg</h4>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4 col-md-6 col-12 mb-4">
        <div class="card text-white bg-primary h-100">
            <div class="card-body d-flex align-items-center">
                <div class="mr-3">
                    <i class="fas fa-trash"></i>
                </div>
                <div>
                    <div>Pengguna Aktif</div>
                    <h4>{{$totalpengguna}}</h4>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4 col-md-6 col-12 mb-4">
        <div class="card text-white bg-warning h-100">
            <div class="card-body d-flex align-items-center">
                <div class="mr-3">
                    <i class="fas fa-trash"></i>
                </div>
                <div>
                    <div>Bank Sampah</div>
                    <h4>{{ $totalmitra }}</h4>
                </div>
            </div>
        </div>
    </div>

</div>
<div class="card">
    <div class="card-header">
        <h4>Semua Pengguna</h4>
    </div>

    <div class="card-body table-responsive">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Role</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $key => $u)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $u->name }}</td>
                    <td>{{ $u->email }}</td>
                    <td>{{ $u->phone }}</td>
                    <td>{{ $u->role }}</td>
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