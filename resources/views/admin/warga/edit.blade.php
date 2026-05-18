@extends('template/layout')
@section('title', 'Edit User Warga')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card shadow-sm">
            <div class="card-header">
                <h4 class="mb-0">Edit Data User</h4>
            </div>
            <form action="{{ route('admin.user.update', $editdatauser->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">Nama</label>
                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{$editdatauser->name}}">
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" id="email"  class="form-control @error('email') is-invalid @enderror"  value="{{$editdatauser->email}}">
                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="telpon" class="form-label">Telpon</label>
                            <input type="text" name="telpon"  id="telpon" class="form-control @error('telpon') is-invalid @enderror"   value="{{$editdatauser->phone}}">
                            @error('telpon')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="rw" class="form-label">RW</label>
                            <input type="text" name="rw" id="rw" placeholder="Contoh: rw 09" class="form-control @error('rw') is-invalid @enderror" value="{{$editdatauser->rw_name}}">
                            @error('rw')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-12 mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror">
                            @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{ route('admin.datawarga') }}" class="btn btn-secondary">Back</a>
                    <button type="submit" class="btn btn-primary ">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection