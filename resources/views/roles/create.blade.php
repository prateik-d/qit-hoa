@extends('layouts.master')

@section('content')
<div class="container">
    @if ($message = Session::get('success'))
    <div class="alert alert-success">
        <p>{{ $message }}</p>
    </div>
    @endif
    @if ($message = Session::get('failed'))
    <div class="alert alert-danger">
        <p>{{ $message }}</p>
    </div>
    @endif
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Add role</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('role.store') }}">
                    @csrf
                    <div class="form-group">
                        <label for="role" class="form-label">Role</label>
                        <input value="{{ old('role_type') }}" type="text" class="form-control" name="role_type" placeholder="Role" required>

                        @if ($errors->has('role_type'))
                            <span class="text-danger text-left">{{ $errors->first('role_type') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <div class='pull-right'>
                            <button type="submit" class="btn btn-primary">Save</button>
                            <a href="{{ route('roles') }}" class="btn btn-default">Back</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection