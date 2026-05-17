@extends('template/layout')
@section('title', 'Data User')
@section('content')
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="card">
    <div class="table-responsive">
        <table class="table table-striped table-hover">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Warga</th>
            <th>RW</th>
            <th>Email</th>
            <th>Phone</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($warga as $key => $w )
        <tr>
            <td>{{ $key + 1 }}</td>
            <td>{{ $w->name }}</td>
            <td>{{ $w->rw_name }}</td>
            <td>{{ $w->email }}</td>
            <td>{{ $w->phone }}</td>
            </td>
        </tr>
        @endforeach
       
    </tbody>
</table>
    </div>
</div>

@endsection
