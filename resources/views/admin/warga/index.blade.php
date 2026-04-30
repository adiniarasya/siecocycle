@extends('template/layout')
@section('title', 'Data Mitra')
@section('content')
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Id</th>
            <th>Warga</th>
            <th>Jenis</th>
            <th>Berat</th>
            <th>Tanggal</th>
        </tr>
    </thead>
    <tbody>
        @forelse($warga as $key => $w)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $w->name }}</td>
                <td>{{ $w->email }}</td>
                <td>
                    <form action="{{ route('admin.mitra.approve', $w->id) }}" method="POST">
                        @csrf
                        <button class="btn btn-success btn-sm">
                            Approve
                        </button>
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
@endsection
