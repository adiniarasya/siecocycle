@extends('template/layout')
@section('title', 'Data User')
@section('content')
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="card">
    <div class="card-body table-responsive">
        <table class="table table-striped table-hover">
    <thead>
        <tr>
            <th>Id</th>
            <th>Nama Warga</th>
            <th>RW</th>
            <th>Email</th>
            <th>Phone</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($warga as $key => $w )
        <tr>
            <th>{{ $key + 1 }}</th>
            <th>{{ $w->name }}</th>
            <th>{{ $w->rw_name }}</th>
            <th>{{ $w->email }}</th>
            <th>{{ $w->phone }}</th>
        </tr>
        @endforeach
       
    </tbody>
</table>
    </div>
</div>

@endsection
