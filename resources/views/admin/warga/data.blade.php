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
            <th>Aksi</th>

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

            <td>
                <form action ="{{ route('admin.user.destroy', $w->id) }}" method="POST" style="display:inline">
                    {{ csrf_field() }}
                    @method('DELETE')
                    <a href="{{ route('admin.user.edit', $w->id) }}" class="btn btn-success btn-sm"><i class="far fa-edit"></i></a>
                    <button type="submit" onclick="return confirm('Are you sure want to delete this user?')" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button>
                </form>
            </td>
        </tr>
        @endforeach
       
    </tbody>
</table>
    </div>
</div>

@endsection
